<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        $availableCourses = Course::where('status', 'active')
            ->with(['applications' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->get();
            
        $myApplications = CourseApplication::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->get();
            
        return view('student.courses', compact('availableCourses', 'myApplications'));
    }
    
    public function apply(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'message' => 'nullable|string|max:500'
        ]);
        
        $student = Auth::user()->student;
        
        // Check if already applied
        $existing = CourseApplication::where('student_id', $student->id)
            ->where('course_id', $request->course_id)
            ->first();
            
        if ($existing) {
            return redirect()->back()->with('error', 'Bu kursga allaqachon ariza bergansiz.');
        }
        
        CourseApplication::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'message' => $request->message,
            'applied_at' => now()
        ]);
        
        // Create notification for admin
        $course = \App\Models\Course::find($request->course_id);
        \App\Models\Notification::createNotification(
            1, // Admin user ID
            'Yangi kurs arizasi',
            "{$student->full_name} {$course->name} kursiga ariza berdi",
            'info'
        );
        
        return redirect()->back()->with('success', 'Ariza muvaffaqiyatli yuborildi!');
    }
}