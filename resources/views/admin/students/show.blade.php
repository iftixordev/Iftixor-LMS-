@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 8px;">{{ $student->full_name }}</h1>
            <span style="background: {{ $student->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $student->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 6px 12px; border-radius: 16px; font-size: 14px; border: 1px solid {{ $student->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                {{ $student->status == 'active' ? 'Faol' : 'Nofaol' }}
            </span>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.students.edit', $student) }}" class="gemini-btn">
                <i class="fas fa-edit"></i> Tahrirlash
            </a>
            <a href="{{ route('admin.students.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 24px;">
        <!-- Left Panel -->
        <div>
            <div class="gemini-card" style="text-align: center; margin-bottom: 16px;">
                <img src="{{ $student->photo_url }}" width="120" height="120" style="border-radius: 50%; margin-bottom: 12px;" alt="{{ $student->full_name }}">
                <h3 style="margin-bottom: 4px;">{{ $student->full_name }}</h3>
                <p style="color: var(--gemini-text-secondary); margin: 0;">{{ $student->student_id }}</p>
            </div>
            
            <div class="gemini-card" style="margin-bottom: 16px;">
                <h3 style="font-size: 16px; margin-bottom: 12px;">Umumiy Ma'lumotlar</h3>
                <div style="display: grid; gap: 8px; font-size: 14px;">
                    <div><strong>Telefon:</strong> {{ $student->phone }}</div>
                    <div><strong>Tug'ilgan:</strong> {{ $student->birth_date->format('d.m.Y') }}</div>
                    <div><strong>Jinsi:</strong> {{ $student->gender == 'male' ? 'Erkak' : 'Ayol' }}</div>
                    <div><strong>Manzil:</strong> {{ $student->address }}</div>
                    <div><strong>Ro'yxatga olingan:</strong> {{ $student->enrollment_date->format('d.m.Y') }}</div>
                    <div>
                        <strong>Coin balansi:</strong> 
                        <span style="background: rgba(255, 193, 7, 0.1); color: #ff9800; padding: 4px 8px; border-radius: 12px; font-size: 12px;">{{ $student->coin_balance }} coin</span>
                    </div>
                </div>
            </div>
            
            @if($student->parent_name)
            <div class="gemini-card">
                <h3 style="font-size: 16px; margin-bottom: 12px;">Ota-ona Ma'lumotlari</h3>
                <div style="display: grid; gap: 8px; font-size: 14px;">
                    <div><strong>Ism:</strong> {{ $student->parent_name }}</div>
                    <div><strong>Telefon:</strong> {{ $student->parent_phone }}</div>
                </div>
            </div>
            @endif
        </div>
    
    <!-- Main Content - Tabs -->
    <div>
        <div class="gemini-card">
            <div style="border-bottom: 1px solid var(--gemini-border); margin-bottom: 24px;">
                <ul style="display: flex; list-style: none; margin: 0; padding: 0; gap: 24px;" role="tablist">
                    <li>
                        <a style="display: block; padding: 12px 0; color: var(--gemini-blue); text-decoration: none; border-bottom: 2px solid var(--gemini-blue); font-weight: 500;" data-bs-toggle="tab" href="#groups-tab">Kurslar va Guruhlar</a>
                    </li>
                    <li>
                        <a style="display: block; padding: 12px 0; color: var(--gemini-text-secondary); text-decoration: none; border-bottom: 2px solid transparent; font-weight: 500;" data-bs-toggle="tab" href="#payments-tab">To'lovlar Tarixi</a>
                    </li>
                    <li>
                        <a style="display: block; padding: 12px 0; color: var(--gemini-text-secondary); text-decoration: none; border-bottom: 2px solid transparent; font-weight: 500;" data-bs-toggle="tab" href="#attendance-tab">Davomat</a>
                    </li>
                    <li>
                        <a style="display: block; padding: 12px 0; color: var(--gemini-text-secondary); text-decoration: none; border-bottom: 2px solid transparent; font-weight: 500;" data-bs-toggle="tab" href="#certificates-tab">Sertifikatlar</a>
                    </li>
                </ul>
            </div>
            <div>
                <div class="tab-content">
                    <!-- Groups Tab -->
                    <div class="tab-pane fade show active" id="groups-tab">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <h6 style="color: var(--gemini-text); margin: 0;">Qatnashayotgan Guruhlar</h6>
                            <button type="button" class="gemini-btn" onclick="openGroupModal()">
                                <i class="fas fa-plus"></i> Yangi Guruhga Qo'shish
                            </button>
                        </div>
                        <table class="gemini-table">
                            <thead>
                                <tr>
                                    <th>Kurs</th>
                                    <th>Guruh</th>
                                    <th>O'qituvchi</th>
                                    <th>Muddat</th>
                                    <th>Holat</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->groups as $group)
                                <tr>
                                    <td>{{ $group->course->name ?? 'N/A' }}</td>
                                    <td>{{ $group->name ?? 'N/A' }}</td>
                                    <td>{{ $group->teacher->full_name ?? 'N/A' }}</td>
                                    <td>{{ $group->start_date?->format('d.m.Y') ?? 'N/A' }} - {{ $group->end_date?->format('d.m.Y') ?? 'N/A' }}</td>
                                    <td><span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $group->pivot->status ?? 'active' }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.groups.remove-student', [$group->id, $student->id]) }}" style="display: inline;" onsubmit="return confirm('Guruhdan chiqarmoqchimisiz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;">Chiqarish</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Hech qaysi guruhga a'zo emas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Payments Tab -->
                    <div class="tab-pane fade" id="payments-tab">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <h6 style="color: var(--gemini-text); margin: 0;">To'lovlar Tarixi</h6>
                            <button type="button" class="gemini-btn" style="background: #4caf50;" onclick="openPaymentModal({{ $student->id }})">
                                <i class="fas fa-plus"></i> Yangi To'lov
                            </button>
                        </div>
                        <table class="gemini-table">
                            <thead>
                                <tr>
                                    <th>Sana</th>
                                    <th>Summa</th>
                                    <th>Usul</th>
                                    <th>Holat</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->payments->take(10) as $payment)
                                <tr>
                                    <td>{{ $payment->payment_date->format('d.m.Y') }}</td>
                                    <td>{{ number_format($payment->amount) }} so'm</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td><span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $payment->status }}</span></td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('admin.finance.receipt', $payment) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #2196f3;">Kvitansiya</a>
                                            <button onclick="deletePayment({{ $payment->id }})" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">To'lovlar yo'q</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($student->payments->count() > 0)
                        <div style="margin-top: 16px; color: var(--gemini-text);">
                            <strong>Jami to'langan:</strong> {{ number_format($student->payments->sum('amount')) }} so'm
                        </div>
                        @endif
                    </div>
                    
                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="attendance-tab">
                        <h6 style="color: var(--gemini-text); margin-bottom: 16px;">Davomat Statistikasi</h6>
                        @php
                            $totalAttendance = $student->attendances->count();
                            $presentCount = $student->attendances->where('status', 'present')->count();
                            $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;
                        @endphp
                        
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
                            <div style="text-align: center;">
                                <h3 style="color: {{ $attendanceRate >= 80 ? '#4caf50' : ($attendanceRate >= 60 ? '#ff9800' : '#f44336') }}; margin-bottom: 8px;">
                                    {{ $attendanceRate }}%
                                </h3>
                                <p style="color: var(--gemini-text-secondary); margin: 0;">Davomat foizi</p>
                            </div>
                            <div style="text-align: center;">
                                <h4 style="color: var(--gemini-text); margin-bottom: 8px;">{{ $presentCount }}</h4>
                                <p style="color: var(--gemini-text-secondary); margin: 0;">Kelgan darslar</p>
                            </div>
                            <div style="text-align: center;">
                                <h4 style="color: var(--gemini-text); margin-bottom: 8px;">{{ $totalAttendance - $presentCount }}</h4>
                                <p style="color: var(--gemini-text-secondary); margin: 0;">Kelmagan darslar</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Certificates Tab -->
                    <div class="tab-pane fade" id="certificates-tab">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <h6 style="color: var(--gemini-text); margin: 0;">Berilgan Sertifikatlar</h6>
                            <a href="{{ route('admin.certificates.create') }}?student_id={{ $student->id }}" class="gemini-btn" style="background: #ff9800;">Sertifikat Berish</a>
                        </div>
                        <table class="gemini-table">
                            <thead>
                                <tr>
                                    <th>Raqam</th>
                                    <th>Kurs</th>
                                    <th>Berilgan</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->certificates ?? [] as $certificate)
                                <tr>
                                    <td>{{ $certificate->certificate_number }}</td>
                                    <td>{{ $certificate->course->name }}</td>
                                    <td>{{ $certificate->issued_date->format('d.m.Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.certificates.download', $certificate) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;">Yuklab Olish</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Sertifikatlar yo'q</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Group Modal -->
<div id="groupModal" class="payment-modal">
    <div class="payment-modal-overlay" onclick="closeGroupModal()"></div>
    <div class="payment-modal-content">
        <form method="POST" action="" id="groupForm">
            @csrf
            <div class="payment-modal-header">
                <div>
                    <h2>Guruhga Qo'shish</h2>
                    <p class="payment-modal-subtitle">{{ $student->full_name }}ni guruhga qo'shish</p>
                </div>
                <button type="button" class="payment-modal-close" onclick="closeGroupModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="payment-modal-body">
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="redirect_to_student" value="1">
                
                <div class="payment-section">
                    <h3 class="payment-section-title">
                        <i class="fas fa-users"></i>
                        Guruh Tanlash
                    </h3>
                    
                    <div class="payment-form-group">
                        <label class="payment-form-label">Mavjud Guruhlar *</label>
                        <select name="group_id" id="groupSelect" class="payment-form-input" required>
                            <option value="">Guruhni tanlang...</option>
                            @foreach($availableGroups ?? [] as $group)
                            <option value="{{ $group->id }}" data-course="{{ $group->course->name ?? '' }}" data-teacher="{{ $group->teacher->full_name ?? '' }}" data-students="{{ $group->students_count ?? 0 }}" data-max="{{ $group->max_students }}">
                                {{ $group->name }} ({{ $group->course->name ?? 'N/A' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div id="groupInfo" class="student-info" style="display: none;">
                        <div class="student-info-card">
                            <div class="student-info-item">
                                <span class="info-label">Kurs:</span>
                                <span id="groupCourse">-</span>
                            </div>
                            <div class="student-info-item">
                                <span class="info-label">O'qituvchi:</span>
                                <span id="groupTeacher">-</span>
                            </div>
                            <div class="student-info-item">
                                <span class="info-label">O'quvchilar:</span>
                                <span id="groupStudents">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="payment-modal-footer">
                <button type="button" class="payment-btn-secondary" onclick="closeGroupModal()">
                    <i class="fas fa-times"></i> Bekor qilish
                </button>
                <button type="submit" class="payment-btn-primary">
                    <i class="fas fa-plus"></i> Guruhga Qo'shish
                </button>
            </div>
        </form>
    </div>
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
                    <p class="payment-modal-subtitle">{{ $student->full_name }} uchun to'lov qo'shish</p>
                </div>
                <button type="button" class="payment-modal-close" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="payment-modal-body">
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                
                <!-- Payment Details Section -->
                <div class="payment-section">
                    <h3 class="payment-section-title">
                        <i class="fas fa-money-bill"></i>
                        To'lov Tafsilotlari
                    </h3>
                    
                    <div class="payment-form-grid">
                        <div class="payment-form-group">
                            <label class="payment-form-label">Summa (so'm) *</label>
                            <input type="number" name="amount" id="paymentAmount" class="payment-form-input" required min="0" step="1000" placeholder="500000">
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
                        
                        <div class="payment-form-group">
                            <label class="payment-form-label">To'lov sanasi *</label>
                            <input type="date" name="payment_date" class="payment-form-input" value="{{ today()->format('Y-m-d') }}" required>
                        </div>
                        
                        <div class="payment-form-group">
                            <label class="payment-form-label">Chegirma (%)</label>
                            <input type="number" name="discount_percent" id="paymentDiscount" class="payment-form-input" min="0" max="100" step="1" placeholder="0">
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
            
            <input type="hidden" name="payment_type" value="monthly">
            <input type="hidden" name="status" value="completed">
            <input type="hidden" name="redirect_to_student" value="1">
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
    width: min(600px, 95vw);
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

.payment-section:last-child {
    border-bottom: none;
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

.payment-calculation {
    background: var(--gemini-bg);
    border: 1px solid var(--gemini-border);
    border-radius: 8px;
    padding: 16px;
    margin-top: 16px;
}

.calc-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--gemini-border);
}

.calc-row:last-child {
    border-bottom: none;
}

.calc-row.total {
    font-weight: 600;
    font-size: 16px;
    color: var(--gemini-text);
    border-top: 2px solid var(--gemini-border);
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

.payment-btn-primary:hover:not(:disabled) {
    background: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

.payment-btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
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
    
    .payment-modal-header {
        padding: 16px;
    }
    
    .payment-section {
        padding: 16px;
    }
    
    .payment-modal-footer {
        padding: 16px;
        flex-direction: column;
    }
    
    .payment-btn-secondary,
    .payment-btn-primary {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Tab switching
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active from all tabs and content
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(t => {
            t.style.color = 'var(--gemini-text-secondary)';
            t.style.borderBottomColor = 'transparent';
        });
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        
        // Add active to clicked tab
        this.style.color = 'var(--gemini-blue)';
        this.style.borderBottomColor = 'var(--gemini-blue)';
        
        // Show corresponding content
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.classList.add('show', 'active');
        }
    });
});

// Payment Modal Functions
function openPaymentModal(studentId) {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Focus on amount input
        setTimeout(() => {
            const amountInput = document.getElementById('paymentAmount');
            if (amountInput) amountInput.focus();
        }, 100);
        
        // Initialize calculation
        updateCalculation();
    }
}

function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        
        // Clear form after animation
        setTimeout(() => {
            const form = document.getElementById('paymentForm');
            if (form) {
                form.reset();
                form.querySelector('[name="payment_date"]').value = '{{ today()->format('Y-m-d') }}';
                updateCalculation();
            }
        }, 300);
    }
}

