<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $groups = $teacher ? $teacher->groups()->with(['course', 'students'])->get() : collect();
        
        return view('teacher.groups', compact('groups'));
    }

    public function show($id)
    {
        $teacher = Auth::user()->teacher;
        $group = $teacher->groups()->with(['course', 'students'])->findOrFail($id);
        
        return view('teacher.groups.show', compact('group'));
    }
}
