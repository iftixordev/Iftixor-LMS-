<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $stats = [
                'total_students' => $this->safeTableCount('students'),
                'active_students' => $this->safeTableCount('students', ['status' => 'active']),
                'total_courses' => $this->safeTableCount('courses'),
                'active_courses' => $this->safeTableCount('courses', ['status' => 'active']),
                'total_groups' => $this->safeTableCount('groups'),
                'active_groups' => $this->safeTableCount('groups', ['status' => 'active']),
                'total_teachers' => $this->safeTableCount('teachers'),
                'today_revenue' => $this->safeTableSum('payments', 'amount', ['date' => today()->format('Y-m-d')]),
                'monthly_revenue' => $this->safeTableSum('payments', 'amount', ['month' => now()->format('Y-m')]),
                'yearly_revenue' => $this->safeTableSum('payments', 'amount', ['year' => now()->format('Y')]),
                'today_classes' => 0,
                'unread_messages' => 0,
            ];

            $recent_students = collect();
            $recent_payments = collect();
            $upcoming_classes = collect();
            $monthly_revenue = [];
            $course_popularity = collect();

            return view('admin.dashboard', compact('stats', 'recent_students', 'recent_payments', 'upcoming_classes', 'monthly_revenue', 'course_popularity'));
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            $stats = [
                'total_students' => 0,
                'active_students' => 0,
                'total_courses' => 0,
                'active_courses' => 0,
                'total_groups' => 0,
                'active_groups' => 0,
                'total_teachers' => 0,
                'today_revenue' => 0,
                'monthly_revenue' => 0,
                'yearly_revenue' => 0,
                'today_classes' => 0,
                'unread_messages' => 0,
            ];
            $recent_students = collect();
            $recent_payments = collect();
            $upcoming_classes = collect();
            $monthly_revenue = [];
            $course_popularity = collect();
            
            return view('admin.dashboard', compact('stats', 'recent_students', 'recent_payments', 'upcoming_classes', 'monthly_revenue', 'course_popularity'));
        }
    }
    
    private function switchToBranchDatabase($branch)
    {
        $branchName = str_replace([' ', '-', "'", '"'], '_', strtolower($branch->name));
        $dbPath = database_path("branch_{$branchName}.sqlite");
        
        config([
            'database.connections.branch' => [
                'driver' => 'sqlite',
                'database' => $dbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]
        ]);
        
        \DB::setDefaultConnection('branch');
    }

    private function safeTableCount($table, $conditions = [])
    {
        try {
            $query = \DB::table($table);
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
            return $query->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    private function safeTableSum($table, $column, $conditions = [])
    {
        try {
            $query = \DB::table($table);
            foreach ($conditions as $key => $value) {
                if ($key === 'date') {
                    $query->whereDate('payment_date', $value);
                } elseif ($key === 'month') {
                    $query->whereRaw("strftime('%Y-%m', payment_date) = ?", [$value]);
                } elseif ($key === 'year') {
                    $query->whereRaw("strftime('%Y', payment_date) = ?", [$value]);
                } else {
                    $query->where($key, $value);
                }
            }
            return $query->sum($column) ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    private function safeCount($model, $conditions = [])
    {
        try {
            $query = $model::query();
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
            return $query->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    private function safeSum($model, $column, $conditions = [])
    {
        try {
            $query = $model::query();
            foreach ($conditions as $key => $value) {
                if ($key === 'payment_date') {
                    $query->whereDate('payment_date', $value);
                } elseif ($key === 'month') {
                    $query->whereMonth('payment_date', $value);
                } elseif ($key === 'year') {
                    $query->whereYear('payment_date', $value);
                } else {
                    $query->where($key, $value);
                }
            }
            return $query->sum($column) ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    private function safeGet($model, $limit = 5, $with = [])
    {
        try {
            $query = $model::query();
            if (!empty($with)) {
                $query->with($with);
            }
            return $query->latest()->take($limit)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function youtubeDashboard()
    {
        $stats = [
            'students' => 156,
            'teachers' => 12,
            'courses' => 8,
            'revenue' => 15750000,
        ];

        return view('admin.youtube-dashboard', compact('stats'));
    }
}
