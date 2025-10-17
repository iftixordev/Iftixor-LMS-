@extends('layouts.admin')

@section('content')

<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Video Darslar</h1>
            <p class="gemini-card-subtitle">Kurs uchun video darslarni boshqaring</p>
        </div>
        <a href="{{ route('admin.video-lessons.create') }}" class="gemini-btn">
            <i class="fas fa-plus"></i> Yangi video dars
        </a>
    </div>

    <!-- Stats -->
    <div class="gemini-stats">
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon">
                <i class="fas fa-video"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ $totalLessons }}</div>
                <div class="gemini-stat-label">Jami video darslar</div>
                <div class="gemini-stat-change neutral">Barcha kurslar</div>
            </div>
        </div>
        
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ floor($totalDuration / 3600) }}h</div>
                <div class="gemini-stat-label">Jami davomiyligi</div>
                <div class="gemini-stat-change neutral">{{ floor(($totalDuration % 3600) / 60) }}m qolgan</div>
            </div>
        </div>
        
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ number_format($totalViews) }}</div>
                <div class="gemini-stat-label">Jami ko'rishlar</div>
                <div class="gemini-stat-change positive">Barcha videolar</div>
            </div>
        </div>
    </div>

    <!-- Video Lessons Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($lessons as $lesson)
        <div class="gemini-card" style="margin: 0; overflow: hidden;">
            <div style="position: relative;">
                <img src="{{ $lesson->thumbnail_url }}" alt="{{ $lesson->title }}" 
                     style="width: 100%; height: 180px; object-fit: cover; border-radius: 8px 8px 0 0;">
                <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.8); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                    {{ $lesson->formatted_duration }}
                </div>
                <div style="position: absolute; top: 8px; left: 8px; background: var(--gemini-blue); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                    {{ $lesson->course->name }}
                </div>
            </div>
            
            <div style="padding: 16px;">
                <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 500; color: var(--gemini-text);">
                    {{ $lesson->title }}
                </h3>
                
                @if($lesson->description)
                <p style="margin: 0 0 12px 0; font-size: 14px; color: var(--gemini-text-secondary); line-height: 1.4;">
                    {{ Str::limit($lesson->description, 100) }}
                </p>
                @endif
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 16px; font-size: 12px; color: var(--gemini-text-secondary);">
                        <span><i class="fas fa-eye"></i> {{ $lesson->views }}</span>
                        <span><i class="fas fa-calendar"></i> {{ $lesson->created_at->format('d.m.Y') }}</span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.video-lessons.show', $lesson) }}" class="gemini-btn" style="flex: 1; text-align: center; padding: 8px;">
                        <i class="fas fa-play"></i> Ko'rish
                    </a>
                    <a href="{{ route('admin.video-lessons.edit', $lesson) }}" class="gemini-btn" style="background: #4caf50; padding: 8px 12px;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.video-lessons.destroy', $lesson) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="gemini-btn" style="background: #f44336; color: white; padding: 8px 12px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--gemini-text-secondary);">
            <i class="fas fa-video" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <h3 style="margin: 0 0 8px 0; font-weight: 400;">Video darslar yo'q</h3>
            <p style="margin: 0 0 20px 0;">Birinchi video darsni qo'shing</p>
            <a href="{{ route('admin.video-lessons.create') }}" class="gemini-btn">
                <i class="fas fa-plus"></i> Yangi video dars
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lessons->hasPages())
    <div style="margin-top: 32px; display: flex; justify-content: center;">
        {{ $lessons->links() }}
    </div>
    @endif
</div>

@endsection