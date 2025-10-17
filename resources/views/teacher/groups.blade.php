@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Mening Guruhlarim</h1>
    <p class="gemini-card-subtitle">Sizga tayinlangan guruhlar va ularning ma'lumotlari</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 24px;">
    @forelse(Auth::user()->teacher->groups ?? [] as $group)
    <div class="gemini-card" style="margin: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 500;">{{ $group->course->name }}</h2>
            <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 500;">
                Faol
            </span>
        </div>
        
        <p style="margin: 0 0 20px 0; color: var(--gemini-text-secondary); line-height: 1.5;">{{ $group->course->description }}</p>
        
        <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <div style="margin-bottom: 12px;">
                <span style="font-size: 12px; color: var(--gemini-text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">Guruh</span>
                <div style="font-weight: 500; font-size: 16px;">{{ $group->name }}</div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">O'quvchilar</span>
                    <div style="font-weight: 500;">{{ $group->students->count() }} kishi</div>
                </div>
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Jadval</span>
                    <div style="font-weight: 500;">Du, Chor, Juma</div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Boshlanish</span>
                    <div style="font-weight: 500;">{{ $group->start_date ? $group->start_date->format('d.m.Y') : '-' }}</div>
                </div>
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Tugash</span>
                    <div style="font-weight: 500;">{{ $group->end_date ? $group->end_date->format('d.m.Y') : '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 14px; color: var(--gemini-text-secondary);">Kurs jarayoni</span>
                <span style="font-size: 14px; font-weight: 500; color: var(--gemini-blue);">65%</span>
            </div>
            <div style="background: var(--gemini-border); height: 8px; border-radius: 4px; overflow: hidden;">
                <div style="background: var(--gemini-blue); height: 100%; width: 65%; transition: width 0.3s ease;"></div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
            <a href="{{ route('teacher.groups.show', $group) }}" class="gemini-btn" style="padding: 8px 12px; font-size: 12px; text-align: center;">
                <i class="fas fa-users"></i> O'quvchilar
            </a>
            <a href="{{ route('teacher.grades') }}" class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #4caf50; text-align: center;">
                <i class="fas fa-star"></i> Baholar
            </a>
            <a href="{{ route('teacher.attendance') }}" class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #2196f3; text-align: center;">
                <i class="fas fa-check"></i> Davomat
            </a>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: var(--gemini-text-secondary);">
        <i class="fas fa-users" style="font-size: 64px; margin-bottom: 24px; opacity: 0.5;"></i>
        <h2 style="margin: 0 0 12px 0; font-size: 24px; font-weight: 400;">Hali guruhlar tayinlanmagan</h2>
        <p style="margin: 0; font-size: 16px;">Ma'muriyat tomonidan guruhlar tayinlanishini kuting</p>
    </div>
    @endforelse
</div>
@endsection