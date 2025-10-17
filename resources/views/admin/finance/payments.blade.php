@extends('layouts.admin')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4caf50, #45a049); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-day" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ number_format(\App\Models\Payment::whereDate('payment_date', today())->sum('amount')) }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Bugungi daromad</div>
                <div style="color: #4caf50; font-size: 12px;">+{{ number_format(\App\Models\Payment::whereDate('payment_date', today())->sum('amount')) }} so'm</div>
            </div>
        </div>
    </div>

    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #2196f3, #1976d2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar-alt" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ number_format(\App\Models\Payment::whereMonth('payment_date', now()->month)->sum('amount')) }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Oylik daromad</div>
                <div style="color: #2196f3; font-size: 12px;">+{{ number_format(\App\Models\Payment::whereMonth('payment_date', now()->month)->sum('amount')) }} so'm</div>
            </div>
        </div>
    </div>

    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff9800, #f57c00); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ number_format(\App\Models\Payment::whereYear('payment_date', now()->year)->sum('amount')) }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Yillik daromad</div>
                <div style="color: #ff9800; font-size: 12px;">+{{ number_format(\App\Models\Payment::whereYear('payment_date', now()->year)->sum('amount')) }} so'm</div>
            </div>
        </div>
    </div>

    <div class="gemini-card">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f44336, #d32f2f); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-clock" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 600; color: var(--gemini-text);">{{ \App\Models\Payment::where('status', 'pending')->count() }}</div>
                <div style="color: var(--gemini-text-secondary); font-size: 14px;">Kutilayotgan to'lovlar</div>
            </div>
        </div>
    </div>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">To'lovlar boshqaruvi</h1>
            <p class="gemini-card-subtitle">O'quvchilar to'lovlarini boshqaring</p>
        </div>
        <button type="button" class="gemini-btn btn-animate" onclick="document.getElementById('paymentModal').classList.add('active'); document.body.style.overflow='hidden';" id="newPaymentBtn">
            <i class="fas fa-plus"></i> Yangi To'lov
        </button>
    </div>
</div>

<!-- Quick Payment Form -->
<div id="quickPaymentForm" class="gemini-card" style="margin-bottom: 24px; display: none;">
    <form method="POST" action="{{ route('admin.finance.store-payment') }}">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 16px; align-items: end;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500;">O'quvchi</label>
                <select name="student_id" class="gemini-input" required>
                    <option value="">O'quvchini tanlang</option>
                    @foreach($students ?? [] as $student)
                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500;">Summa</label>
                <input type="number" name="amount" class="gemini-input" placeholder="500000" required min="1000" step="1000">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500;">Usul</label>
                <select name="payment_method" class="gemini-input" required>
                    <option value="cash">Naqd</option>
                    <option value="card">Karta</option>
                    <option value="transfer">O'tkazma</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500;">Sana</label>
                <input type="date" name="payment_date" class="gemini-input" value="{{ today()->format('Y-m-d') }}" required>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="gemini-btn" style="background: #4caf50; color: white;">
                    <i class="fas fa-save"></i> Saqlash
                </button>
                <button type="button" class="gemini-btn" onclick="togglePaymentForm()" style="background: #f44336; color: white;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <input type="hidden" name="payment_type" value="monthly">
        <input type="hidden" name="status" value="completed">
    </form>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <form method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--yt-text-secondary);">O'quvchi qidirish</label>
            <input type="text" name="student_search" class="gemini-input" placeholder="Ism yoki ID kiriting..." value="{{ request('student_search') }}">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--yt-text-secondary);">Boshlanish</label>
            <input type="date" name="date_from" class="gemini-input" value="{{ request('date_from') }}">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--yt-text-secondary);">Tugash</label>
            <input type="date" name="date_to" class="gemini-input" value="{{ request('date_to') }}">
        </div>
        <button type="submit" class="gemini-btn">
            <i class="fas fa-search"></i> Qidirish
        </button>
    </form>
