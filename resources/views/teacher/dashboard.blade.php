@extends('layouts.teacher')

@section('content')

<!-- Welcome Section -->
<div style="background: linear-gradient(135deg, #4285f4, #34a853); color: white; padding: 32px; border-radius: 16px; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <img src="{{ $teacher->photo_url }}" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.3);">
        <div>
            <h1 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 500;">Salom, {{ $teacher->full_name }}!</h1>
            <p style="margin: 0; opacity: 0.9; font-size: 16px;">Bugun {{ $groups->count() }} ta guruhda dars berasiz</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="gemini-stats">
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">{{ $groups->count() }}</div>
            <div class="gemini-stat-label">Mening guruhlarim</div>
            <div class="gemini-stat-change positive">Faol</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">{{ $totalStudents }}</div>
            <div class="gemini-stat-label">Jami o'quvchilar</div>
            <div class="gemini-stat-change positive">Barcha guruhlar</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">8</div>
            <div class="gemini-stat-label">Vazifalar</div>
            <div class="gemini-stat-change neutral">5 ta yangi</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">3</div>
            <div class="gemini-stat-label">Bugungi darslar</div>
            <div class="gemini-stat-change positive">Rejalashtirilgan</div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">
    <!-- Left Column -->
    <div>
    
        <!-- My Groups -->
        <div class="gemini-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="gemini-card-title" style="margin: 0;">Mening Guruhlarim</h2>
                <a href="{{ route('teacher.groups') }}" class="gemini-btn" style="padding: 8px 16px; font-size: 14px;">Barchasi</a>
            </div>
            
            <div style="display: grid; gap: 16px;">
                @forelse($groups as $group)
                <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: var(--gemini-bg); border-radius: 12px; border: 1px solid var(--gemini-border);">
                    <img src="{{ $group->course->photo_url }}" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">{{ $group->course->name }}</h3>
                        <p style="margin: 0 0 8px 0; color: var(--gemini-text-secondary); font-size: 14px;">Guruh: {{ $group->name }}</p>
                        <div style="display: flex; gap: 16px; font-size: 12px; color: var(--gemini-text-secondary);">
                            <span><i class="fas fa-users"></i> {{ $group->students->count() }} o'quvchi</span>
                            <span><i class="fas fa-calendar"></i> Du, Chor, Juma</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="background: #4caf50; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-bottom: 8px;">
                            Faol
                        </div>
                        <a href="{{ route('teacher.groups.show', $group) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">Ko'rish</a>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 60px 20px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Hali guruhlar tayinlanmagan</p>
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
                <a href="{{ route('teacher.schedule') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%;">
                    <i class="fas fa-calendar"></i> Bugungi Darslar
                </a>
                <a href="{{ route('teacher.assignments') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%; background: #ff9800;">
                    <i class="fas fa-plus"></i> Vazifa Berish
                </a>
                <a href="{{ route('teacher.grades') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%; background: #4caf50;">
                    <i class="fas fa-star"></i> Baho Qo'yish
                </a>
                <a href="{{ route('teacher.attendance') }}" class="gemini-btn" style="justify-content: flex-start; width: 100%; background: #2196f3;">
                    <i class="fas fa-check"></i> Davomat
                </a>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="gemini-card">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 500;">Bugungi Darslar</h3>
            
            <div style="display: grid; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: rgba(66, 133, 244, 0.1); border-radius: 8px;">
                    <div style="width: 50px; height: 50px; background: var(--gemini-blue); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">JavaScript - JS-01</h4>
                        <p style="margin: 0 0 4px 0; color: var(--gemini-text-secondary);">09:00 - 10:30</p>
                        <div style="font-size: 12px; color: var(--gemini-text-secondary);">Xona: 101 | 15 o'quvchi</div>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: rgba(76, 175, 80, 0.1); border-radius: 8px;">
                    <div style="width: 50px; height: 50px; background: #4caf50; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">React - RC-02</h4>
                        <p style="margin: 0 0 4px 0; color: var(--gemini-text-secondary);">14:00 - 15:30</p>
                        <div style="font-size: 12px; color: var(--gemini-text-secondary);">Xona: 102 | 12 o'quvchi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="gemini-card">
    <h2 class="gemini-card-title">So'nggi Faoliyat</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
        <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(255, 152, 0, 0.1); border-radius: 12px;">
            <div style="width: 50px; height: 50px; background: #ff9800; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-tasks"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">5 ta yangi vazifa</h3>
                <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">Tekshirishni kutmoqda</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(33, 150, 243, 0.1); border-radius: 12px;">
            <div style="width: 50px; height: 50px; background: #2196f3; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-comments"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">3 ta yangi xabar</h3>
                <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">O'quvchilardan</p>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(76, 175, 80, 0.1); border-radius: 12px;">
            <div style="width: 50px; height: 50px; background: #4caf50; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">Davomat</h3>
                <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">Bugungi darslar uchun</p>
            </div>
        </div>
    </div>
</div>
@endsection