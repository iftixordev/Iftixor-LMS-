<?php

namespace App\Http\Controllers;

use App\Models\VideoLesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoLessonController extends Controller
{
    public function index()
    {
        $lessons = VideoLesson::with('course')->latest()->paginate(20);
        $totalLessons = VideoLesson::count();
        $totalDuration = VideoLesson::sum('duration');
        $totalViews = VideoLesson::sum('views');

        return view('admin.video-lessons.index', compact(
            'lessons', 'totalLessons', 'totalDuration', 'totalViews'
        ));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.video-lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'video_file' => 'required|file|mimes:mp4,avi,mov|max:512000', // 500MB max
            'thumbnail' => 'nullable|image|max:2048',
            'duration' => 'required|integer|min:1'
        ]);

        $videoPath = $request->file('video_file')->store('videos', 'public');
        $thumbnailPath = $request->hasFile('thumbnail') 
            ? $request->file('thumbnail')->store('thumbnails', 'public')
            : null;

        VideoLesson::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
            'duration' => $request->duration,
            'order' => VideoLesson::where('course_id', $request->course_id)->count() + 1
        ]);

        return redirect()->route('admin.video-lessons.index')
            ->with('success', 'Video dars muvaffaqiyatli qo\'shildi');
    }

    public function show(VideoLesson $videoLesson)
    {
        $videoLesson->increment('views');
        $relatedLessons = VideoLesson::where('course_id', $videoLesson->course_id)
            ->where('id', '!=', $videoLesson->id)
            ->limit(5)
            ->get();

        return view('admin.video-lessons.show', compact('videoLesson', 'relatedLessons'));
    }

    public function edit(VideoLesson $videoLesson)
    {
        $courses = Course::all();
        return view('admin.video-lessons.edit', compact('videoLesson', 'courses'));
    }

    public function update(Request $request, VideoLesson $videoLesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov|max:512000',
            'thumbnail' => 'nullable|image|max:2048',
            'duration' => 'required|integer|min:1'
        ]);

        $data = $request->only(['title', 'description', 'course_id', 'duration']);

        if ($request->hasFile('video_file')) {
            if ($videoLesson->video_path) {
                Storage::disk('public')->delete($videoLesson->video_path);
            }
            $data['video_path'] = $request->file('video_file')->store('videos', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($videoLesson->thumbnail_path) {
                Storage::disk('public')->delete($videoLesson->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $videoLesson->update($data);

        return redirect()->route('admin.video-lessons.index')
            ->with('success', 'Video dars yangilandi');
    }

    public function destroy(VideoLesson $videoLesson)
    {
        if ($videoLesson->video_path) {
            Storage::disk('public')->delete($videoLesson->video_path);
        }
        if ($videoLesson->thumbnail_path) {
            Storage::disk('public')->delete($videoLesson->thumbnail_path);
        }

        $videoLesson->delete();

        return redirect()->route('admin.video-lessons.index')
            ->with('success', 'Video dars o\'chirildi');
    }
}