<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $groups = Group::with('course')->where('status', 'active')->get();
            $selectedGroup = null;
            $attendances = collect();
            $selectedDate = $request->filled('date') ? $request->date : today()->format('Y-m-d');
            
            if ($request->filled('group_id')) {
                $selectedGroup = Group::with(['students', 'course', 'teacher'])->find($request->group_id);
                if ($selectedGroup) {
                    $attendances = Attendance::with('student')
                        ->where('group_id', $selectedGroup->id)
                        ->whereDate('date', $selectedDate)
                        ->get()
                        ->keyBy('student_id');
                }
            }
            
            return view('admin.attendance.index', compact('groups', 'selectedGroup', 'attendances', 'selectedDate'));
        } catch (\Exception $e) {
            return view('admin.attendance.index', [
                'groups' => collect(),
                'selectedGroup' => null,
                'attendances' => collect(),
                'selectedDate' => today()->format('Y-m-d')
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'group_id' => 'required|exists:groups,id',
                'date' => 'required|date',
                'attendances' => 'required|array',
                'attendances.*.student_id' => 'required|exists:students,id',
                'attendances.*.status' => 'required|in:present,absent,late,excused',
            ]);

            foreach ($validated['attendances'] as $attendance) {
                $existing = Attendance::where('student_id', $attendance['student_id'])
                    ->where('group_id', $validated['group_id'])
                    ->whereDate('date', $validated['date'])
                    ->first();
                    
                if ($existing) {
                    $existing->update(['status' => $attendance['status']]);
                } else {
                    Attendance::create([
                        'student_id' => $attendance['student_id'],
                        'group_id' => $validated['group_id'],
                        'date' => $validated['date'],
                        'status' => $attendance['status']
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Davomat muvaffaqiyatli saqlandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function studentAttendance(Student $student)
    {
        $attendances = Attendance::with(['group.course'])
            ->where('student_id', $student->id)
            ->orderByDesc('date')
            ->paginate(20);
            
        return view('admin.attendance.student', compact('student', 'attendances'));
    }
}
