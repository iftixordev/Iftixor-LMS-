<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        try {
            $currentBranchId = session('current_branch_id');
            $courses = Course::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))
                ->withCount('groups')
                ->latest()
                ->paginate(20);
            return view('admin.courses.index', compact('courses'));
        } catch (\Exception $e) {
            \Log::error('Courses index error: ' . $e->getMessage());
            $courses = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            return view('admin.courses.index', compact('courses'));
        }
    }

    public function create()
    {
        try {
            return view('admin.courses.create');
        } catch (\Exception $e) {
            \Log::error('Course create page error: ' . $e->getMessage());
            return redirect()->route('admin.courses.index')->with('error', 'Sahifani yuklashda xatolik yuz berdi.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration_months' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'lessons_count' => 'required|integer|min:1',
                'min_students' => 'nullable|integer|min:1',
                'max_students' => 'nullable|integer|min:1',
                'curriculum' => 'nullable|string',
                'requirements' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'course_type' => 'nullable|in:online,offline',
                'meeting_link' => 'nullable|url',
            ]);

            // Default qiymatlar
            $validated['status'] = 'active';
            $validated['min_students'] = $validated['min_students'] ?? 5;
            $validated['max_students'] = $validated['max_students'] ?? 20;
            $validated['course_type'] = $validated['course_type'] ?? 'offline';

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('courses', 'public');
            }

            // Joriy branch ID ni qo'shamiz
            $validated['branch_id'] = session('current_branch_id', 1);

            Course::create($validated);
            return redirect()->route('admin.courses.index')->with('success', 'Kurs muvaffaqiyatli yaratildi.');
        } catch (\Exception $e) {
            \Log::error('Course creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Kurs yaratishda xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Course $course)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'duration_months' => $course->duration_months,
                'price' => $course->price,
                'lessons_count' => $course->lessons_count,
                'curriculum' => $course->curriculum,
                'requirements' => $course->requirements,
                'status' => $course->status,
            ]);
        }
        
        $course->load(['groups.students', 'groups.teacher']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'lessons_count' => 'required|integer|min:1',
            'min_students' => 'required|integer|min:1',
            'max_students' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,completed',
            'curriculum' => 'nullable|string',
            'requirements' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($course->photo) {
                Storage::disk('public')->delete($course->photo);
            }
            $validated['photo'] = $request->file('photo')->store('courses', 'public');
        }

        $course->update($validated);
        return redirect()->route('admin.courses.show', $course)->with('success', 'Kurs ma\'lumotlari yangilandi.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kurs o\'chirildi.');
    }

    public function applications()
    {
        $currentBranchId = session('current_branch_id');
        $applications = \App\Models\CourseApplication::with(['student', 'course', 'processedBy'])
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->whereHas('course', fn($cq) => $cq->where('branch_id', $currentBranchId));
            })
            ->latest('applied_at')
            ->paginate(20);
            
        return view('admin.courses.applications', compact('applications'));
    }

    public function approveApplication(\App\Models\CourseApplication $application)
    {
        $application->update([
            'status' => 'approved',
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);
        
        // Create notification for student
        if ($application->student->user) {
            \App\Models\Notification::createNotification(
                $application->student->user->id,
                'Ariza tasdiqlandi',
                "{$application->course->name} kursiga arizangiz tasdiqlandi",
                'success'
            );
        }
        
        return redirect()->back()->with('success', 'Ariza tasdiqlandi.');
    }

    public function rejectApplication(Request $request, \App\Models\CourseApplication $application)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);
        
        // Create notification for student
        if ($application->student->user) {
            \App\Models\Notification::createNotification(
                $application->student->user->id,
                'Ariza rad etildi',
                "{$application->course->name} kursiga arizangiz rad etildi. Sabab: {$request->rejection_reason}",
                'warning'
            );
        }
        
        return redirect()->back()->with('success', 'Ariza rad etildi.');
    }
}
