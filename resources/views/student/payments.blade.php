@extends('layouts.student')

@section('styles')
<link href="{{ asset('css/payment-modal.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">To'lovlar</h1>
    <p class="gemini-card-subtitle">To'lovlar tarixi va moliyaviy ma'lumotlar</p>
</div>

<!-- Payment Summary -->
<div class="gemini-stats">
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #4caf50, #45a049);">
            <i class="fas fa-credit-card"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">2,400,000</div>
            <div class="gemini-stat-label">Jami to'langan (so'm)</div>
            <div class="gemini-stat-change positive">Bu yil</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #ff9800, #f57c00);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">800,000</div>
            <div class="gemini-stat-label">Qarz (so'm)</div>
            <div class="gemini-stat-change negative">To'lash kerak</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-calendar"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">25.12</div>
            <div class="gemini-stat-label">Keyingi to'lov</div>
            <div class="gemini-stat-change neutral">2024</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon">
            <i class="fas fa-percentage"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">75%</div>
            <div class="gemini-stat-label">To'langan foiz</div>
            <div class="gemini-stat-change positive">Yaxshi</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Payment History -->
    <div>
        <div class="gemini-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="gemini-card-title" style="margin: 0;">To'lovlar Tarixi</h2>
                <div style="display: flex; gap: 8px;">
                    <button onclick="showPaymentModal()" class="gemini-btn" style="background: #4caf50;">
                        <i class="fas fa-plus"></i> To'lov qilish
                    </button>
                    <button class="gemini-btn" style="background: #2196f3;">
                        <i class="fas fa-download"></i> Eksport
                    </button>
                </div>
            </div>
            
            @if($payments && $payments->count() > 0)
                <table class="gemini-table">
                    <thead>
                        <tr>
                            <th>Sana</th>
                            <th>Summa</th>
                            <th>Usul</th>
                            <th>Holat</th>
                            <th>Kvitansiya</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d.m.Y H:i') }}</td>
                            <td class="text-success">{{ number_format($payment->amount) }} so'm</td>
                            <td>
                                <span class="badge bg-primary">{{ ucfirst($payment->payment_method) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ ucfirst($payment->status) }}</span>
                            </td>
                            <td>{{ $payment->receipt_number }}</td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" onclick="showReceipt('{{ $payment->id }}')">
                                    <i class="fas fa-receipt"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                    <h5>To'lovlar topilmadi</h5>
                    <p class="text-muted">Yangi to'lov qo'shish uchun yuqoridagi tugmani bosing</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Info -->
    <div class="col-md-4">
        <!-- Next Payment -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Keyingi To'lov</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h4 class="text-warning">800,000 so'm</h4>
                    <p class="text-muted">JavaScript Asoslari</p>
                    <p class="mb-3">
                        <i class="fas fa-calendar me-2"></i>
                        25.12.2024 gacha
                    </p>
                    <div class="d-grid">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-credit-card me-2"></i>Hozir To'lash
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">To'lov Usullari</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-credit-card me-2"></i>Bank Kartasi
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="fas fa-money-bill me-2"></i>Naqd Pul
                    </button>
                    <button class="btn btn-outline-info">
                        <i class="fas fa-university me-2"></i>Bank O'tkazmasi
                    </button>
                    <button class="btn btn-outline-warning">
                        <i class="fas fa-mobile-alt me-2"></i>Click/Payme
                    </button>
                </div>
            </div>
        </div>

        <!-- Discount Info -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Chegirmalar</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <h6>Faol Chegirma</h6>
                    <p class="mb-1">Erta to'lov - 10%</p>
                    <small>Muddatdan oldin to'lasangiz</small>
                </div>
                <div class="alert alert-info">
                    <h6>Bonus Ball</h6>
                    <p class="mb-1">1,250 ball</p>
                    <small>Keyingi to'lovda ishlatishingiz mumkin</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">To'lov Qilish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h4>JavaScript Asoslari</h4>
                    <h3 class="text-primary">800,000 so'm</h3>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label class="form-label">To'lov usuli</label>
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                        <p class="mb-0">Bank Kartasi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                                        <p class="mb-0">Click/Payme</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Karta raqami</label>
                        <input type="text" class="form-control" placeholder="**** **** **** ****">
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Amal qilish muddati</label>
                                <input type="text" class="form-control" placeholder="MM/YY">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" placeholder="***">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary" onclick="processPayment()">To'lash</button>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">To'lov Kvitansiyasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h4>O'QUV MARKAZI</h4>
                    <p class="text-muted">To'lov Kvitansiyasi</p>
                </div>
                
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Kvitansiya №:</strong></td>
                        <td>PAY-2024-001234</td>
                    </tr>
                    <tr>
                        <td><strong>Sana:</strong></td>
                        <td>20.12.2024 14:30</td>
                    </tr>
                    <tr>
                        <td><strong>O'quvchi:</strong></td>
                        <td>Ali O'quvchi</td>
                    </tr>
                    <tr>
                        <td><strong>Kurs:</strong></td>
                        <td>JavaScript Asoslari</td>
                    </tr>
                    <tr>
                        <td><strong>Summa:</strong></td>
                        <td><strong>800,000 so'm</strong></td>
                    </tr>
                    <tr>
                        <td><strong>To'lov usuli:</strong></td>
                        <td>Bank kartasi</td>
                    </tr>
                    <tr>
                        <td><strong>Holat:</strong></td>
                        <td><span class="badge bg-success">To'langan</span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary">
                    <i class="fas fa-download"></i> Yuklab olish
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-print"></i> Chop etish
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showPaymentModal() {
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function processPayment() {
    const amount = 800000; // Fixed amount for demo
    const paymentMethod = 'card'; // Fixed method for demo
    
    fetch('{{ route("student.payments.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            amount: amount,
            payment_method: paymentMethod
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification
            if (window.notifications) {
                window.notifications.show('To\'lov muvaffaqiyatli amalga oshirildi!', 'success');
            } else {
                alert('To\'lov muvaffaqiyatli amalga oshirildi!');
            }
            bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
            setTimeout(() => location.reload(), 1000);
        } else {
            alert('Xatolik: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('To\'lov amalga oshmadi');
    });
}
</script>
@endsection