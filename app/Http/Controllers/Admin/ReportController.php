<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Transaction;
use App\Models\Lead;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Umumiy statistikalar
        $stats = [
            'total_students' => Student::where('status', 'active')->count(),
            'total_teachers' => Teacher::where('status', 'active')->count(),
            'total_courses' => Course::where('status', 'active')->count(),
            'total_groups' => Group::where('status', 'active')->count(),
            'total_leads' => Lead::count(),
            'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'yearly_revenue' => Payment::whereYear('payment_date', now()->year)->sum('amount'),
        ];

        // Eng mashhur kurslar
        $popularCourses = Course::withCount('groups')
            ->orderBy('groups_count', 'desc')
            ->take(5)
            ->get();

        // O'qituvchilar yuklama
        $teacherWorkload = Teacher::with('groups')
            ->get()
            ->map(function($teacher) {
                $totalStudents = $teacher->groups->sum(function($group) {
                    return $group->students()->count();
                });
                return [
                    'teacher' => $teacher,
                    'groups_count' => $teacher->groups->count(),
                    'students_count' => $totalStudents
                ];
            })
            ->sortByDesc('students_count')
            ->take(10);

        // Oylik moliyaviy trend
        $monthlyRevenue = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Payment::whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount');
            $monthlyRevenue->push([
                'month' => $month->format('M Y'),
                'revenue' => $revenue
            ]);
        }

        // Lead konversiya
        $leadStats = [
            'total_leads' => Lead::count(),
            'enrolled_leads' => Lead::where('status', 'enrolled')->count(),
            'conversion_rate' => Lead::count() > 0 ? round((Lead::where('status', 'enrolled')->count() / Lead::count()) * 100, 1) : 0
        ];
        
        return view('admin.reports.index', compact(
            'stats', 'popularCourses', 'teacherWorkload', 
            'monthlyRevenue', 'leadStats'
        ));
    }

    public function students()
    {
        $students = Student::with('groups')->get();
        return view('admin.reports.students', compact('students'));
    }

    public function finance()
    {
        $payments = Payment::with('student')->latest()->get();
        return view('admin.reports.finance', compact('payments'));
    }

    public function performance()
    {
        // O'quv markazi samaradorligi
        $currentMonth = now();
        $lastMonth = now()->subMonth();

        $performance = [
            'student_growth' => [
                'current' => Student::whereMonth('created_at', $currentMonth->month)->count(),
                'previous' => Student::whereMonth('created_at', $lastMonth->month)->count()
            ],
            'revenue_growth' => [
                'current' => Payment::whereMonth('payment_date', $currentMonth->month)->sum('amount'),
                'previous' => Payment::whereMonth('payment_date', $lastMonth->month)->sum('amount')
            ],
            'course_completion' => [
                'completed' => Group::where('status', 'completed')->count(),
                'active' => Group::where('status', 'active')->count()
            ]
        ];

        // Kurslar bo'yicha tahlil
        $courseAnalytics = Course::withCount(['groups', 'students'])
            ->with(['groups' => function($query) {
                $query->withCount('students');
            }])
            ->get()
            ->map(function($course) {
                $totalRevenue = Payment::whereHas('student.groups', function($query) use ($course) {
                    $query->where('course_id', $course->id);
                })->sum('amount');
                
                return [
                    'course' => $course,
                    'total_students' => $course->groups->sum('students_count'),
                    'total_revenue' => $totalRevenue,
                    'avg_group_size' => $course->groups_count > 0 ? round($course->groups->sum('students_count') / $course->groups_count, 1) : 0
                ];
            })
            ->sortByDesc('total_revenue');

        return view('admin.reports.performance', compact('performance', 'courseAnalytics'));
    }

    public function teacherAnalytics()
    {
        $teachers = Teacher::with(['groups.students', 'groups.course'])
            ->get()
            ->map(function($teacher) {
                $totalStudents = $teacher->groups->sum(function($group) {
                    return $group->students->count();
                });
                
                $totalRevenue = 0;
                foreach($teacher->groups as $group) {
                    foreach($group->students as $student) {
                        $totalRevenue += Payment::where('student_id', $student->id)->sum('amount');
                    }
                }

                return [
                    'teacher' => $teacher,
                    'groups_count' => $teacher->groups->count(),
                    'students_count' => $totalStudents,
                    'total_revenue' => $totalRevenue,
                    'avg_students_per_group' => $teacher->groups->count() > 0 ? round($totalStudents / $teacher->groups->count(), 1) : 0
                ];
            })
            ->sortByDesc('total_revenue');

        return view('admin.reports.teachers', compact('teachers'));
    }
}