</div>

<div class="gemini-card">
    <div class="gemini-table-container">
        <table class="gemini-table">
            <thead>
                <tr>
                    <th>O'quvchi</th>
                    <th>Summa</th>
                    <th>Chegirma</th>
                    <th>Yakuniy</th>
                    <th>Usul</th>
                    <th>Sana</th>
                    <th>Holat</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments ?? [] as $payment)
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
                    <td>{{ number_format($payment->original_amount ?? $payment->amount ?? 0) }} so'm</td>
                    <td>{{ $payment->discount_percent ?? 0 }}%</td>
                    <td>
                        <span style="font-weight: 600; color: var(--yt-spec-text-primary);">{{ number_format($payment->amount ?? 0) }}</span>
                        <span style="color: var(--yt-text-secondary); font-size: 12px;">so'm</span>
                    </td>
                    <td>
                        <span style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ ucfirst($payment->payment_method ?? 'naqd') }}
                        </span>
                    </td>
                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d.m.Y') : 'N/A' }}</td>
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
                            <a href="{{ route('admin.finance.receipt', $payment) }}" target="_blank" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: var(--yt-spec-button-chip-background-hover);">
                                <i class="fas fa-receipt"></i> Kvitansiya
                            </a>
                            <button onclick="editPayment({{ $payment->id }})" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #2196f3; color: white;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deletePayment({{ $payment->id }})" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 60px; color: var(--yt-text-secondary);">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                            <div style="width: 64px; height: 64px; background: var(--yt-spec-button-chip-background-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-credit-card" style="font-size: 24px; color: var(--yt-text-secondary);"></i>
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
    
    @if(isset($payments) && method_exists($payments, 'links'))
        {{ $payments->links('custom.pagination') }}
    @endif
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="payment-modal">
    <div class="payment-modal-overlay" onclick="closePaymentModal()"></div>
    <div class="payment-modal-content">
        <form method="POST" action="{{ route('admin.finance.store-payment') }}" id="paymentForm">
            @csrf
            <div class="payment-modal-header">
                <div>
                    <h2>Yangi To'lov</h2>
                    <p class="payment-modal-subtitle">To'lov ma'lumotlarini kiriting</p>
                </div>
                <button type="button" class="payment-modal-close" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="payment-modal-body">
                <!-- Student Selection Section -->
                <div class="payment-section">
                    <h3 class="payment-section-title">
                        <i class="fas fa-user"></i>
                        O'quvchi Ma'lumotlari
                    </h3>
                    
                    <div class="payment-form-group">
                        <label class="payment-form-label">O'quvchi tanlash *</label>
                        <input type="text" id="studentSearch" class="payment-form-input" placeholder="O'quvchi ismini yozing..." autocomplete="off">
                        <div id="studentResults" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; z-index: 1000;"></div>
                        <input type="hidden" name="student_id" id="selectedStudentId" required>
                        <div id="selectedStudent" style="display: none; margin-top: 8px; padding: 8px; background: #f0f0f0; border-radius: 4px;"></div>
                    </div>
                    
                    <div id="studentInfo" class="student-info" style="display: none;">
                        <div class="student-info-card">
                            <div class="student-info-item">
                                <span class="info-label">Telefon:</span>
                                <span id="studentPhone">-</span>
                            </div>
                            <div class="student-info-item">
                                <span class="info-label">Ota-ona:</span>
                                <span id="studentParent">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Details Section -->
                <div class="payment-section">
                    <h3 class="payment-section-title">
                        <i class="fas fa-money-bill"></i>
                        To'lov Tafsilotlari
                    </h3>
                    
                    <div class="payment-form-grid">
                        <div class="payment-form-group">
                            <label class="payment-form-label">To'lov turi *</label>
                            <select name="payment_type" id="paymentType" class="payment-form-input" required>
                                <option value="course">Kurs to'lovi</option>
                                <option value="monthly">Oylik to'lov</option>
                                <option value="debt">Qarz to'lovi</option>
                                <option value="advance">Oldindan to'lov</option>
                                <option value="other">Boshqa</option>
                            </select>
                        </div>
                        
                        <div class="payment-form-group">
                            <label class="payment-form-label">Summa (so'm) *</label>
                            <input type="number" name="amount" id="paymentAmount" class="payment-form-input" required min="0" step="1000" placeholder="500000">
                        </div>
                        
                        <div class="payment-form-group">
                            <label class="payment-form-label">Chegirma (%)</label>
                            <input type="number" name="discount_percent" id="paymentDiscount" class="payment-form-input" min="0" max="100" step="1" placeholder="0">
                        </div>
                        
                        <div class="payment-form-group">
                            <label class="payment-form-label">To'lov usuli *</label>
                            <select name="payment_method" class="payment-form-input" required>
                                <option value="cash">Naqd pul</option>
                                <option value="card">Bank kartasi</option>
                                <option value="transfer">Bank o'tkazmasi</option>
                                <option value="online">Online to'lov</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="payment-calculation">
                        <div class="calc-row">
                            <span>Asosiy summa:</span>
                            <span id="baseAmount">0 so'm</span>
                        </div>
                        <div class="calc-row">
                            <span>Chegirma:</span>
                            <span id="discountAmount">0 so'm</span>
                        </div>
                        <div class="calc-row total">
                            <span>Yakuniy summa:</span>
                            <span id="finalAmount">0 so'm</span>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info Section -->
                <div class="payment-section">
                    <h3 class="payment-section-title">
                        <i class="fas fa-info-circle"></i>
                        Qo'shimcha Ma'lumotlar
                    </h3>
                    
                    <div class="payment-form-grid">
                        <div class="payment-form-group">
                            <label class="payment-form-label">To'lov sanasi *</label>
                            <input type="date" name="payment_date" class="payment-form-input" value="{{ today()->format('Y-m-d') }}" required>
                        </div>
                        
                        <div class="payment-form-group">
                            <label class="payment-form-label">Holat</label>
                            <select name="status" class="payment-form-input">
                                <option value="completed">Tugallangan</option>
                                <option value="pending">Kutilmoqda</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="payment-form-group">
                        <label class="payment-form-label">Izoh</label>
                        <textarea name="notes" class="payment-form-input" rows="3" placeholder="Qo'shimcha ma'lumot yoki izohlar..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="payment-modal-footer">
                <button type="button" class="payment-btn-secondary" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i> Bekor qilish
                </button>
                <button type="submit" class="payment-btn-primary">
                    <i class="fas fa-save"></i> To'lovni Saqlash
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.payment-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.payment-modal.active {
    opacity: 1;
    visibility: visible;
}

.payment-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.payment-modal-content {
    position: relative;
    background: var(--gemini-surface);
    border-radius: 16px;
    width: min(800px, 95vw);
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    transform: scale(0.8);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid var(--gemini-border);
}

.payment-modal.active .payment-modal-content {
    transform: scale(1);
}

.payment-modal-header {
    padding: 24px;
    border-bottom: 1px solid var(--gemini-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--gemini-surface);
    border-radius: 16px 16px 0 0;
}

.payment-modal-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: var(--gemini-text);
}

