<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Salary;
use App\Models\TeacherWorkload;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Teacher::withCount('groups');
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('specialization')) {
                $query->where('specializations', 'like', "%{$request->specialization}%");
            }
            
            $teachers = $query->latest()->paginate(20);
            return view('admin.teachers.index', compact('teachers'));
        } catch (\Exception $e) {
            return view('admin.teachers.index', ['teachers' => collect()->paginate()]);
        }
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:teachers',
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string',
                'specializations' => 'required|string',
                'education' => 'nullable|string',
                'hourly_rate' => 'required|numeric|min:0',
                'hire_date' => 'required|date',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('teachers', 'public');
            }

            $validated['branch_id'] = session('current_branch_id');
            Teacher::create($validated);
            return redirect()->route('admin.teachers.index')->with('success', 'O\'qituvchi muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Teacher $teacher)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $teacher->id,
                'first_name' => $teacher->first_name,
                'last_name' => $teacher->last_name,
                'email' => $teacher->email,
                'phone' => $teacher->phone,
                'address' => $teacher->address,
                'specializations' => $teacher->specializations,
                'education' => $teacher->education,
                'hourly_rate' => $teacher->hourly_rate,
                'hire_date' => $teacher->hire_date?->format('Y-m-d'),
                'status' => $teacher->status,
            ]);
        }
        
        $teacher->load('groups.course');
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:teachers,email,' . $teacher->id,
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string',
                'specializations' => 'required|string',
                'education' => 'nullable|string',
                'hourly_rate' => 'required|numeric|min:0',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('photo')) {
                if ($teacher->photo) {
                    Storage::disk('public')->delete($teacher->photo);
                }
                $validated['photo'] = $request->file('photo')->store('teachers', 'public');
            }

            $teacher->update($validated);
            return redirect()->route('admin.teachers.index')->with('success', 'O\'qituvchi ma\'lumotlari yangilandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Yangilashda xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'O\'qituvchi o\'chirildi.');
    }

    public function workload(Teacher $teacher)
    {
        $workloads = TeacherWorkload::where('teacher_id', $teacher->id)
            ->with(['group.course'])
            ->where('is_active', true)
            ->get();
            
        $availableGroups = Group::with('course')->get();
        
        return view('admin.teachers.workload', compact('teacher', 'workloads', 'availableGroups'));
    }

    public function storeWorkload(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'weekly_hours' => 'required|integer|min:1|max:40',
            'start_date' => 'required|date',
        ]);

        TeacherWorkload::create([
            'teacher_id' => $teacher->id,
            'group_id' => $validated['group_id'],
            'weekly_hours' => $validated['weekly_hours'],
            'start_date' => $validated['start_date'],
            'notes' => $request->notes,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Yuklama qo\'shildi.');
    }

    public function salary(Teacher $teacher)
    {
        try {
            $currentMonth = Carbon::now()->format('Y-m');
            $salaries = Salary::where('teacher_id', $teacher->id)
                ->orderBy('salary_month', 'desc')
                ->paginate(12);
                
            $totalWorkload = TeacherWorkload::where('teacher_id', $teacher->id)
                ->where('is_active', true)
                ->sum('weekly_hours');
                
            return view('admin.teachers.salary', compact('teacher', 'salaries', 'totalWorkload', 'currentMonth'));
        } catch (\Exception $e) {
            return view('admin.teachers.salary', [
                'teacher' => $teacher,
                'salaries' => collect(),
                'totalWorkload' => 0,
                'currentMonth' => Carbon::now()->format('Y-m')
            ]);
        }
    }

    public function calculateSalary(Request $request, Teacher $teacher)
    {
        try {
            $validated = $request->validate([
                'salary_month' => 'required|date_format:Y-m',
                'bonus' => 'nullable|numeric|min:0',
                'deduction' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            $month = Carbon::createFromFormat('Y-m', $validated['salary_month']);
            
            $totalHours = TeacherWorkload::where('teacher_id', $teacher->id)
                ->where('is_active', true)
                ->where('start_date', '<=', $month->endOfMonth())
                ->where(function($q) use ($month) {
                    $q->whereNull('end_date')
                      ->orWhere('end_date', '>=', $month->startOfMonth());
                })
                ->sum('weekly_hours') * 4;

            $baseSalary = $totalHours * ($teacher->hourly_rate ?? 0);
            $bonus = $validated['bonus'] ?? 0;
            $deduction = $validated['deduction'] ?? 0;
            $finalAmount = $baseSalary + $bonus - $deduction;

            Salary::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'salary_month' => $month->format('Y-m-01'),
                ],
                [
                    'base_salary' => $baseSalary,
                    'hourly_rate' => $teacher->hourly_rate ?? 0,
                    'total_hours' => $totalHours,
                    'bonus' => $bonus,
                    'deduction' => $deduction,
                    'final_amount' => $finalAmount,
                    'notes' => $validated['notes'],
                ]
            );

            return redirect()->back()->with('success', 'Maosh hisoblandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Maosh hisoblashda xatolik: ' . $e->getMessage());
        }
    }

    public function salaryReport()
    {
        try {
            $currentMonth = Carbon::now()->format('Y-m-01');
            $salaries = Salary::with('teacher')
                ->where('salary_month', $currentMonth)
                ->get();
                
            $totalSalary = $salaries->sum('final_amount');
            
            return view('admin.teachers.salary-report', compact('salaries', 'totalSalary', 'currentMonth'));
        } catch (\Exception $e) {
            return view('admin.teachers.salary-report', [
                'salaries' => collect(),
                'totalSalary' => 0,
                'currentMonth' => Carbon::now()->format('Y-m-01')
            ]);
        }
    }

    public function endWorkload(Teacher $teacher, TeacherWorkload $workload)
    {
        $workload->update([
            'is_active' => false,
            'end_date' => Carbon::now()
        ]);
        
        return redirect()->back()->with('success', 'Yuklama tugatilib qo\'yildi.');
    }

    public function salaryExport(Request $request)
    {
        $format = $request->get('format', 'excel');
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        
        $salaries = Salary::with('teacher')
            ->where('salary_month', $month . '-01')
            ->get();
            
        if ($format === 'pdf') {
            return $this->exportToPdf($salaries, $month);
        } else {
            return $this->exportToExcel($salaries, $month);
        }
    }
    
    private function exportToExcel($salaries, $month)
    {
        $filename = 'maosh_hisoboti_' . $month . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($salaries) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Ism', 'Familiya', 'Asosiy maosh', 'Soatlik tarif', 'Jami soatlar', 'Bonus', 'Chegirma', 'Yakuniy summa']);
            
            foreach ($salaries as $salary) {
                fputcsv($file, [
                    $salary->teacher->first_name ?? '',
                    $salary->teacher->last_name ?? '',
                    number_format($salary->base_salary, 0, '.', ' '),
                    number_format($salary->hourly_rate, 0, '.', ' '),
                    $salary->total_hours,
                    number_format($salary->bonus, 0, '.', ' '),
                    number_format($salary->deduction, 0, '.', ' '),
                    number_format($salary->final_amount, 0, '.', ' ')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    private function exportToPdf($salaries, $month)
    {
        $html = '<h2>Maosh hisoboti - ' . $month . '</h2>';
        $html .= '<table border="1" style="width:100%; border-collapse: collapse;">';
        $html .= '<tr><th>Ism</th><th>Familiya</th><th>Asosiy maosh</th><th>Bonus</th><th>Chegirma</th><th>Yakuniy summa</th></tr>';
        
        foreach ($salaries as $salary) {
            $html .= '<tr>';
            $html .= '<td>' . ($salary->teacher->first_name ?? '') . '</td>';
            $html .= '<td>' . ($salary->teacher->last_name ?? '') . '</td>';
            $html .= '<td>' . number_format($salary->base_salary, 0, '.', ' ') . '</td>';
            $html .= '<td>' . number_format($salary->bonus, 0, '.', ' ') . '</td>';
            $html .= '<td>' . number_format($salary->deduction, 0, '.', ' ') . '</td>';
            $html .= '<td>' . number_format($salary->final_amount, 0, '.', ' ') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="maosh_hisoboti_' . $month . '.html"');
    }
}
