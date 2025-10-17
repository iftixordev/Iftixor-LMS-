<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            // Create a default teacher record if it doesn't exist
            $teacher = \App\Models\Teacher::create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'email' => $user->phone . '@teacher.local',
                'status' => 'active'
            ]);
            
            $user->update(['teacher_id' => $teacher->id]);
        }
        
        $groups = $teacher->groups()->with(['course', 'students'])->get();
        $totalStudents = $groups->sum(function($group) {
            return $group->students->count();
        });
        
        return view('teacher.dashboard', compact('teacher', 'groups', 'totalStudents'));
    }
}
