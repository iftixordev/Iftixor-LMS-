<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['group.course', 'teacher'])->get();
        $groups = Group::with('course')->get();
        $teachers = Teacher::get();
        return view('admin.schedules.index', compact('schedules', 'groups', 'teachers'));
    }

    public function create()
    {
        $groups = Group::with('course')->get();
        $teachers = Teacher::get();
        return view('admin.schedules.create', compact('groups', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:255',
        ]);

        Schedule::create($validated);
        return redirect()->route('admin.schedules.index')->with('success', 'Jadval yaratildi');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadval o\'chirildi.');
    }
}
