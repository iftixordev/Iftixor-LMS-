@extends('layouts.admin')

@section('content')
<div class="gemini-card" style="margin-bottom: 24px;">
    <div>
        <h1 class="gemini-card-title" style="margin-bottom: 4px;">Moliyaviy Hisobot</h1>
        <p class="gemini-card-subtitle">Daromad va xarajatlar tahlili</p>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4caf50, #45a049); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-day" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ number_format($stats['daily_income'] ?? 0) }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Bugungi daromad</div>
                <div style="color: #4caf50; font-size: 12px;">+{{ number_format($stats['daily_income'] ?? 0) }} so'm</div>
            </div>
        </div>
    </div>

    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #2196f3, #1976d2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-alt" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ number_format($stats['monthly_income'] ?? 0) }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Oylik daromad</div>
                <div style="color: #2196f3; font-size: 12px;">+{{ number_format($stats['monthly_income'] ?? 0) }} so'm</div>
            </div>
        </div>
    </div>

    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff9800, #f57c00); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ number_format($stats['yearly_income'] ?? 0) }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Yillik daromad</div>
                <div style="color: #ff9800; font-size: 12px;">+{{ number_format($stats['yearly_income'] ?? 0) }} so'm</div>
            </div>
        </div>
    </div>

    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f44336, #d32f2f); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-clock" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ $stats['pending_payments'] ?? 0 }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Kutilayotgan to'lovlar</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Reports -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    <div class="gemini-card">
        <h3 style="margin-bottom: 16px;">Oylik Daromad Grafigi</h3>
        <canvas id="monthlyChart" width="400" height="200"></canvas>
    </div>
    
    <div class="gemini-card">
        <h3 style="margin-bottom: 16px;">Xarajatlar Taqsimoti</h3>
        <canvas id="expenseChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Recent Transactions -->
<div class="gemini-card">
    <h3 style="margin-bottom: 16px;">So'nggi Tranzaksiyalar</h3>
    <div class="gemini-table-container">
        <table class="gemini-table">
            <thead>
                <tr>
                    <th>Sana</th>
                    <th>Tavsif</th>
                    <th>Turi</th>
                    <th>Summa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_payments ?? [] as $payment)
                <tr>
                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d.m.Y') : '-' }}</td>
                    <td>{{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}</td>
                    <td>
                        <span style="background: #e8f5e8; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            Daromad
                        </span>
                    </td>
                    <td style="color: #4caf50; font-weight: 600;">+{{ number_format($payment->amount ?? 0) }} so'm</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                        Tranzaksiyalar topilmadi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyun'],
        datasets: [{
            label: 'Daromad',
            data: [1200000, 1900000, 3000000, 5000000, 2000000, 3000000],
            borderColor: '#2196f3',
            backgroundColor: 'rgba(33, 150, 243, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
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
                        return value.toLocaleString() + ' so\'m';
                    }
                }
            }
        }
    }
});

// Expense Chart
const expenseCtx = document.getElementById('expenseChart').getContext('2d');
new Chart(expenseCtx, {
    type: 'doughnut',
    data: {
        labels: ['Maoshlar', 'Ijara', 'Kommunal', 'Boshqa'],
        datasets: [{
            data: [60, 20, 10, 10],
            backgroundColor: ['#4caf50', '#2196f3', '#ff9800', '#f44336']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection