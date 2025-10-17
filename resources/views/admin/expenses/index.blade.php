@extends('layouts.admin')

@section('content')
<div class="gemini-stats stagger-animation">
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-chart-pie"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $totalExpenses ?? 0 }}">0</div>
            <div class="gemini-stat-label">Jami Xarajatlar</div>
            <div class="gemini-stat-change negative">{{ number_format($totalExpenses ?? 0) }} so'm</div>
        </div>
    </div>
    
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $monthlyExpenses ?? 0 }}">0</div>
            <div class="gemini-stat-label">Oylik Xarajatlar</div>
            <div class="gemini-stat-change negative">{{ number_format($monthlyExpenses ?? 0) }} so'm</div>
        </div>
    </div>
    
    <div class="gemini-stat-card animate-on-scroll hover-lift">
        <div class="gemini-stat-icon">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number counter" data-target="{{ $expenses->count() ?? 0 }}">0</div>
            <div class="gemini-stat-label">Jami Yozuvlar</div>
            <div class="gemini-stat-change neutral">{{ $expenses->count() ?? 0 }} ta</div>
        </div>
    </div>
</div>

<div class="gemini-card animate-on-scroll">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 class="gemini-card-title">Xarajatlar Boshqaruvi</h2>
            <p class="gemini-card-subtitle">Tashkilot xarajatlarini kuzatib boring</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="gemini-btn btn-animate" onclick="openExpenseModal()">
                <i class="fas fa-plus"></i> Yangi Xarajat
            </button>
            <button class="gemini-btn" style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary);">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>

    <div class="gemini-table-container">
        <table class="gemini-table">
            <thead>
                <tr>
                    <th>Xarajat</th>
                    <th>Kategoriya</th>
                    <th>Summa</th>
                    <th>Sana</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses ?? [] as $expense)
                <tr class="table-row-hover">
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #f44336, #e91e63); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-minus" style="color: white; font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 500;">{{ $expense->title ?? 'N/A' }}</div>
                                @if($expense->description ?? false)
                                <div style="font-size: 12px; color: var(--yt-text-secondary);">{{ $expense->description }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $categories = ['salary' => 'Maosh', 'rent' => 'Ijara', 'utilities' => 'Kommunal', 'supplies' => 'Jihozlar', 'marketing' => 'Marketing', 'other' => 'Boshqa'];
                        @endphp
                        <span style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary); padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $categories[$expense->category ?? 'other'] ?? 'Boshqa' }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: #f44336;">-{{ number_format($expense->amount ?? 0) }}</span>
                        <span style="color: var(--yt-text-secondary); font-size: 12px;">so'm</span>
                    </td>
                    <td>
                        <span style="color: var(--yt-text-secondary);">{{ $expense->expense_date ? $expense->expense_date->format('d.m.Y') : 'N/A' }}</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: var(--yt-spec-button-chip-background-hover);" onclick="editExpense({{ $expense->id ?? 0 }})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;" onclick="return confirm('O\'chirmoqchimisiz?') && deleteExpense({{ $expense->id ?? 0 }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: var(--yt-text-secondary);">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                            <div style="width: 64px; height: 64px; background: var(--yt-spec-button-chip-background-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-receipt" style="font-size: 24px; color: var(--yt-text-secondary);"></i>
                            </div>
                            <div>
                                <div style="font-weight: 500; margin-bottom: 4px;">Xarajatlar topilmadi</div>
                                <div style="font-size: 14px;">Yangi xarajat qo'shish uchun yuqoridagi tugmani bosing</div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Expense Modal -->
<div id="expenseModal" class="expense-modal">
    <div class="expense-modal-overlay" onclick="closeExpenseModal()"></div>
    <div class="expense-modal-content">
        <form method="POST" action="{{ route('admin.expenses.store') }}" id="expenseForm">
            @csrf
            <input type="hidden" id="expenseId" name="expense_id">
            <input type="hidden" id="expenseMethod" name="_method">
            
            <div class="expense-modal-header">
                <div>
                    <h2 id="expenseModalTitle">Yangi Xarajat</h2>
                    <p class="expense-modal-subtitle">Xarajat ma'lumotlarini kiriting</p>
                </div>
                <button type="button" class="expense-modal-close" onclick="closeExpenseModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="expense-modal-body">
                <div class="expense-section">
                    <h3 class="expense-section-title">
                        <i class="fas fa-receipt"></i>
                        Xarajat Ma'lumotlari
                    </h3>
                    
                    <div class="expense-form-group">
                        <label class="expense-form-label">Xarajat nomi *</label>
                        <input type="text" name="title" id="expenseTitle" class="expense-form-input" required placeholder="Masalan: Ofis ijarasi">
                    </div>
                    
                    <div class="expense-form-grid">
                        <div class="expense-form-group">
                            <label class="expense-form-label">Kategoriya *</label>
                            <select name="category" id="expenseCategory" class="expense-form-input" required>
                                <option value="salary">Maosh</option>
                                <option value="rent">Ijara</option>
                                <option value="utilities">Kommunal</option>
                                <option value="supplies">Jihozlar</option>
                                <option value="marketing">Marketing</option>
                                <option value="other">Boshqa</option>
                            </select>
                        </div>
                        
                        <div class="expense-form-group">
                            <label class="expense-form-label">Summa (so'm) *</label>
                            <input type="number" name="amount" id="expenseAmount" class="expense-form-input" required min="0" step="1000" placeholder="100000">
                        </div>
                    </div>
                    
                    <div class="expense-form-group">
                        <label class="expense-form-label">Sana *</label>
                        <input type="date" name="expense_date" id="expenseDate" class="expense-form-input" value="{{ today()->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="expense-form-group">
                        <label class="expense-form-label">Tavsif</label>
                        <textarea name="description" id="expenseDescription" class="expense-form-input" rows="3" placeholder="Qo'shimcha ma'lumot..."></textarea>
                    </div>
                </div>
            </div>
            
            <div class="expense-modal-footer">
                <button type="button" class="expense-btn-secondary" onclick="closeExpenseModal()">
                    <i class="fas fa-times"></i> Bekor qilish
                </button>
                <button type="submit" class="expense-btn-primary" id="expenseSubmitBtn">
                    <i class="fas fa-save"></i> Saqlash
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.expense-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.expense-modal.active {
    opacity: 1;
    visibility: visible;
}

.expense-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    backdrop-filter: none;
}

.expense-modal-content {
    width: min(600px, 95vw);
    max-height: 90vh;
    background: var(--gemini-surface);
    display: flex;
    flex-direction: column;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    transform: scale(0.8);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid var(--gemini-border);
}

.expense-modal.active .expense-modal-content {
    transform: scale(1);
}

.expense-modal-header {
    padding: 24px;
    border-bottom: 1px solid var(--gemini-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--gemini-surface);
    border-radius: 16px 16px 0 0;
}

.expense-modal-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: var(--gemini-text);
}

.expense-modal-subtitle {
    margin: 4px 0 0 0;
    color: var(--gemini-text-secondary);
    font-size: 14px;
}

.expense-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--gemini-text-secondary);
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.expense-modal-close:hover {
    background: var(--gemini-hover);
    color: var(--gemini-text);
}

.expense-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    max-height: calc(90vh - 140px);
}

.expense-section {
    padding: 24px;
}

.expense-section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 20px 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--gemini-text);
}

.expense-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.expense-form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.expense-form-label {
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--gemini-text);
    font-size: 14px;
}

.expense-form-input {
    padding: 12px 16px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
    font-size: 14px;
    transition: all 0.2s ease;
    resize: vertical;
}

.expense-form-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

.expense-modal-footer {
    padding: 24px;
    border-top: 1px solid var(--gemini-border);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: var(--gemini-bg);
    border-radius: 0 0 16px 16px;
}

.expense-btn-secondary {
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

.expense-btn-secondary:hover {
    background: var(--gemini-hover);
}

.expense-btn-primary {
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

.expense-btn-primary:hover {
    background: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

@media (max-width: 768px) {
    .expense-modal-content {
        width: 100vw;
        height: 100vh;
        border-radius: 0;
        max-height: 100vh;
    }
    
    .expense-form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let isExpenseEditMode = false;

function openExpenseModal() {
    isExpenseEditMode = false;
    document.getElementById('expenseModalTitle').textContent = 'Yangi Xarajat';
    document.getElementById('expenseForm').action = '{{ route("admin.expenses.store") }}';
    document.getElementById('expenseMethod').value = '';
    document.getElementById('expenseSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('expenseForm').reset();
    document.getElementById('expenseDate').value = '{{ today()->format("Y-m-d") }}';
    
    document.getElementById('expenseModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeExpenseModal() {
    document.getElementById('expenseModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('expenseForm').reset();
    }, 400);
}

function editExpense(id) {
    isExpenseEditMode = true;
    document.getElementById('expenseModalTitle').textContent = 'Xarajatni Tahrirlash';
    document.getElementById('expenseForm').action = `/admin/expenses/${id}`;
    document.getElementById('expenseMethod').value = 'PUT';
    document.getElementById('expenseId').value = id;
    document.getElementById('expenseSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load expense data via AJAX
    fetch(`/admin/expenses/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('expenseTitle').value = data.title || '';
            document.getElementById('expenseCategory').value = data.category || 'other';
            document.getElementById('expenseAmount').value = data.amount || '';
            document.getElementById('expenseDate').value = data.expense_date || '';
            document.getElementById('expenseDescription').value = data.description || '';
        })
        .catch(error => {
            console.error('Error loading expense data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('expenseModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function deleteExpense(id) {
    fetch(`/admin/expenses/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => location.reload());
}

// Form validation
document.getElementById('expenseForm').addEventListener('submit', function(e) {
    const requiredFields = ['title', 'category', 'amount', 'expense_date'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('expense' + field.charAt(0).toUpperCase() + field.slice(1).replace('_', ''));
        if (input && !input.value.trim()) {
            input.style.borderColor = '#f44336';
            isValid = false;
        } else if (input) {
            input.style.borderColor = 'var(--gemini-border)';
        }
    });
    
    const amount = parseFloat(document.getElementById('expenseAmount').value);
    if (amount <= 0) {
        document.getElementById('expenseAmount').style.borderColor = '#f44336';
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Iltimos, barcha majburiy maydonlarni to\'ldiring!');
    }
});

// Number formatting
document.getElementById('expenseAmount').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value) {
        this.value = parseInt(value);
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeExpenseModal();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('expenseModal').classList.contains('active')) {
            document.getElementById('expenseSubmitBtn').click();
        }
    }
});
</script>
@endsection