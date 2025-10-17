@extends('layouts.youtube-admin')

@section('title', 'YouTube Style Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'O\'quv markazi boshqaruv paneli - YouTube uslubida')

@section('content')
<!-- Stats Cards -->
<div class="yt-stats-grid">
    <div class="yt-stat-card">
        <div class="yt-stat-header">
            <div class="yt-stat-icon students">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
        <div class="yt-stat-value">{{ $stats['students'] ?? 0 }}</div>
        <div class="yt-stat-label">Jami o'quvchilar</div>
        <div class="yt-stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +12% bu oyda
        </div>
    </div>
    
    <div class="yt-stat-card">
        <div class="yt-stat-header">
            <div class="yt-stat-icon teachers">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="yt-stat-value">{{ $stats['teachers'] ?? 0 }}</div>
        <div class="yt-stat-label">Jami o'qituvchilar</div>
        <div class="yt-stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +5% bu oyda
        </div>
    </div>
    
    <div class="yt-stat-card">
        <div class="yt-stat-header">
            <div class="yt-stat-icon courses">
                <i class="fas fa-book"></i>
            </div>
        </div>
        <div class="yt-stat-value">{{ $stats['courses'] ?? 0 }}</div>
        <div class="yt-stat-label">Faol kurslar</div>
        <div class="yt-stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +8% bu oyda
        </div>
    </div>
    
    <div class="yt-stat-card">
        <div class="yt-stat-header">
            <div class="yt-stat-icon revenue">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="yt-stat-value">{{ number_format($stats['revenue'] ?? 0) }}</div>
        <div class="yt-stat-label">Oylik daromad (so'm)</div>
        <div class="yt-stat-change positive">
            <i class="fas fa-arrow-up"></i>
            +15% bu oyda
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">
    <!-- Recent Activities -->
    <div class="yt-card">
        <div class="yt-card-header">
            <h3 class="yt-card-title">So'nggi faoliyatlar</h3>
        </div>
        <div class="yt-card-body" style="padding: 0;">
            <div class="yt-table-container" style="border: none; box-shadow: none;">
                <table class="yt-table">
                    <thead>
                        <tr>
                            <th>Faoliyat</th>
                            <th>Foydalanuvchi</th>
                            <th>Vaqt</th>
                            <th>Holat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user-plus" style="color: white; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">Yangi o'quvchi qo'shildi</div>
                                        <div style="font-size: 12px; color: var(--yt-text-secondary);">Ahmadjon Valiyev ro'yxatdan o'tdi</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <img src="https://ui-avatars.com/api/?name=Admin&background=ff0000&color=fff&size=24" style="width: 24px; height: 24px; border-radius: 50%;" alt="Admin">
                                    <span>Admin</span>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--yt-text-secondary); font-size: 13px;">5 daqiqa oldin</span>
                            </td>
                            <td>
                                <span class="yt-badge yt-badge-success">Muvaffaqiyatli</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-dollar-sign" style="color: white; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">To'lov qabul qilindi</div>
                                        <div style="font-size: 12px; color: var(--yt-text-secondary);">500,000 so'm - Python kursi</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <img src="https://ui-avatars.com/api/?name=Sardor&background=00b894&color=fff&size=24" style="width: 24px; height: 24px; border-radius: 50%;" alt="Sardor">
                                    <span>Sardor Karimov</span>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--yt-text-secondary); font-size: 13px;">15 daqiqa oldin</span>
                            </td>
                            <td>
                                <span class="yt-badge yt-badge-success">Tasdiqlangan</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #4facfe, #00f2fe); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-calendar-plus" style="color: white; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">Yangi dars jadvali</div>
                                        <div style="font-size: 12px; color: var(--yt-text-secondary);">JavaScript guruhi uchun jadval tuzildi</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <img src="https://ui-avatars.com/api/?name=Malika&background=6c5ce7&color=fff&size=24" style="width: 24px; height: 24px; border-radius: 50%;" alt="Malika">
                                    <span>Malika Tosheva</span>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--yt-text-secondary); font-size: 13px;">1 soat oldin</span>
                            </td>
                            <td>
                                <span class="yt-badge yt-badge-warning">Kutilmoqda</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #43e97b, #38f9d7); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-certificate" style="color: white; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">Sertifikat berildi</div>
                                        <div style="font-size: 12px; color: var(--yt-text-secondary);">Dilshod Rahimov - Web Development</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <img src="https://ui-avatars.com/api/?name=System&background=2d3436&color=fff&size=24" style="width: 24px; height: 24px; border-radius: 50%;" alt="System">
                                    <span>Tizim</span>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--yt-text-secondary); font-size: 13px;">2 soat oldin</span>
                            </td>
                            <td>
                                <span class="yt-badge yt-badge-success">Berildi</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="yt-card">
        <div class="yt-card-header">
            <h3 class="yt-card-title">Tezkor amallar</h3>
        </div>
        <div class="yt-card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="{{ route('admin.students.create') }}" class="yt-btn yt-btn-primary" style="text-decoration: none;">
                    <i class="fas fa-user-graduate"></i>
                    Yangi o'quvchi qo'shish
                </a>
                
                <a href="{{ route('admin.teachers.create') }}" class="yt-btn yt-btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Yangi o'qituvchi qo'shish
                </a>
                
                <a href="{{ route('admin.courses.create') }}" class="yt-btn yt-btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-book"></i>
                    Yangi kurs yaratish
                </a>
                
                <a href="{{ route('admin.groups.create') }}" class="yt-btn yt-btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-users"></i>
                    Yangi guruh tashkil qilish
                </a>
                
                <hr style="border: none; height: 1px; background: var(--yt-border); margin: 8px 0;">
                
                <a href="{{ route('admin.finance.index') }}" class="yt-btn yt-btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-chart-line"></i>
                    Moliyaviy hisobot
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="yt-btn yt-btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-file-alt"></i>
                    Hisobotlar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Monthly Revenue Chart -->
    <div class="yt-card">
        <div class="yt-card-header">
            <h3 class="yt-card-title">Oylik daromad</h3>
        </div>
        <div class="yt-card-body">
            <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(255, 0, 0, 0.05), rgba(255, 0, 0, 0.1)); border-radius: 8px;">
                <div style="text-align: center; color: var(--yt-text-secondary);">
                    <i class="fas fa-chart-line" style="font-size: 48px; margin-bottom: 16px; color: var(--yt-red);"></i>
                    <div>Grafik yuklanmoqda...</div>
                    <div style="font-size: 12px; margin-top: 8px;">Chart.js yoki boshqa grafik kutubxonasi kerak</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Student Enrollment Chart -->
    <div class="yt-card">
        <div class="yt-card-header">
            <h3 class="yt-card-title">O'quvchilar ro'yxati</h3>
        </div>
        <div class="yt-card-body">
            <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.1)); border-radius: 8px;">
                <div style="text-align: center; color: var(--yt-text-secondary);">
                    <i class="fas fa-chart-bar" style="font-size: 48px; margin-bottom: 16px; color: #667eea;"></i>
                    <div>Grafik yuklanmoqda...</div>
                    <div style="font-size: 12px; margin-top: 8px;">Chart.js yoki boshqa grafik kutubxonasi kerak</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events -->
