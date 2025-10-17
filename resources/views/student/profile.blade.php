@extends('layouts.student')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Profile Card -->
    <div class="gemini-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <img src="{{ $student->photo_url }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 16px; border: 4px solid var(--gemini-border);">
            <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 500;">{{ $student->full_name }}</h2>
            <p style="margin: 0 0 16px 0; color: var(--gemini-text-secondary);">ID: {{ $student->student_id ?? 'ST' . str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</p>
            
            <span style="background: {{ $student->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; 
                         color: {{ $student->status == 'active' ? '#4caf50' : '#9e9e9e' }}; 
                         padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                {{ $student->status == 'active' ? 'Faol o\'quvchi' : 'Nofaol' }}
            </span>
        </div>
        
        <div style="display: grid; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                <i class="fas fa-phone" style="color: var(--gemini-blue);"></i>
                <span>{{ $student->phone }}</span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                <i class="fas fa-envelope" style="color: var(--gemini-blue);"></i>
                <span>{{ $student->email ?? 'Email kiritilmagan' }}</span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                <i class="fas fa-calendar" style="color: var(--gemini-blue);"></i>
                <span>{{ $student->created_at->format('d.m.Y') }} dan beri</span>
            </div>
        </div>
        
        <a href="{{ route('student.profile.edit') }}" class="gemini-btn" style="width: 100%; margin-top: 20px; text-align: center;">
            <i class="fas fa-edit"></i> Profilni tahrirlash
        </a>
    </div>
    
    <!-- Profile Details -->
    <div>
        <!-- Statistics -->
        <div class="gemini-stats" style="margin-bottom: 24px;">
            <div class="gemini-stat-card">
                <div class="gemini-stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="gemini-stat-content">
                    <div class="gemini-stat-number">{{ $student->groups->count() }}</div>
                    <div class="gemini-stat-label">Faol kurslar</div>
                </div>
            </div>
            
            <div class="gemini-stat-card">
                <div class="gemini-stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="gemini-stat-content">
                    <div class="gemini-stat-number">85%</div>
                    <div class="gemini-stat-label">Davomat</div>
                </div>
            </div>
            
            <div class="gemini-stat-card">
                <div class="gemini-stat-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="gemini-stat-content">
                    <div class="gemini-stat-number">{{ $student->coin_balance ?? 0 }}</div>
                    <div class="gemini-stat-label">Coinlar</div>
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
                        {{ $student->full_name }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Telefon raqam</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $student->phone }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Tug'ilgan sana</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $student->birth_date ? $student->birth_date->format('d.m.Y') : 'Kiritilmagan' }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Manzil</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $student->address ?? 'Kiritilmagan' }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Current Courses -->
        <div class="gemini-card">
            <h2 class="gemini-card-title">Joriy kurslar</h2>
            
            <div style="display: grid; gap: 16px;">
                @forelse($student->groups as $group)
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
                    <img src="{{ $group->course->photo_url }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">{{ $group->course->name }}</h3>
                        <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">
                            Guruh: {{ $group->name }} • O'qituvchi: {{ $group->teacher->full_name }}
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
                    <i class="fas fa-book" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Hozircha kurslarga yozilmagansiz</p>
                    <a href="{{ route('student.courses') }}" class="gemini-btn" style="margin-top: 16px;">
                        Kurslarni ko'rish
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection