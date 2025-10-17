<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        if (!$student) {
            abort(403, 'O\'quvchi ma\'lumotlari topilmadi.');
        }
        
        $groups = $student->groups()->with(['course', 'teacher'])->get();
        $payments = $student->payments()->latest()->take(5)->get();
        
        // Calculate attendance rate
        $totalClasses = $student->attendances()->count();
        $presentClasses = $student->attendances()->where('status', 'present')->count();
        $attendanceRate = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;
        
        return view('student.dashboard', compact('student', 'groups', 'payments', 'attendanceRate'));
    }
}
