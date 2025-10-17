@extends('layouts.admin')

@section('content')

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Video Player -->
    <div class="gemini-card" style="margin: 0;">
        <div style="position: relative; background: #000; border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
            <video id="videoPlayer" controls style="width: 100%; height: 400px;" poster="{{ $videoLesson->thumbnail_url }}">
                <source src="{{ $videoLesson->video_url }}" type="video/mp4">
                Brauzeringiz video formatini qo'llab-quvvatlamaydi.
            </video>
        </div>
        
        <h1 style="font-size: 24px; font-weight: 500; margin: 0 0 12px 0; color: var(--gemini-text);">
            {{ $videoLesson->title }}
        </h1>
        
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 16px; font-size: 14px; color: var(--gemini-text-secondary);">
            <span><i class="fas fa-eye"></i> {{ $videoLesson->views }} ko'rishlar</span>
            <span><i class="fas fa-clock"></i> {{ $videoLesson->formatted_duration }}</span>
            <span><i class="fas fa-calendar"></i> {{ $videoLesson->created_at->format('d.m.Y') }}</span>
        </div>
        
        @if($videoLesson->description)
        <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <h3 style="margin: 0 0 8px 0; font-size: 16px;">Tavsif</h3>
            <p style="margin: 0; line-height: 1.6; color: var(--gemini-text-secondary);">
                {{ $videoLesson->description }}
            </p>
        </div>
        @endif
        
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.video-lessons.edit', $videoLesson) }}" class="gemini-btn">
                <i class="fas fa-edit"></i> Tahrirlash
            </a>
            <button onclick="shareVideo()" class="gemini-btn" style="background: #4caf50;">
                <i class="fas fa-share"></i> Ulashish
            </button>
            <form method="POST" action="{{ route('admin.video-lessons.destroy', $videoLesson) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="gemini-btn" style="background: #f44336;">
                    <i class="fas fa-trash"></i> O'chirish
                </button>
            </form>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div>
        <!-- Course Info -->
        <div class="gemini-card" style="margin: 0 0 20px 0;">
            <h3 style="margin: 0 0 12px 0; font-size: 16px;">Kurs ma'lumotlari</h3>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <img src="{{ $videoLesson->course->photo_url }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                <div>
                    <div style="font-weight: 500;">{{ $videoLesson->course->name }}</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary);">{{ $videoLesson->course->description }}</div>
                </div>
            </div>
            <a href="{{ route('admin.courses.show', $videoLesson->course) }}" class="gemini-btn" style="width: 100%; text-align: center;">
                Kursni ko'rish
            </a>
        </div>
        
        <!-- Related Videos -->
        @if($relatedLessons->count() > 0)
        <div class="gemini-card" style="margin: 0;">
            <h3 style="margin: 0 0 16px 0; font-size: 16px;">Tegishli darslar</h3>
            <div style="display: grid; gap: 12px;">
                @foreach($relatedLessons as $lesson)
                <a href="{{ route('admin.video-lessons.show', $lesson) }}" 
                   style="display: flex; gap: 12px; padding: 8px; border-radius: 8px; text-decoration: none; color: var(--gemini-text); transition: background 0.2s;"
                   onmouseover="this.style.background='var(--gemini-hover)'" 
                   onmouseout="this.style.background='transparent'">
                    <img src="{{ $lesson->thumbnail_url }}" style="width: 80px; height: 45px; border-radius: 4px; object-fit: cover;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $lesson->title }}
                        </div>
                        <div style="font-size: 12px; color: var(--gemini-text-secondary);">
                            {{ $lesson->formatted_duration }} • {{ $lesson->views }} ko'rishlar
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
const video = document.getElementById('videoPlayer');

// Track video progress
video.addEventListener('timeupdate', function() {
    const progress = (video.currentTime / video.duration) * 100;
    // You can send progress to server here
});

// Track when video ends
video.addEventListener('ended', function() {
    // Mark as completed
    console.log('Video completed');
});

function shareVideo() {
    const url = window.location.href;
    if (navigator.share) {
        navigator.share({
            title: '{{ $videoLesson->title }}',
            text: 'Bu video darsni ko\'ring',
            url: url
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Havola nusxalandi!');
        });
    }
}
</script>

@endsection