// Payment calculation
function updateCalculation() {
    const amountInput = document.getElementById('paymentAmount');
    const discountInput = document.getElementById('paymentDiscount');
    
    if (!amountInput || !discountInput) return;
    
    const amount = parseFloat(amountInput.value) || 0;
    const discount = parseFloat(discountInput.value) || 0;
    
    const discountAmount = (amount * discount) / 100;
    const finalAmount = amount - discountAmount;
    
    document.getElementById('baseAmount').textContent = amount.toLocaleString() + ' so\'m';
    document.getElementById('discountAmount').textContent = discountAmount.toLocaleString() + ' so\'m';
    document.getElementById('finalAmount').textContent = finalAmount.toLocaleString() + ' so\'m';
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('paymentAmount');
    const discountInput = document.getElementById('paymentDiscount');
    
    if (amountInput) {
        amountInput.addEventListener('input', updateCalculation);
    }
    
    if (discountInput) {
        discountInput.addEventListener('input', updateCalculation);
    }
    
    // Form validation and submission
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            const amount = parseFloat(document.getElementById('paymentAmount').value);
            
            if (!amount || amount <= 0) {
                e.preventDefault();
                alert('Iltimos, to\'lov summasini kiriting!');
                document.getElementById('paymentAmount').focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.payment-btn-primary');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saqlanmoqda...';
                submitBtn.disabled = true;
            }
        });
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentModal();
    }
});