.payment-modal-subtitle {
    margin: 4px 0 0 0;
    color: var(--gemini-text-secondary);
    font-size: 14px;
}

.payment-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--gemini-text-secondary);
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.payment-modal-close:hover {
    background: var(--gemini-hover);
    color: var(--gemini-text);
}

.payment-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    max-height: calc(90vh - 140px);
}

.payment-section {
    padding: 24px;
    border-bottom: 1px solid var(--gemini-border);
}

.payment-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 20px 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--gemini-text);
}

.payment-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.payment-form-group {
    display: flex;
    flex-direction: column;
}

.payment-form-label {
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--gemini-text);
    font-size: 14px;
}

.payment-form-input {
    padding: 12px 16px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
    font-size: 14px;
    transition: all 0.2s ease;
    resize: vertical;
}

.payment-form-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

.student-info {
    margin-top: 16px;
}

.student-info-card {
    background: var(--yt-spec-raised-background);
    border: 1px solid var(--yt-spec-10-percent-layer);
    border-radius: 8px;
    padding: 16px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.student-info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.info-label {
    font-weight: 500;
    color: var(--yt-text-secondary);
}

.payment-calculation {
    background: var(--yt-spec-raised-background);
    border: 1px solid var(--yt-spec-10-percent-layer);
    border-radius: 8px;
    padding: 16px;
    margin-top: 16px;
}

.calc-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--yt-spec-10-percent-layer);
}

