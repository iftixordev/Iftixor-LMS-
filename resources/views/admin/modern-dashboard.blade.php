@extends('layouts.admin')

@section('content')
<div class="modern-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>O'quv markazi boshqaruvi</h1>
            <p>{{ now()->format('d.m.Y') }} - {{ auth()->user()->branch->name ?? 'Asosiy filial' }}</p>
        </div>
        <div class="header-actions">
            <button class="btn-primary" onclick="openQuickAdd()">
                <i class="fas fa-plus"></i> Tezkor qo'shish
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card students">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_students'] }}</h3>
                <p>Jami o'quvchilar</p>
                <span class="trend up">+{{ $stats['new_students_this_month'] }} bu oyda</span>
            </div>
        </div>

        <div class="stat-card teachers">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_teachers'] }}</h3>
                <p>O'qituvchilar</p>
                <span class="trend neutral">{{ $stats['active_teachers'] }} faol</span>
            </div>
        </div>

        <div class="stat-card courses">
            <div class="stat-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['active_courses'] }}</h3>
                <p>Faol kurslar</p>
                <span class="trend neutral">{{ $stats['total_groups'] }} guruh</span>
            </div>
        </div>

        <div class="stat-card revenue">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>{{ number_format($stats['monthly_revenue']) }}</h3>
                <p>Oylik daromad (so'm)</p>
                <span class="trend up">+18% o'sish</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Left Column -->
        <div class="content-left">
            <!-- Recent Activities -->
            <div class="card activities-card">
                <div class="card-header">
                    <h3>So'nggi faoliyatlar</h3>
                    <a href="{{ route('admin.reports.index') }}" class="view-all">Barchasini ko'rish</a>
                </div>
                <div class="activities-list">
                    @forelse($recent_activities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity['type'] }}">
                            <i class="{{ $activity['icon'] }}"></i>
                        </div>
                        <div class="activity-content">
                            <p>{{ $activity['description'] }}</p>
                            <span class="activity-time">{{ $activity['time'] }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-clock"></i>
                        <p>Hozircha faoliyat yo'q</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3>Daromad tahlili</h3>
                    <div class="chart-controls">
                        <button class="btn-sm active" data-period="week">Hafta</button>
                        <button class="btn-sm" data-period="month">Oy</button>
                        <button class="btn-sm" data-period="year">Yil</button>
                    </div>
                </div>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Right Column -->
        <div class="content-right">
            <!-- Quick Actions -->
            <div class="card quick-actions">
                <div class="card-header">
                    <h3>Tezkor amallar</h3>
                </div>
                <div class="actions-grid">
                    <a href="{{ route('admin.students.create') }}" class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        <span>Yangi o'quvchi</span>
                    </a>
                    <a href="{{ route('admin.teachers.create') }}" class="action-btn">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Yangi o'qituvchi</span>
                    </a>
                    <a href="{{ route('admin.courses.create') }}" class="action-btn">
                        <i class="fas fa-book"></i>
                        <span>Yangi kurs</span>
                    </a>
                    <a href="{{ route('admin.groups.create') }}" class="action-btn">
                        <i class="fas fa-users"></i>
                        <span>Yangi guruh</span>
                    </a>
                    <a href="{{ route('admin.finance.payments') }}" class="action-btn">
                        <i class="fas fa-credit-card"></i>
                        <span>To'lov qabul</span>
                    </a>
                    <a href="{{ route('admin.attendance.index') }}" class="action-btn">
                        <i class="fas fa-calendar-check"></i>
                        <span>Davomat</span>
                    </a>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card events-card">
                <div class="card-header">
                    <h3>Yaqinlashayotgan tadbirlar</h3>
                </div>
                <div class="events-list">
                    @forelse($upcoming_events as $event)
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">{{ $event['date']->format('d') }}</span>
                            <span class="month">{{ $event['date']->format('M') }}</span>
                        </div>
                        <div class="event-info">
                            <h4>{{ $event['title'] }}</h4>
                            <p>{{ $event['description'] }}</p>
                            <span class="event-time">{{ $event['time'] }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-calendar"></i>
                        <p>Tadbirlar yo'q</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Performers -->
            <div class="card performers-card">
                <div class="card-header">
                    <h3>Eng yaxshi o'quvchilar</h3>
                </div>
                <div class="performers-list">
                    @forelse($top_students as $student)
                    <div class="performer-item">
                        <div class="performer-avatar">
                            <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}">
                        </div>
                        <div class="performer-info">
                            <h4>{{ $student->full_name }}</h4>
                            <p>{{ $student->course->name }}</p>
                        </div>
                        <div class="performer-score">
                            <span>{{ $student->average_score }}%</span>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-trophy"></i>
                        <p>Ma'lumot yo'q</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Add Modal -->
<div id="quickAddModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tezkor qo'shish</h3>
            <button class="modal-close" onclick="closeQuickAdd()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="quick-add-options">
                <a href="{{ route('admin.students.create') }}" class="quick-option">
                    <i class="fas fa-user-graduate"></i>
                    <span>O'quvchi</span>
                </a>
                <a href="{{ route('admin.teachers.create') }}" class="quick-option">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>O'qituvchi</span>
                </a>
                <a href="{{ route('admin.courses.create') }}" class="quick-option">
                    <i class="fas fa-book"></i>
                    <span>Kurs</span>
                </a>
                <a href="{{ route('admin.groups.create') }}" class="quick-option">
                    <i class="fas fa-users"></i>
                    <span>Guruh</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.modern-dashboard {
    padding: 20px;
    background: #f8fafc;
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.header-content h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
}

.header-content p {
    color: #718096;
    margin: 5px 0 0 0;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.stat-card.students .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.stat-card.teachers .stat-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }
.stat-card.courses .stat-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.stat-card.revenue .stat-icon { background: linear-gradient(135deg, #43e97b, #38f9d7); }

.stat-info h3 {
    font-size: 32px;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
}

.stat-info p {
    color: #718096;
    margin: 4px 0;
    font-weight: 500;
}

.trend {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
}

.trend.up { background: #e6fffa; color: #38a169; }
.trend.down { background: #fed7d7; color: #e53e3e; }
.trend.neutral { background: #edf2f7; color: #4a5568; }

.dashboard-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.card-header {
    padding: 20px 20px 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a202c;
    margin: 0;
}

.view-all {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.activities-list {
    padding: 20px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.activity-icon.student { background: #667eea; }
.activity-icon.teacher { background: #f093fb; }
.activity-icon.payment { background: #43e97b; }

.activity-content p {
    margin: 0;
    font-weight: 500;
    color: #1a202c;
}

.activity-time {
    font-size: 12px;
    color: #718096;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 20px;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    color: #4a5568;
    transition: all 0.3s ease;
}

.action-btn:hover {
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
}

.action-btn i {
    font-size: 24px;
}

.action-btn span {
    font-size: 12px;
    font-weight: 500;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #718096;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: #000000;
}

.modal-content {
    background: white;
    margin: 10% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #718096;
}

.quick-add-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    padding: 20px;
}

.quick-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 24px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    color: #4a5568;
    transition: all 0.3s ease;
}

.quick-option:hover {
    border-color: #667eea;
    color: #667eea;
}

.quick-option i {
    font-size: 32px;
}

@media (max-width: 768px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function openQuickAdd() {
    document.getElementById('quickAddModal').style.display = 'block';
}

function closeQuickAdd() {
    document.getElementById('quickAddModal').style.display = 'none';
}

// Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyun'],
        datasets: [{
            label: 'Daromad',
            data: [12000000, 15000000, 18000000, 16000000, 22000000, 25000000],
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return (value / 1000000) + 'M';
                    }
                }
            }
        }
    }
});
</script>
@endpush