// Click outside to close modal
document.addEventListener('click', function(e) {
    const modal = document.getElementById('paymentModal');
    if (e.target === modal) {
        closePaymentModal();
    }
});

// Success message handling
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        // Show success notification
        showSuccessNotification('{{ session('success') }}');
        
        // Switch to payments tab to show the new payment
        setTimeout(() => {
            const paymentsTab = document.querySelector('[href="#payments-tab"]');
            if (paymentsTab) {
                paymentsTab.click();
            }
        }, 500);
    });
@endif

// Group Modal Functions
function openGroupModal() {
    const modal = document.getElementById('groupModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            const groupSelect = document.getElementById('groupSelect');
            if (groupSelect) groupSelect.focus();
        }, 100);
    }
}

function closeGroupModal() {
    const modal = document.getElementById('groupModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        
        setTimeout(() => {
            const form = document.getElementById('groupForm');
            if (form) {
                form.reset();
                document.getElementById('groupInfo').style.display = 'none';
            }
        }, 300);
    }
}

// Group selection handler
document.addEventListener('DOMContentLoaded', function() {
    const groupSelect = document.getElementById('groupSelect');
    if (groupSelect) {
        groupSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const form = document.getElementById('groupForm');
            
            if (this.value) {
                // Update form action
                form.action = `{{ url('/admin/groups') }}/${this.value}/add-student`;
                
                // Show group info
                document.getElementById('groupCourse').textContent = selectedOption.dataset.course || '-';
                document.getElementById('groupTeacher').textContent = selectedOption.dataset.teacher || '-';
                document.getElementById('groupStudents').textContent = `${selectedOption.dataset.students || 0}/${selectedOption.dataset.max || 0}`;
                document.getElementById('groupInfo').style.display = 'block';
                
                // Check if group is full
                const currentStudents = parseInt(selectedOption.dataset.students || 0);
                const maxStudents = parseInt(selectedOption.dataset.max || 0);
                const submitBtn = form.querySelector('.payment-btn-primary');
                
                if (currentStudents >= maxStudents) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Guruh to\'liq';
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-plus"></i> Guruhga Qo\'shish';
                }
            } else {
                document.getElementById('groupInfo').style.display = 'none';
            }
        });
    }
    
    // Group form submission
    const groupForm = document.getElementById('groupForm');
    if (groupForm) {
        groupForm.addEventListener('submit', function(e) {
            const groupSelect = document.getElementById('groupSelect');
            
            if (!groupSelect.value) {
                e.preventDefault();
                alert('Iltimos, guruhni tanlang!');
                groupSelect.focus();
                return false;
            }
            
            // Set form action if not set
            if (!this.action || this.action === '') {
                this.action = `{{ url('/admin/groups') }}/${groupSelect.value}/add-student`;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.payment-btn-primary');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Qo\'shilmoqda...';
                submitBtn.disabled = true;
            }
        });
    }
});

// Delete payment function
function deletePayment(paymentId) {
    if (confirm('Ushbu to\'lovni o\'chirishni xohlaysizmi?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/admin/finance/payments') }}/${paymentId}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Success notification function
function showSuccessNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4caf50;
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        font-weight: 500;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-check-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endsection