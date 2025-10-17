<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Group::with(['course', 'teacher'])->withCount('students');
            
            if ($request->filled('search')) {
                $query->where('name', 'like', "%{$request->search}%");
            }
            
            if ($request->filled('course_id')) {
                $query->where('course_id', $request->course_id);
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            $groups = $query->latest()->paginate(20);
            $courses = Course::where('status', 'active')->get();
            $teachers = Teacher::where('status', 'active')->get();
            
            return view('admin.groups.index', compact('groups', 'courses', 'teachers'));
        } catch (\Exception $e) {
            $courses = collect();
            $teachers = collect();
            return view('admin.groups.index', ['groups' => collect()->paginate(), 'courses' => $courses, 'teachers' => $teachers]);
        }
    }

    public function create()
    {
        try {
            $currentBranchId = session('current_branch_id');
            $courses = Course::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))
                ->where('status', 'active')
                ->get();
            $teachers = Teacher::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))
                ->where('status', 'active')
                ->get();
            return view('admin.groups.create', compact('courses', 'teachers'));
        } catch (\Exception $e) {
            \Log::error('Group create page error: ' . $e->getMessage());
            return view('admin.groups.create', ['courses' => collect(), 'teachers' => collect()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'course_id' => 'required|exists:courses,id',
                'teacher_id' => 'required|exists:teachers,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'max_students' => 'required|integer|min:1',
                'description' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Default qiymatlar
            $validated['status'] = 'active';
            $validated['branch_id'] = session('current_branch_id', 1);

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('groups', 'public');
            }

            Group::create($validated);
            return redirect()->route('admin.groups.index')->with('success', 'Guruh muvaffaqiyatli yaratildi.');
        } catch (\Exception $e) {
            \Log::error('Group creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Guruh yaratishda xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Group $group)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $group->id,
                'name' => $group->name,
                'course_id' => $group->course_id,
                'teacher_id' => $group->teacher_id,
                'start_date' => $group->start_date?->format('Y-m-d'),
                'end_date' => $group->end_date?->format('Y-m-d'),
                'max_students' => $group->max_students,
                'status' => $group->status,
                'description' => $group->description,
            ]);
        }
        
        $group->load(['course', 'teacher', 'students', 'schedules.room']);
        $currentBranchId = session('current_branch_id');
        $available_students = Student::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->where('status', 'active')
            ->whereDoesntHave('groups', function($q) use ($group) {
                $q->where('group_id', $group->id);
            })->get();
        return view('admin.groups.show', compact('group', 'available_students'));
    }

    public function addStudent(Request $request, Group $group)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id'
            ]);

            $group->students()->attach($request->student_id, [
                'enrolled_date' => now(),
                'status' => 'active'
            ]);

            if ($request->has('redirect_to_student')) {
                return redirect()->route('admin.students.show', $request->student_id)
                    ->with('success', 'O\'quvchi guruhga qo\'shildi.');
            }

            return redirect()->back()->with('success', 'O\'quvchi guruhga qo\'shildi.');
        } catch (\Exception $e) {
            \Log::error('Add student to group error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    public function removeStudent(Group $group, Student $student)
    {
        $group->students()->detach($student->id);
        return redirect()->back()->with('success', 'O\'quvchi guruhdan chiqarildi.');
    }

    public function edit(Group $group)
    {
        $currentBranchId = session('current_branch_id');
        $courses = Course::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->where('status', 'active')->get();
        $teachers = Teacher::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->where('status', 'active')->get();
        return view('admin.groups.edit', compact('group', 'courses', 'teachers'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,completed',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($group->photo) {
                Storage::disk('public')->delete($group->photo);
            }
            $validated['photo'] = $request->file('photo')->store('groups', 'public');
        }

        $group->update($validated);
        return redirect()->route('admin.groups.index')->with('success', 'Guruh ma\'lumotlari yangilandi.');
    }

    public function destroy(Group $group)
    {
        try {
            // Bog'langan ma'lumotlarni o'chirish
            $group->students()->detach();
            $group->schedules()->delete();
            $group->attendances()->delete();
            $group->workloads()->delete();
            
            // Rasmni o'chirish
            if ($group->photo) {
                Storage::disk('public')->delete($group->photo);
            }
            
            $group->delete();
            return redirect()->route('admin.groups.index')->with('success', 'Guruh muvaffaqiyatli o\'chirildi.');
        } catch (\Exception $e) {
            \Log::error('Group deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Guruhni o\'chirishda xatolik yuz berdi.');
        }
    }
}
