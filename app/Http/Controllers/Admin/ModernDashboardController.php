<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Group;
use App\Models\Payment;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ModernDashboardController extends Controller
{
    public function index()
    {
        $currentBranch = auth()->user()->branch_id;
        
        // Statistikalar
        $stats = [
            'total_students' => Student::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->count(),
            
            'total_teachers' => Teacher::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->count(),
            
            'active_teachers' => Teacher::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->where('status', 'active')->count(),
            
            'active_courses' => Course::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->where('status', 'active')->count(),
            
            'total_groups' => Group::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->count(),
            
            'monthly_revenue' => Payment::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year)
              ->sum('amount'),
              
            'new_students_this_month' => Student::when($currentBranch, function($q) use ($currentBranch) {
                return $q->where('branch_id', $currentBranch);
            })->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year)
              ->count(),
        ];

        // So'nggi faoliyatlar
        $recent_activities = $this->getRecentActivities();
        
        // Yaqinlashayotgan tadbirlar
        $upcoming_events = $this->getUpcomingEvents();
        
        // Eng yaxshi o'quvchilar
        $top_students = Student::when($currentBranch, function($q) use ($currentBranch) {
            return $q->where('branch_id', $currentBranch);
        })->with('course')
          ->orderBy('average_score', 'desc')
          ->take(5)
          ->get();

        return view('admin.modern-dashboard', compact(
            'stats', 
            'recent_activities', 
            'upcoming_events', 
            'top_students'
        ));
    }

    private function getRecentActivities()
    {
        $activities = [];
        $currentBranch = auth()->user()->branch_id;

        // Yangi o'quvchilar
        $newStudents = Student::when($currentBranch, function($q) use ($currentBranch) {
            return $q->where('branch_id', $currentBranch);
        })->latest()->take(3)->get();
        
        foreach ($newStudents as $student) {
            $activities[] = [
                'type' => 'student',
                'icon' => 'fas fa-user-plus',
                'description' => "Yangi o'quvchi qo'shildi: {$student->full_name}",
                'time' => $student->created_at->diffForHumans()
            ];
        }

        // Yangi to'lovlar
        $newPayments = Payment::when($currentBranch, function($q) use ($currentBranch) {
            return $q->where('branch_id', $currentBranch);
        })->with('student')->latest()->take(2)->get();
        
        foreach ($newPayments as $payment) {
            $activities[] = [
                'type' => 'payment',
                'icon' => 'fas fa-credit-card',
                'description' => "To'lov qabul qilindi: " . number_format($payment->amount) . " so'm",
                'time' => $payment->created_at->diffForHumans()
            ];
        }

        // Vaqt bo'yicha saralash
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }

    private function getUpcomingEvents()
    {
        return [
            [
                'title' => 'Oylik hisobot',
                'description' => 'Moliyaviy hisobot tayyorlash',
                'date' => now()->addDays(3),
                'time' => '10:00'
            ],
            [
                'title' => 'O\'qituvchilar yig\'ilishi',
                'description' => 'Haftalik pedagogik kengash',
                'date' => now()->addDays(5),
                'time' => '14:00'
            ],
            [
                'title' => 'Yangi kurs boshlanishi',
                'description' => 'Web dasturlash kursi',
                'date' => now()->addWeek(),
                'time' => '09:00'
            ]
        ];
    }

    public function getChartData(Request $request)
    {
        $period = $request->get('period', 'month');
        $currentBranch = auth()->user()->branch_id;
        
        switch ($period) {
            case 'week':
                $data = $this->getWeeklyData($currentBranch);
                break;
            case 'year':
                $data = $this->getYearlyData($currentBranch);
                break;
            default:
                $data = $this->getMonthlyData($currentBranch);
        }

        return response()->json($data);
    }

    private function getMonthlyData($branchId)
    {
        $months = [];
        $revenues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            
            $revenue = Payment::when($branchId, function($q) use ($branchId) {
                return $q->where('branch_id', $branchId);
            })->whereMonth('created_at', $date->month)
              ->whereYear('created_at', $date->year)
              ->sum('amount');
              
            $revenues[] = $revenue;
        }

        return [
            'labels' => $months,
            'data' => $revenues
        ];
    }

    private function getWeeklyData($branchId)
    {
        $days = [];
        $revenues = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D');
            
            $revenue = Payment::when($branchId, function($q) use ($branchId) {
                return $q->where('branch_id', $branchId);
            })->whereDate('created_at', $date)
              ->sum('amount');
              
            $revenues[] = $revenue;
        }

        return [
            'labels' => $days,
            'data' => $revenues
        ];
    }

    private function getYearlyData($branchId)
    {
        $years = [];
        $revenues = [];
        
        for ($i = 2; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $years[] = $year;
            
            $revenue = Payment::when($branchId, function($q) use ($branchId) {
                return $q->where('branch_id', $branchId);
            })->whereYear('created_at', $year)
              ->sum('amount');
              
            $revenues[] = $revenue;
        }

        return [
            'labels' => $years,
            'data' => $revenues
        ];
    }
}