.calc-row:last-child {
    border-bottom: none;
}

.calc-row.total {
    font-weight: 600;
    font-size: 16px;
    color: var(--yt-spec-text-primary);
    border-top: 2px solid var(--yt-spec-10-percent-layer);
    margin-top: 8px;
    padding-top: 12px;
}

.payment-modal-footer {
    padding: 24px;
    border-top: 1px solid var(--gemini-border);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: var(--gemini-bg);
    border-radius: 0 0 16px 16px;
}

.payment-btn-secondary {
    padding: 12px 24px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: transparent;
    color: var(--gemini-text);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.payment-btn-secondary:hover {
    background: var(--gemini-hover);
}

.payment-btn-primary {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    background: #2196f3;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.payment-btn-primary:hover {
    background: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

.student-search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--gemini-surface);
    border: 1px solid var(--gemini-border);
    border-radius: 8px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.payment-form-group {
    position: relative;
}

.student-result-item {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid var(--gemini-border);
    transition: background 0.2s ease;
}

.student-result-item:hover {
    background: var(--gemini-hover);
}

.student-result-item:last-child {
    border-bottom: none;
}

.selected-student {
    background: var(--gemini-bg);
    border: 1px solid var(--gemini-border);
    border-radius: 8px;
    padding: 12px 16px;
    margin-top: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.selected-student-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.selected-student-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.clear-student {
    background: none;
    border: none;
    color: var(--gemini-text-secondary);
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.clear-student:hover {
    background: var(--gemini-hover);
    color: var(--gemini-text);
}

@media (max-width: 768px) {
    .payment-modal-content {
        width: 100vw;
        height: 100vh;
        border-radius: 0;
        max-height: 100vh;
    }
    
    .payment-form-grid {
        grid-template-columns: 1fr;
    }
    
    .student-info-card {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Studentlar ma'lumotlarini global o'zgaruvchiga yuklash
window.studentsData = @json($students ?? []);

// Global functions
function togglePaymentForm() {
    const form = document.getElementById('quickPaymentForm');
    if (form) {
        if (form.style.display === 'none' || !form.style.display) {
            form.style.display = 'block';
            form.scrollIntoView({ behavior: 'smooth' });
        } else {
            form.style.display = 'none';
        }
    }
}



@if(isset($selectedStudent) && $selectedStudent)
// Sahifa yuklanganda tanlangan o'quvchini ko'rsatish
document.addEventListener('DOMContentLoaded', function() {
    if (window.selectStudent) {
        selectStudent(
            {{ $selectedStudent->id }}, 
            '{{ $selectedStudent->first_name }}', 
            '{{ $selectedStudent->last_name }}', 
            '{{ $selectedStudent->student_id }}', 
            '{{ $selectedStudent->phone ?? '' }}', 
            '{{ $selectedStudent->parent_name ?? '' }}'
        );
    }
});
@endif






</script>

<script src="{{ asset('js/payment-actions.js') }}"></script>
@endsection