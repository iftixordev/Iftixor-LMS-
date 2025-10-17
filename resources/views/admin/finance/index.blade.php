@extends('layouts.admin')

@section('content')
<div class="gemini-stats stagger-animation">
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $stats['today_revenue'] ?? 0 }}">0</div>
            <div class="gemini-stat-label">Bugungi daromad</div>
            <div class="gemini-stat-change positive">+{{ number_format($stats['today_revenue'] ?? 0) }} so'm</div>
        </div>
    </div>
    
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $stats['monthly_revenue'] ?? 0 }}">0</div>
            <div class="gemini-stat-label">Oylik daromad</div>
            <div class="gemini-stat-change positive">+{{ number_format($stats['monthly_revenue'] ?? 0) }} so'm</div>
        </div>
    </div>
    
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-coins"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $stats['yearly_revenue'] ?? 0 }}">0</div>
            <div class="gemini-stat-label">Yillik daromad</div>
            <div class="gemini-stat-change positive">+{{ number_format($stats['yearly_revenue'] ?? 0) }} so'm</div>
        </div>
    </div>
    
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $stats['pending_payments'] ?? 0 }}">0</div>
            <div class="gemini-stat-label">Kutilayotgan to'lovlar</div>
            <div class="gemini-stat-change neutral">{{ $stats['pending_payments'] ?? 0 }} ta</div>
        </div>
    </div>
</div>

<div class="gemini-card animate-on-scroll">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 class="gemini-card-title">So'nggi to'lovlar</h2>
            <p class="gemini-card-subtitle">Oxirgi to'lovlar tarixi</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.finance.payments') }}" class="gemini-btn btn-animate">
                <i class="fas fa-plus"></i> Yangi to'lov
            </a>
            <a href="{{ route('admin.finance.reports') }}" class="gemini-btn" style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary);">
                <i class="fas fa-chart-bar"></i> Hisobotlar
            </a>
        </div>
    </div>

    <div class="gemini-table-container">
        <table class="gemini-table">
            <thead>
                <tr>
                    <th>O'quvchi</th>
                    <th>Summa</th>
                    <th>Sana</th>
                    <th>Usul</th>
                    <th>Holat</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_payments ?? [] as $payment)
                <tr class="table-row-hover">
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: white; font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 500;">{{ $payment->student->first_name ?? 'N/A' }} {{ $payment->student->last_name ?? '' }}</div>
                                <div style="font-size: 12px; color: var(--yt-text-secondary);">{{ $payment->student->student_id ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: var(--yt-spec-text-primary);">{{ number_format($payment->amount ?? 0) }}</span>
                        <span style="color: var(--yt-text-secondary); font-size: 12px;">so'm</span>
                    </td>
                    <td>
                        <span style="color: var(--yt-text-secondary);">{{ $payment->payment_date ? $payment->payment_date->format('d.m.Y') : 'N/A' }}</span>
                    </td>
                    <td>
                        <span style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ ucfirst($payment->payment_method ?? 'naqd') }}
                        </span>
                    </td>
                    <td>
                        @if(($payment->status ?? 'completed') == 'completed')
                        <span style="background: #e8f5e8; color: #2e7d32; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-check-circle"></i> Tugallangan
                        </span>
                        @else
                        <span style="background: #fff3e0; color: #f57c00; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-clock"></i> Kutilmoqda
                        </span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: var(--yt-spec-button-chip-background-hover);">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: var(--yt-spec-button-chip-background-hover);">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px; color: var(--yt-text-secondary);">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                            <div style="width: 64px; height: 64px; background: var(--yt-spec-button-chip-background-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-receipt" style="font-size: 24px; color: var(--yt-text-secondary);"></i>
                            </div>
                            <div>
                                <div style="font-weight: 500; margin-bottom: 4px;">To'lovlar topilmadi</div>
                                <div style="font-size: 14px;">Yangi to'lov qo'shish uchun yuqoridagi tugmani bosing</div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection