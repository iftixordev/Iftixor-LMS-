@extends('layouts.student')

@section('content')

<!-- Welcome Section -->
<div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 32px; border-radius: 16px; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <img src="{{ $student->photo_url }}" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.3);">
        <div>
            <h1 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 500;">Xush kelibsiz, {{ $student->full_name }}!</h1>
            <p style="margin: 0; opacity: 0.9; font-size: 16px;">Bugun {{ $groups->count() }} ta kursda o'qiyapsiz</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="gemini-stats">
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">{{ $groups->count() }}</div>
            <div class="gemini-stat-label">Faol kurslar</div>
            <div class="gemini-stat-change positive">Davom etmoqda</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">5</div>
            <div class="gemini-stat-label">Vazifalar</div>
            <div class="gemini-stat-change neutral">2 ta yangi</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">{{ $attendanceRate }}%</div>
            <div class="gemini-stat-label">Davomat</div>
            <div class="gemini-stat-change {{ $attendanceRate >= 80 ? 'positive' : 'negative' }}">Bu oyda</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-coins"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">{{ $student->coin_balance ?? 0 }}</div>
            <div class="gemini-stat-label">Coinlar</div>
            <div class="gemini-stat-change positive">+50 bu hafta</div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px; margin-bottom: 24px;">
    <!-- Left Column -->
    <div>
    
        <!-- My Courses -->
        <div class="gemini-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="gemini-card-title" style="margin: 0;">Mening Kurslarim</h2>
                <a href="{{ route('student.courses') }}" class="gemini-btn" style="padding: 8px 16px; font-size: 14px;">Barchasi</a>
            </div>
            
            <div style="display: grid; gap: 16px;">
                @forelse($groups as $group)
                <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: var(--gemini-bg); border-radius: 12px; border: 1px solid var(--gemini-border);">
                    <img src="{{ $group->course->photo_url }}" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">{{ $group->course->name }}</h3>
                        <p style="margin: 0 0 4px 0; color: var(--gemini-text-secondary); font-size: 14px;">Guruh: {{ $group->name }}</p>
                        <div style="font-size: 12px; color: var(--gemini-text-secondary);">
                            <i class="fas fa-user"></i> {{ $group->teacher->full_name }}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="background: var(--gemini-blue); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-bottom: 8px;">
                            {{ number_format($group->course->price) }} so'm
                        </div>
                        <div style="color: #4caf50; font-size: 12px; font-weight: 500;">Faol</div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 60px 20px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-book" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Hali kurslarga yozilmagansiz</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Right Sidebar -->
    <div>
        <!-- Quick Actions -->
        <div class="gemini-card" style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 500;">Tezkor Amallar</h3>
            <div style="display: grid; gap: 8px;">
                <a href="{{ route('student.schedule') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%;">
                    <i class="fas fa-calendar"></i> Bugungi Darslar
                </a>
                <a href="{{ route('student.assignments') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%; background: #ff9800;">
                    <i class="fas fa-tasks"></i> Vazifalar
                </a>
                <a href="{{ route('student.materials') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%; background: #4caf50;">
                    <i class="fas fa-download"></i> Materiallar
                </a>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="gemini-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 500;">So'nggi To'lovlar</h3>
                <a href="{{ route('student.payments') }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;">Barchasi</a>
            </div>
            
            <div style="display: grid; gap: 12px;">
                @forelse($payments as $payment)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                    <div>
                        <div style="font-weight: 500;">{{ number_format($payment->amount) }} so'm</div>
                        <div style="font-size: 12px; color: var(--gemini-text-secondary);">{{ $payment->payment_date->format('d.m.Y H:i') }}</div>
                    </div>
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px;">To'langan</span>
                </div>
                @empty
                <div style="text-align: center; padding: 40px 20px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-credit-card" style="font-size: 32px; margin-bottom: 12px; opacity: 0.5;"></i>
                    <p style="margin: 0;">To'lovlar tarixi yo'q</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events -->
<div class="gemini-card">
    <h2 class="gemini-card-title">Yaqin Tadbirlar</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
        <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(66, 133, 244, 0.1); border-radius: 12px;">
            <div style="width: 50px; height: 50px; background: var(--gemini-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">Bugungi Dars</h3>
                <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">14:00 - JavaScript</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(255, 152, 0, 0.1); border-radius: 12px;">
            <div style="width: 50px; height: 50px; background: #ff9800; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-tasks"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">Vazifa Muddati</h3>
                <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">Ertaga - HTML loyiha</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(76, 175, 80, 0.1); border-radius: 12px;">
            <div style="width: 50px; height: 50px; background: #4caf50; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">Imtihon</h3>
                <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">Kelgusi hafta</p>
            </div>
        </div>
    </div>
</div>
@endsection