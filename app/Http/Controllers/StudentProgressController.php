<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Quiz;
use Illuminate\Http\Request;

class StudentProgressController extends Controller
{
    public function show(Student $student)
    {
        $attendanceRate = $this->calculateAttendanceRate($student);
        $courseProgress = $this->getCourseProgress($student);
        $quizResults = $this->getQuizResults($student);
        $monthlyProgress = $this->getMonthlyProgress($student);

        return view('admin.students.progress', compact(
            'student', 'attendanceRate', 'courseProgress', 'quizResults', 'monthlyProgress'
        ));
    }

    private function calculateAttendanceRate(Student $student)
    {
        $totalClasses = $student->groups()->withCount('schedules')->get()->sum('schedules_count');
        $attendedClasses = Attendance::where('student_id', $student->id)
            ->where('status', 'present')->count();

        return $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 1) : 0;
    }

    private function getCourseProgress(Student $student)
    {
        return $student->groups()->with('course')->get()->map(function ($group) use ($student) {
            $totalLessons = $group->course->lessons()->count();
            $completedLessons = $student->attendances()
                ->whereHas('lesson', function ($query) use ($group) {
                    $query->where('group_id', $group->id);
                })
                ->where('status', 'present')
                ->count();

            return [
                'course' => $group->course->name,
                'progress' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 1) : 0,
                'completed' => $completedLessons,
                'total' => $totalLessons
            ];
        });
    }

    private function getQuizResults(Student $student)
    {
        return Quiz::whereHas('course.groups.students', function ($query) use ($student) {
            $query->where('students.id', $student->id);
        })->with('course')->get()->map(function ($quiz) {
            return [
                'quiz' => $quiz->title,
                'course' => $quiz->course->name,
                'score' => rand(70, 100), // Mock data
                'date' => $quiz->created_at
            ];
        });
    }

    private function getMonthlyProgress(Student $student)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $attendanceCount = Attendance::where('student_id', $student->id)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->where('status', 'present')
                ->count();

            $months[] = [
                'month' => $date->format('M'),
                'attendance' => $attendanceCount
            ];
        }
        return $months;
    }
}