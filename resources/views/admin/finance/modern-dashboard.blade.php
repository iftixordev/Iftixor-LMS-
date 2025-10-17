@extends('layouts.admin')

@section('content')
<div class="finance-dashboard">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1><i class="fas fa-chart-line"></i> Moliyaviy boshqaruv</h1>
            <p>{{ now()->format('F Y') }} - Moliyaviy hisobot</p>
        </div>
        <div class="header-actions">
            <button class="btn-secondary" onclick="exportReport()">
                <i class="fas fa-download"></i> Hisobot
            </button>
            <button class="btn-primary" onclick="openPaymentModal()">
                <i class="fas fa-plus"></i> To'lov qabul
            </button>
        </div>
    </div>

    <!-- Financial Stats -->
    <div class="finance-stats">
        <div class="stat-card revenue">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_revenue']) }}</h3>
                <p>Jami daromad (so'm)</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    +{{ $stats['revenue_growth'] }}% bu oyda
                </div>
            </div>
        </div>

        <div class="stat-card expenses">
            <div class="stat-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_expenses']) }}</h3>
                <p>Jami xarajatlar (so'm)</p>
                <div class="stat-trend down">
                    <i class="fas fa-arrow-down"></i>
                    -{{ $stats['expense_reduction'] }}% kamaydi
                </div>
            </div>
        </div>

        <div class="stat-card profit">
            <div class="stat-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['net_profit']) }}</h3>
                <p>Sof foyda (so'm)</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    +{{ $stats['profit_margin'] }}% margin
                </div>
            </div>
        </div>

        <div class="stat-card debt">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_debt']) }}</h3>
                <p>Jami qarzlar (so'm)</p>
                <div class="stat-trend neutral">
                    {{ $stats['debtors_count'] }} ta qarzdor
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="finance-content">
        <!-- Left Column -->
        <div class="content-left">
            <!-- Revenue Chart -->
            <div class="card chart-card">
                <div class="card-header">
                    <h3>Daromad dinamikasi</h3>
                    <div class="chart-controls">
                        <button class="btn-sm active" data-period="month">Oy</button>
                        <button class="btn-sm" data-period="quarter">Chorak</button>
                        <button class="btn-sm" data-period="year">Yil</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card transactions-card">
                <div class="card-header">
                    <h3>So'nggi tranzaksiyalar</h3>
                    <a href="{{ route('admin.finance.transactions') }}" class="view-all">Barchasini ko'rish</a>
                </div>
                <div class="transactions-list">
                    @forelse($recent_transactions as $transaction)
                    <div class="transaction-item {{ $transaction->type }}">
                        <div class="transaction-icon">
                            <i class="{{ $transaction->type == 'income' ? 'fas fa-arrow-down' : 'fas fa-arrow-up' }}"></i>
                        </div>
                        <div class="transaction-info">
                            <h4>{{ $transaction->description }}</h4>
                            <p>{{ $transaction->student->full_name ?? 'Tizim' }}</p>
                            <span class="transaction-time">{{ $transaction->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="transaction-amount {{ $transaction->type }}">
                            {{ $transaction->type == 'income' ? '+' : '-' }}{{ number_format($transaction->amount) }} so'm
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-exchange-alt"></i>
                        <p>Tranzaksiyalar yo'q</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="content-right">
            <!-- Payment Methods -->
            <div class="card payment-methods">
                <div class="card-header">
                    <h3>To'lov usullari</h3>
                </div>
                <div class="payment-stats">
                    <div class="payment-method">
                        <div class="method-info">
                            <i class="fas fa-money-bill"></i>
                            <span>Naqd</span>
                        </div>
                        <div class="method-amount">
                            {{ number_format($payment_methods['cash']) }} so'm
                        </div>
                        <div class="method-percentage">
                            {{ $payment_methods['cash_percentage'] }}%
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="method-info">
                            <i class="fas fa-credit-card"></i>
                            <span>Karta</span>
                        </div>
                        <div class="method-amount">
                            {{ number_format($payment_methods['card']) }} so'm
                        </div>
                        <div class="method-percentage">
                            {{ $payment_methods['card_percentage'] }}%
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="method-info">
                            <i class="fas fa-mobile-alt"></i>
                            <span>Online</span>
                        </div>
                        <div class="method-amount">
                            {{ number_format($payment_methods['online']) }} so'm
                        </div>
                        <div class="method-percentage">
                            {{ $payment_methods['online_percentage'] }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Debtors -->
            <div class="card debtors-card">
                <div class="card-header">
                    <h3>Eng katta qarzdarlar</h3>
                    <a href="{{ route('admin.finance.debtors') }}" class="view-all">Barchasini ko'rish</a>
                </div>
                <div class="debtors-list">
                    @forelse($top_debtors as $debtor)
                    <div class="debtor-item">
                        <div class="debtor-avatar">
                            <img src="{{ $debtor->photo_url }}" alt="{{ $debtor->full_name }}">
                        </div>
                        <div class="debtor-info">
                            <h4>{{ $debtor->full_name }}</h4>
                            <p>{{ $debtor->course->name }}</p>
                        </div>
                        <div class="debtor-amount">
                            {{ number_format($debtor->debt) }} so'm
                        </div>
                        <button class="btn-sm btn-primary" onclick="collectPayment({{ $debtor->id }})">
                            To'lov
                        </button>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>Qarzdarlar yo'q</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Monthly Goals -->
            <div class="card goals-card">
                <div class="card-header">
                    <h3>Oylik maqsadlar</h3>
                </div>
                <div class="goals-list">
                    <div class="goal-item">
                        <div class="goal-info">
                            <span>Daromad maqsadi</span>
                            <div class="goal-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $goals['revenue_progress'] }}%"></div>
                                </div>
                                <span>{{ $goals['revenue_progress'] }}%</span>
                            </div>
                        </div>
                        <div class="goal-amount">
                            {{ number_format($goals['revenue_target']) }} so'm
                        </div>
                    </div>
                    <div class="goal-item">
                        <div class="goal-info">
                            <span>Yangi o'quvchilar</span>
                            <div class="goal-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $goals['students_progress'] }}%"></div>
                                </div>
                                <span>{{ $goals['students_progress'] }}%</span>
                            </div>
                        </div>
                        <div class="goal-amount">
                            {{ $goals['students_target'] }} ta
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Yangi to'lov qabul qilish</h3>
            <button class="modal-close" onclick="closePaymentModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="paymentForm">
                <div class="form-group">
                    <label>O'quvchi</label>
                    <select name="student_id" required>
                        <option value="">O'quvchini tanlang</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->full_name }} - {{ $student->course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>To'lov miqdori</label>
                    <input type="number" name="amount" placeholder="Miqdorni kiriting" required>
                </div>
                <div class="form-group">
                    <label>To'lov usuli</label>
                    <select name="payment_method" required>
                        <option value="cash">Naqd</option>
                        <option value="card">Karta</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Izoh</label>
                    <textarea name="description" placeholder="Qo'shimcha ma'lumot"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closePaymentModal()">Bekor qilish</button>
                    <button type="submit" class="btn-primary">To'lovni saqlash</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.finance-dashboard {
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
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.finance-stats {
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

.stat-card.revenue .stat-icon { background: linear-gradient(135deg, #48bb78, #38a169); }
.stat-card.expenses .stat-icon { background: linear-gradient(135deg, #ed8936, #dd6b20); }
.stat-card.profit .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.stat-card.debt .stat-icon { background: linear-gradient(135deg, #f56565, #e53e3e); }

.stat-content h3 {
    font-size: 28px;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    margin-top: 8px;
}

.stat-trend.up { background: #e6fffa; color: #38a169; }
.stat-trend.down { background: #fed7d7; color: #e53e3e; }
.stat-trend.neutral { background: #edf2f7; color: #4a5568; }

.finance-content {
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

.chart-container {
    padding: 20px;
    height: 300px;
}

.transactions-list {
    padding: 20px;
    max-height: 400px;
    overflow-y: auto;
}

.transaction-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.transaction-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.transaction-item.income .transaction-icon { background: #48bb78; }
.transaction-item.expense .transaction-icon { background: #f56565; }

.transaction-amount.income { color: #38a169; }
.transaction-amount.expense { color: #e53e3e; }

.payment-stats {
    padding: 20px;
}

.payment-method {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.method-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.method-percentage {
    font-size: 12px;
    color: #718096;
}

.debtors-list {
    padding: 20px;
}

.debtor-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.debtor-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.debtor-amount {
    color: #e53e3e;
    font-weight: 600;
    margin-left: auto;
    margin-right: 12px;
}

.goals-list {
    padding: 20px;
}

.goal-item {
    margin-bottom: 20px;
}

.goal-progress {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    transition: width 0.3s ease;
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
    margin: 5% auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 4px;
    font-weight: 500;
    color: #4a5568;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: white;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 768px) {
    .finance-content {
        grid-template-columns: 1fr;
    }
    
    .finance-stats {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function openPaymentModal() {
    document.getElementById('paymentModal').style.display = 'block';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

function collectPayment(studentId) {
    // Auto-fill student in payment modal
    document.querySelector('[name="student_id"]').value = studentId;
    openPaymentModal();
}

// Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyun'],
        datasets: [{
            label: 'Daromad',
            data: [15000000, 18000000, 22000000, 19000000, 25000000, 28000000],
            borderColor: '#48bb78',
            backgroundColor: 'rgba(72, 187, 120, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Xarajatlar',
            data: [8000000, 9000000, 11000000, 10000000, 12000000, 13000000],
            borderColor: '#f56565',
            backgroundColor: 'rgba(245, 101, 101, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
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