<div class="yt-card" style="margin-top: 24px;">
    <div class="yt-card-header">
        <h3 class="yt-card-title">Yaqinlashayotgan tadbirlar</h3>
    </div>
    <div class="yt-card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px;">
            <div style="padding: 16px; border: 1px solid var(--yt-border); border-radius: 8px; background: linear-gradient(135deg, rgba(255, 0, 0, 0.05), rgba(255, 0, 0, 0.02));">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; background: var(--yt-red); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-alt" style="color: white;"></i>
                    </div>
                    <div>
                        <div style="font-weight: 500;">Python kursi boshlanishi</div>
                        <div style="font-size: 12px; color: var(--yt-text-secondary);">Ertaga, 09:00</div>
                    </div>
                </div>
                <div style="font-size: 13px; color: var(--yt-text-secondary);">
                    Yangi Python kursi guruhi bilan birinchi dars boshlanadi. 15 nafar o'quvchi qatnashadi.
                </div>
            </div>
            
            <div style="padding: 16px; border: 1px solid var(--yt-border); border-radius: 8px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(102, 126, 234, 0.02));">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; background: #667eea; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="color: white;"></i>
                    </div>
                    <div>
                        <div style="font-weight: 500;">O'qituvchilar yig'ilishi</div>
                        <div style="font-size: 12px; color: var(--yt-text-secondary);">Juma, 14:00</div>
                    </div>
                </div>
                <div style="font-size: 13px; color: var(--yt-text-secondary);">
                    Oylik o'qituvchilar yig'ilishi. Yangi o'quv dasturlari va metodikalar muhokamasi.
                </div>
            </div>
            
            <div style="padding: 16px; border: 1px solid var(--yt-border); border-radius: 8px; background: linear-gradient(135deg, rgba(67, 233, 123, 0.05), rgba(67, 233, 123, 0.02));">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <div style="width: 40px; height: 40px; background: #43e97b; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-certificate" style="color: white;"></i>
                    </div>
                    <div>
                        <div style="font-weight: 500;">Sertifikat topshirish marosimi</div>
                        <div style="font-size: 12px; color: var(--yt-text-secondary);">Kelasi hafta</div>
                    </div>
                </div>
                <div style="font-size: 13px; color: var(--yt-text-secondary);">
                    Web Development kursini muvaffaqiyatli tugatgan 8 nafar o'quvchiga sertifikat topshiriladi.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Dashboard specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
    const statCards = document.querySelectorAll('.yt-stat-card');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Auto-refresh stats every 30 seconds
    setInterval(function() {
        // You can add AJAX call here to refresh stats
        console.log('Refreshing stats...');
    }, 30000);
    
    // Add hover effects to activity items
    const activityRows = document.querySelectorAll('.yt-table tbody tr');
    activityRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endsection