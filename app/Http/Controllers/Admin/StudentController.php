<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ErrorHandler;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $currentBranchId = session('current_branch_id');
            
            $query = Student::with(['groups.course', 'payments' => function($q) {
                $q->latest()->limit(1);
            }])->when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId));

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('enrollment_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('enrollment_date', '<=', $request->date_to);
            }

            if ($request->get('export') === 'excel') {
                return $this->exportToExcel($query->get());
            }

            $students = $query->latest()->paginate(20);
            return view('admin.students.index', compact('students'));
        } catch (\Exception $e) {
            \Log::error('Students index error: ' . $e->getMessage());
            $students = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            return view('admin.students.index', compact('students'));
        }
    }

    private function exportToExcel($students)
    {
        $filename = 'oquvchilar_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'Ism', 'Familiya', 'Telefon', 'Ota-ona telefoni', 'Jinsi', 'Holat', 'Royxatga olingan']);
            
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id ?? '',
                    $student->first_name ?? '',
                    $student->last_name ?? '',
                    $student->phone ?? '',
                    $student->parent_phone ?? '',
                    $student->gender ?? '',
                    $student->status ?? '',
                    $student->enrollment_date ? $student->enrollment_date->format('d.m.Y') : ''
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function exportPdf(Request $request)
    {
        try {
            $query = Student::with(['groups.course']);
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%");
                });
            }
            
            $students = $query->get();
            
            $html = '<h2>O\'quvchilar ro\'yxati</h2>';
            $html .= '<table border="1" style="width:100%; border-collapse: collapse;">';
            $html .= '<tr><th>ID</th><th>Ism</th><th>Familiya</th><th>Telefon</th><th>Holat</th></tr>';
            
            foreach ($students as $student) {
                $html .= '<tr>';
                $html .= '<td>' . ($student->student_id ?? '') . '</td>';
                $html .= '<td>' . ($student->first_name ?? '') . '</td>';
                $html .= '<td>' . ($student->last_name ?? '') . '</td>';
                $html .= '<td>' . ($student->phone ?? '') . '</td>';
                $html .= '<td>' . ($student->status ?? '') . '</td>';
                $html .= '</tr>';
            }
            
            $html .= '</table>';
            
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="oquvchilar_' . date('Y-m-d') . '.html"');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Export xatosi: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'parent_name' => 'nullable|string|max:255',
                'parent_phone' => 'nullable|string|max:20',
                'parent_email' => 'nullable|email|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'enrollment_date' => 'required|date',
                'notes' => 'nullable|string',
            ]);

            // Unique student ID yaratish
            $currentBranchId = session('current_branch_id', 1);
            do {
                $lastStudent = Student::latest('id')->first();
                $nextNumber = $lastStudent ? (int)substr($lastStudent->student_id, -4) + 1 : 1;
                $studentId = 'STD' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } while (Student::where('student_id', $studentId)->exists());
            
            $validated['student_id'] = $studentId;
            
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('students', 'public');
            }
            
            $validated['branch_id'] = $currentBranchId;
            $validated['status'] = 'active';
            
            Student::create($validated);
            return redirect()->route('admin.students.index')->with('success', 'O\'quvchi muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            \Log::error('Student creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'O\'quvchi qo\'shishda xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Student $student)
    {
        try {
            if (request()->expectsJson()) {
                return response()->json([
                    'id' => $student->id,
                    'first_name' => $student->first_name ?? '',
                    'last_name' => $student->last_name ?? '',
                    'birth_date' => $student->birth_date?->format('Y-m-d') ?? '',
                    'gender' => $student->gender ?? '',
                    'phone' => $student->phone ?? '',
                    'email' => $student->email ?? '',
                    'address' => $student->address ?? '',
                    'parent_name' => $student->parent_name ?? '',
                    'parent_phone' => $student->parent_phone ?? '',
                    'parent_email' => $student->parent_email ?? '',
                    'enrollment_date' => $student->enrollment_date?->format('Y-m-d') ?? '',
                    'status' => $student->status ?? 'active',
                    'notes' => $student->notes ?? '',
                ]);
            }
            
            try {
                $student->load(['groups.course', 'groups.teacher', 'payments', 'attendances']);
            } catch (\Exception $e) {
                // Load xatoligi bo'lsa, asosiy ma'lumotlarni yuklash
                $student->load(['groups']);
            }
            
            // O'quvchi qatnashmagan guruhlarni olish
            $currentBranchId = session('current_branch_id');
            $availableGroups = Group::with(['course', 'teacher'])
                ->withCount('students')
                ->when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))
                ->where('status', 'active')
                ->whereDoesntHave('students', function($q) use ($student) {
                    $q->where('group_student.student_id', $student->id);
                })
                ->get();
            
            return view('admin.students.show', compact('student', 'availableGroups'));
        } catch (\Exception $e) {
            \Log::error('Student show error: ' . $e->getMessage());
            return redirect()->route('admin.students.index')->with('error', 'O\'quvchi ma\'lumotlarini olishda xatolik yuz berdi.');
        }
    }

    public function edit(Student $student)
    {
        try {
            return view('admin.students.edit', compact('student'));
        } catch (\Exception $e) {
            return redirect()->route('admin.students.index')->with('error', 'Ma\'lumot olishda xatolik: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Student $student)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'parent_name' => 'nullable|string|max:255',
                'parent_phone' => 'nullable|string|max:20',
                'parent_email' => 'nullable|email|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required|in:active,inactive,graduated',
                'notes' => 'nullable|string',
            ]);

            if ($request->hasFile('photo')) {
                if ($student->photo) {
                    Storage::disk('public')->delete($student->photo);
                }
                $validated['photo'] = $request->file('photo')->store('students', 'public');
            }

            $student->update($validated);
            return redirect()->route('admin.students.index')->with('success', 'O\'quvchi ma\'lumotlari muvaffaqiyatli yangilandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Yangilashda xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Student $student)
    {
        try {
            // Avval bog'langan ma'lumotlarni o'chirish
            $student->groups()->detach(); // Guruhlardan chiqarish
            $student->payments()->delete(); // To'lovlarni o'chirish
            $student->attendances()->delete(); // Davomatni o'chirish
            $student->coins()->delete(); // Coinlarni o'chirish
            $student->purchases()->delete(); // Xaridlarni o'chirish
            $student->courseApplications()->delete(); // Ariza so'rovlarini o'chirish
            
            // Rasmni o'chirish
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            
            // O'quvchini o'chirish
            $student->delete();
            
            return redirect()->route('admin.students.index')->with('success', 'O\'quvchi va unga bog\'liq barcha ma\'lumotlar muvaffaqiyatli o\'chirildi.');
        } catch (\Exception $e) {
            $errorMessage = ErrorHandler::handleDatabaseError($e, 'student deletion');
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function progress(Student $student)
    {
        try {
            $student->load(['groups.course', 'payments', 'attendances', 'coins']);
            
            // Davomat statistikasi
            $totalAttendances = $student->attendances ? $student->attendances->count() : 0;
            $presentCount = $student->attendances ? $student->attendances->where('status', 'present')->count() : 0;
            $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 1) : 0;
            
            // To'lov statistikasi
            $totalPayments = $student->payments ? $student->payments->sum('amount') : 0;
            $lastPayment = $student->payments ? $student->payments->sortByDesc('created_at')->first() : null;
            
            // Coin balansi
            $coinBalance = 0;
            try {
                $coinBalance = $student->coin_balance ?? 0;
            } catch (\Exception $e) {
                $coinBalance = 0;
            }
            
            // Oylik progress
            $monthlyProgress = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $attendanceCount = $student->attendances ? $student->attendances->filter(function($attendance) use ($date) {
                    return $attendance->created_at && 
                           $attendance->created_at->month == $date->month && 
                           $attendance->created_at->year == $date->year &&
                           $attendance->status == 'present';
                })->count() : 0;
                
                $monthlyProgress[] = [
                    'month' => $date->format('M'),
                    'attendance' => $attendanceCount
                ];
            }
            
            return view('admin.students.progress', compact(
                'student', 'attendanceRate', 'totalPayments', 'lastPayment', 'coinBalance', 'monthlyProgress'
            ));
        } catch (\Exception $e) {
            \Log::error('Student progress error: ' . $e->getMessage());
            return redirect()->route('admin.students.index')->with('error', 'Progress ma\'lumotlarini olishda xatolik yuz berdi.');
        }
    }

    public function search(Request $request)
    {
        try {
            $currentBranchId = session('current_branch_id');
            $query = Student::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId));
            
            if ($request->filled('q')) {
                $search = $request->q;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            } else {
                // If no search term, return first 10 students
                $query->limit(10);
            }
            
            if ($request->filled('exclude_group')) {
                $query->whereDoesntHave('groups', function($q) use ($request) {
                    $q->where('group_id', $request->exclude_group);
                });
            }
            
            $students = $query->limit(20)->get(['id', 'first_name', 'last_name', 'phone', 'student_id']);
            
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
