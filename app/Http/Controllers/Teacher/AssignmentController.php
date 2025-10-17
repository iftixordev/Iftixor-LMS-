<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        // Mock data for now
        $assignments = collect([
            (object)[
                'id' => 1,
                'title' => 'JavaScript Calculator',
                'group' => 'JS-01',
                'status' => 'active',
                'submissions' => 5
            ],
            (object)[
                'id' => 2,
                'title' => 'HTML Layout',
                'group' => 'WD-02', 
                'status' => 'completed',
                'submissions' => 0
            ]
        ]);
        
        return view('teacher.assignments', compact('assignments'));
    }
}
