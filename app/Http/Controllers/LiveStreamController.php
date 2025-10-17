<?php

namespace App\Http\Controllers;

use App\Models\LiveStream;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LiveStreamController extends Controller
{
    public function index()
    {
        $streams = LiveStream::with(['teacher', 'course'])->latest()->paginate(20);
        $liveStreams = LiveStream::live()->count();
        $scheduledStreams = LiveStream::scheduled()->count();
        $totalViewers = LiveStream::sum('viewers_count');

        return view('admin.live-streams.index', compact(
            'streams', 'liveStreams', 'scheduledStreams', 'totalViewers'
        ));
    }

    public function create()
    {
        $courses = Course::all();
        $teachers = Teacher::all();
        return view('admin.live-streams.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:teachers,id',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'required|date|after:now'
        ]);

        LiveStream::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'scheduled_at' => $request->scheduled_at,
            'stream_key' => Str::random(32),
            'stream_url' => 'rtmp://stream.example.com/live/' . Str::random(16),
            'status' => 'scheduled'
        ]);

        return redirect()->route('admin.live-streams.index')
            ->with('success', 'Jonli efir rejalashtirildi');
    }

    public function show(LiveStream $liveStream)
    {
        return view('admin.live-streams.show', compact('liveStream'));
    }

    public function startStream(LiveStream $liveStream)
    {
        $liveStream->update([
            'status' => 'live',
            'started_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function endStream(LiveStream $liveStream)
    {
        $liveStream->update([
            'status' => 'ended',
            'ended_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function updateViewers(LiveStream $liveStream, Request $request)
    {
        $viewers = $request->input('viewers', 0);
        
        $liveStream->update([
            'viewers_count' => $viewers,
            'max_viewers' => max($liveStream->max_viewers, $viewers)
        ]);

        return response()->json(['success' => true]);
    }
}