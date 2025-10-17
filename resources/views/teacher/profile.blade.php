@extends('layouts.teacher')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Profile Card -->
    <div class="gemini-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <img src="{{ $teacher->photo_url }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 16px; border: 4px solid var(--gemini-border);">
            <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 500;">{{ $teacher->full_name }}</h2>
            <p style="margin: 0 0 16px 0; color: var(--gemini-text-secondary);">{{ $teacher->specialization ?? 'O\'qituvchi' }}</p>
            
            <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                Faol o'qituvchi
            </span>
        </div>
        
        <div style="display: grid; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                <i class="fas fa-phone" style="color: var(--gemini-blue);"></i>
                <span>{{ $teacher->phone }}</span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                <i class="fas fa-envelope" style="color: var(--gemini-blue);"></i>
                <span>{{ $teacher->email ?? 'Email kiritilmagan' }}</span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                <i class="fas fa-calendar" style="color: var(--gemini-blue);"></i>
                <span>{{ $teacher->created_at->format('d.m.Y') }} dan beri</span>
            </div>
        </div>
        
        <a href="{{ route('teacher.profile.edit') }}" class="gemini-btn" style="width: 100%; margin-top: 20px; text-align: center;">
            <i class="fas fa-edit"></i> Profilni tahrirlash
        </a>
    </div>
    
    <!-- Profile Details -->
    <div>
        <!-- Statistics -->
        <div class="gemini-stats" style="margin-bottom: 24px;">
            <div class="gemini-stat-card">
                <div class="gemini-stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="gemini-stat-content">
                    <div class="gemini-stat-number">{{ $teacher->groups->count() }}</div>
                    <div class="gemini-stat-label">Faol guruhlar</div>
                </div>
            </div>
            
            <div class="gemini-stat-card">
                <div class="gemini-stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="gemini-stat-content">
                    <div class="gemini-stat-number">{{ $teacher->groups->sum(function($group) { return $group->students->count(); }) }}</div>
                    <div class="gemini-stat-label">Jami o'quvchilar</div>
                </div>
            </div>
            
            <div class="gemini-stat-card">
                <div class="gemini-stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="gemini-stat-content">
                    <div class="gemini-stat-number">4.8</div>
                    <div class="gemini-stat-label">Reyting</div>
                </div>
            </div>
        </div>
        
        <!-- Personal Information -->
        <div class="gemini-card" style="margin-bottom: 24px;">
            <h2 class="gemini-card-title">Shaxsiy ma'lumotlar</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="gemini-label">To'liq ism</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $teacher->full_name }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Telefon raqam</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $teacher->phone }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Mutaxassislik</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $teacher->specialization ?? 'Kiritilmagan' }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Tajriba</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $teacher->experience ?? 'Kiritilmagan' }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Current Groups -->
        <div class="gemini-card">
            <h2 class="gemini-card-title">Joriy guruhlar</h2>
            
            <div style="display: grid; gap: 16px;">
                @forelse($teacher->groups as $group)
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
                    <img src="{{ $group->course->photo_url }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">{{ $group->course->name }}</h3>
                        <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">
                            Guruh: {{ $group->name }} • {{ $group->students->count() }} o'quvchi
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <div style="background: var(--gemini-blue); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            Faol
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px 20px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Hozircha guruhlar tayinlanmagan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection