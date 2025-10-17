@extends('layouts.admin')

@section('content')
<div class="gemini-stats">
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ number_format($stats['total_coins_earned']) }}</div>
        <div class="gemini-stat-label">Jami Coinlar</div>
    </div>
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ number_format($stats['total_coins_spent']) }}</div>
        <div class="gemini-stat-label">Sarflangan</div>
    </div>
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ $stats['active_students'] }}</div>
        <div class="gemini-stat-label">Faol O'quvchilar</div>
    </div>
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ $stats['shop_items'] }}</div>
        <div class="gemini-stat-label">Shop Mahsulotlar</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">
    <div class="gemini-card">
        <h2 class="gemini-card-title"><i class="fas fa-coins"></i> Coin Berish</h2>
        <form method="POST" action="{{ route('admin.gamification.add-coins') }}" style="display: grid; gap: 16px;">
            @csrf
            <div>
                <label class="gemini-label">O'quvchi</label>
                <select name="student_id" class="gemini-input" required>
                    <option value="">Tanlang...</option>
                    @foreach(App\Models\Student::where('status', 'active')->get() as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="gemini-label">Coin miqdori</label>
                <input type="number" name="amount" class="gemini-input" min="1" required>
            </div>
            <div>
                <label class="gemini-label">Sabab</label>
                <select name="reason" class="gemini-input" required>
                    <option value="attendance">Davomat</option>
                    <option value="homework">Uy vazifasi</option>
                    <option value="grade">Yaxshi baho</option>
                </select>
            </div>
            <button type="submit" class="gemini-btn">Coin Berish</button>
        </form>
    </div>

    <div class="gemini-card">
        <h2 class="gemini-card-title"><i class="fas fa-trophy"></i> Top O'quvchilar</h2>
        @foreach($topStudents as $index => $student)
        <div style="display: flex; align-items: center; margin-bottom: 12px; padding: 8px; border-radius: 6px; background: var(--gemini-bg);">
            <div style="margin-right: 12px;">
                <span style="background: {{ $index == 0 ? '#ffc107' : ($index == 1 ? '#6c757d' : '#343a40') }}; color: white; padding: 4px 8px; border-radius: 50%; font-size: 12px;">
                    {{ $index + 1 }}
                </span>
            </div>
            <div style="flex: 1;">
                <strong>{{ $student->full_name }}</strong>
            </div>
            <div>
                <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $student->balance }} coin</span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="gemini-card">
        <h2 class="gemini-card-title"><i class="fas fa-history"></i> Tranzaksiyalar</h2>
        @foreach($recentTransactions as $transaction)
        <div style="display: flex; align-items: center; margin-bottom: 12px; padding: 8px; border-radius: 6px; background: var(--gemini-bg);">
            <div style="margin-right: 12px;">
                <i class="fas fa-{{ $transaction->type == 'earned' ? 'plus' : 'minus' }}" style="color: {{ $transaction->type == 'earned' ? '#4caf50' : '#f44336' }};"></i>
            </div>
            <div style="flex: 1;">
                <strong>{{ $transaction->student->full_name }}</strong><br>
                <small style="color: var(--gemini-text-secondary);">{{ ucfirst($transaction->reason) }}</small>
            </div>
            <div style="text-align: right;">
                <span style="color: {{ $transaction->type == 'earned' ? '#4caf50' : '#f44336' }};">
                    {{ $transaction->type == 'earned' ? '+' : '-' }}{{ $transaction->amount }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="gemini-card">
    <h2 class="gemini-card-title">Tezkor Amallar</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <a href="{{ route('admin.gamification.shop') }}" class="gemini-btn" style="text-align: center; padding: 20px;">
            <i class="fas fa-store" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
            Shop Boshqaruvi
        </a>
        <a href="{{ route('admin.gamification.purchases') }}" class="gemini-btn" style="text-align: center; padding: 20px;">
            <i class="fas fa-shopping-cart" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
            Xaridlar
        </a>
    </div>
</div>
@endsection