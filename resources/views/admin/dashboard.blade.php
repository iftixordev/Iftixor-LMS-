@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="dashboard-title">
            <h1>Bosh sahifa</h1>
            <p>Tizim holati va statistikalar</p>
        </div>
        <div class="dashboard-time">
            <div class="current-time">{{ now()->format('H:i') }}</div>
            <div class="current-date">{{ now()->format('d.m.Y') }}</div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['total_students'] ?? 0 }}</div>
                <div class="stat-label">Jami O'quvchilar</div>
                <div class="stat-change positive">+{{ $stats['active_students'] ?? 0 }} faol</div>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['total_teachers'] ?? 0 }}</div>
                <div class="stat-label">O'qituvchilar</div>
                <div class="stat-change neutral">Barcha filiallar</div>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['total_courses'] ?? 0 }}</div>
                <div class="stat-label">Kurslar</div>
                <div class="stat-change positive">{{ $stats['total_groups'] ?? 0 }} guruh</div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($stats['monthly_revenue'] ?? 0, 0, '.', ' ') }}</div>
                <div class="stat-label">Oylik daromad (so'm)</div>
                <div class="stat-change positive">+{{ number_format($stats['today_revenue'] ?? 0, 0, '.', ' ') }} bugun</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Tezkor amallar</h3>
                <i class="fas fa-bolt"></i>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.students.create') }}" class="quick-action">
                    <div class="action-icon primary">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="action-text">
                        <div class="action-title">Yangi o'quvchi</div>
                        <div class="action-desc">O'quvchi qo'shish</div>
                    </div>
                </a>
                <a href="{{ route('admin.groups.create') }}" class="quick-action">
                    <div class="action-icon success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="action-text">
                        <div class="action-title">Yangi guruh</div>
                        <div class="action-desc">Guruh yaratish</div>
                    </div>
                </a>
                <a href="{{ route('admin.courses.create') }}" class="quick-action">
                    <div class="action-icon info">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="action-text">
                        <div class="action-title">Yangi kurs</div>
                        <div class="action-desc">Kurs qo'shish</div>
                    </div>
                </a>
                <a href="{{ route('admin.finance.index') }}" class="quick-action">
                    <div class="action-icon warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="action-text">
                        <div class="action-title">Moliya</div>
                        <div class="action-desc">Hisobotlar</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- System Status -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Tizim holati</h3>
                <i class="fas fa-server"></i>
            </div>
            <div class="system-status">
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <div class="status-text">
                        <div class="status-title">Tizim</div>
                        <div class="status-desc">Faol</div>
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <div class="status-text">
                        <div class="status-title">Ma'lumotlar bazasi</div>
                        <div class="status-desc">Ulangan</div>
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-indicator warning"></div>
                    <div class="status-text">
                        <div class="status-title">Zaxira nusxa</div>
                        <div class="status-desc">2 kun oldin</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="dashboard-card full-width">
            <div class="card-header">
                <h3>So'nggi faoliyat</h3>
                <i class="fas fa-history"></i>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon primary">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Yangi o'quvchi ro'yxatdan o'tdi</div>
                        <div class="activity-time">{{ now()->subMinutes(15)->format('H:i') }}</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">To'lov qabul qilindi</div>
                        <div class="activity-time">{{ now()->subHour()->format('H:i') }}</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon info">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Yangi dars jadvali yaratildi</div>
                        <div class="activity-time">{{ now()->subHours(2)->format('H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    padding: 0;
    max-width: 100%;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding: 24px;
    background: var(--gemini-surface);
    border-radius: 16px;
    border: 1px solid var(--gemini-border);
}

.dashboard-title h1 {
    font-size: 28px;
    font-weight: 600;
    color: var(--gemini-text);
    margin: 0;
}

.dashboard-title p {
    color: var(--gemini-text-secondary);
    margin: 4px 0 0 0;
    font-size: 14px;
}

.dashboard-time {
    text-align: right;
}

.current-time {
    font-size: 24px;
    font-weight: 600;
    color: var(--gemini-blue);
}

.current-date {
    font-size: 14px;
    color: var(--gemini-text-secondary);
    margin-top: 4px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.stat-card {
    background: var(--gemini-surface);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid var(--gemini-border);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.stat-primary .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-success .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-info .stat-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.stat-warning .stat-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: var(--gemini-text);
    line-height: 1;
}

.stat-label {
    font-size: 14px;
    color: var(--gemini-text-secondary);
    margin: 8px 0 4px 0;
}

.stat-change {
    font-size: 12px;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 8px;
}

.stat-change.positive {
    background: rgba(76, 175, 80, 0.1);
    color: #4caf50;
}

.stat-change.neutral {
    background: rgba(158, 158, 158, 0.1);
    color: #9e9e9e;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 24px;
}

.dashboard-card {
    background: var(--gemini-surface);
    border-radius: 16px;
    border: 1px solid var(--gemini-border);
    overflow: hidden;
}

.dashboard-card.full-width {
    grid-column: 1 / -1;
}

.card-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--gemini-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--gemini-text);
    margin: 0;
}

.card-header i {
    color: var(--gemini-text-secondary);
    font-size: 16px;
}

.quick-actions {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border-radius: 12px;
    text-decoration: none;
    color: var(--gemini-text);
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.quick-action:hover {
    background: var(--gemini-hover);
    color: var(--gemini-text);
    border-color: var(--gemini-border);
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
}

.action-icon.primary { background: var(--gemini-blue); }
.action-icon.success { background: #4caf50; }
.action-icon.info { background: #2196f3; }
.action-icon.warning { background: #ff9800; }

.action-title {
    font-weight: 500;
    font-size: 14px;
}

.action-desc {
    font-size: 12px;
    color: var(--gemini-text-secondary);
    margin-top: 2px;
}

.system-status {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-indicator.online { background: #4caf50; }
.status-indicator.warning { background: #ff9800; }
.status-indicator.offline { background: #f44336; }

.status-title {
    font-weight: 500;
    font-size: 14px;
}

.status-desc {
    font-size: 12px;
    color: var(--gemini-text-secondary);
    margin-top: 2px;
}

.activity-list {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.activity-item:hover {
    background: var(--gemini-hover);
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: white;
    flex-shrink: 0;
}

.activity-icon.primary { background: var(--gemini-blue); }
.activity-icon.success { background: #4caf50; }
.activity-icon.info { background: #2196f3; }

.activity-title {
    font-weight: 500;
    font-size: 14px;
}

.activity-time {
    font-size: 12px;
    color: var(--gemini-text-secondary);
    margin-top: 2px;
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        text-align: center;
        gap: 16px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection