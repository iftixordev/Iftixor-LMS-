@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Filiallar</h1>
            <p class="gemini-card-subtitle">Tashkilot filiallarini boshqaring</p>
        </div>
        <button class="gemini-btn btn-animate" onclick="openBranchSlidePanel()">
            <i class="fas fa-plus"></i> Yangi filial
        </button>
    </div>

    @php
        $currentBranchId = session('current_branch_id');
        $currentBranch = $currentBranchId ? $branches->firstWhere('id', $currentBranchId) : null;
    @endphp
    
    @if($currentBranch)
    <div style="background: linear-gradient(135deg, var(--gemini-blue), #42a5f5); border-radius: 12px; padding: 20px; margin-bottom: 24px; color: white;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-building" style="font-size: 24px;"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 20px;">Hozirgi filial: {{ $currentBranch->name }}</h3>
                <p style="margin: 0; opacity: 0.9; font-size: 14px;">{{ $currentBranch->address }}</p>
            </div>
        </div>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $branches->total() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami filiallar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $branches->where('is_active', true)->count() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Faol filiallar</div>
        </div>
    </div>

    <table class="gemini-table">
        <thead>
            <tr>
                <th>Filial</th>
                <th>Manzil</th>
                <th>Telefon</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($branches ?? [] as $branch)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--gemini-blue), #42a5f5); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-building" style="color: white; font-size: 16px;"></i>
                        </div>
                        <div>
                            <strong>{{ $branch->name ?? 'N/A' }}</strong>
                            @if($branch->is_main ?? false)
                            <span style="background: rgba(33, 150, 243, 0.1); color: var(--gemini-blue); padding: 2px 6px; border-radius: 4px; font-size: 10px; margin-left: 8px;">ASOSIY</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>{{ $branch->address ?? '-' }}</td>
                <td>{{ $branch->phone ?? '-' }}</td>
                <td>
                    <span style="background: {{ ($branch->is_active ?? true) ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ ($branch->is_active ?? true) ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ ($branch->is_active ?? true) ? '#4caf50' : '#9e9e9e' }};">
                        {{ ($branch->is_active ?? true) ? 'Faol' : 'Nofaol' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.branches.show', $branch) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" onclick="editBranch({{ $branch->id ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        @if(!($branch->is_main ?? false))
                        <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Filiallar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Branch Slide Panel -->
<div id="branchSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeBranchSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="branchPanelTitle">Yangi Filial</h2>
                <p class="slide-panel-subtitle">Filial ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeBranchSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="branchForm" method="POST" action="{{ route('admin.branches.store') }}">
                @csrf
                <input type="hidden" id="branchId" name="branch_id">
                <input type="hidden" id="branchFormMethod" name="_method">
                
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-building"></i>
                        Filial Ma'lumotlari
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Filial nomi *</label>
                        <input type="text" name="name" id="branchName" class="form-input" required placeholder="Masalan: Markaziy filial">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Manzil *</label>
                        <textarea name="address" id="branchAddress" class="form-input" rows="2" required placeholder="To'liq manzil..."></textarea>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Telefon *</label>
                            <input type="tel" name="phone" id="branchPhone" class="form-input" required placeholder="+998901234567">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="branchEmail" class="form-input" placeholder="filial@example.com">
                        </div>
                    </div>
                    
                    <div class="form-group" id="branchStatusGroup" style="display: none;">
                        <label class="form-label">Holat</label>
                        <select name="is_active" id="branchStatus" class="form-input">
                            <option value="1">Faol</option>
                            <option value="0">Nofaol</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tavsif</label>
                        <textarea name="description" id="branchDescription" class="form-input" rows="3" placeholder="Filial haqida qo'shimcha ma'lumot..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeBranchSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="branchForm" class="btn-primary" id="branchSubmitBtn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </div>
</div>

<style>
.slide-panel {
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

.slide-panel.active {
    opacity: 1;
    visibility: visible;
}

.slide-panel-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    backdrop-filter: none;
}

.slide-panel-content {
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

.slide-panel.active .slide-panel-content {
    transform: scale(1);
}

.slide-panel-header {
    padding: 24px;
    border-bottom: 1px solid var(--gemini-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--gemini-surface);
    border-radius: 16px 16px 0 0;
}

.slide-panel-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: var(--gemini-text);
}

.slide-panel-subtitle {
    margin: 4px 0 0 0;
    color: var(--gemini-text-secondary);
    font-size: 14px;
}

.slide-panel-close {
    background: none;
    border: none;
    font-size: 24px;
    color: var(--gemini-text-secondary);
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.slide-panel-close:hover {
    background: var(--gemini-hover);
    color: var(--gemini-text);
}

.slide-panel-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    max-height: calc(90vh - 140px);
}

.form-section {
    padding: 24px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 20px 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--gemini-text);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.form-label {
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--gemini-text);
    font-size: 14px;
}

.form-input {
    padding: 12px 16px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
    font-size: 14px;
    transition: all 0.2s ease;
    resize: vertical;
}

.form-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

.slide-panel-footer {
    padding: 24px;
    border-top: 1px solid var(--gemini-border);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: var(--gemini-bg);
    border-radius: 0 0 16px 16px;
}

.btn-secondary {
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

.btn-secondary:hover {
    background: var(--gemini-hover);
}

.btn-primary {
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

.btn-primary:hover {
    background: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

@media (max-width: 768px) {
    .slide-panel-content {
        width: 100vw;
        height: 100vh;
        border-radius: 0;
        max-height: 100vh;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let isBranchEditMode = false;

function openBranchSlidePanel() {
    isBranchEditMode = false;
    document.getElementById('branchPanelTitle').textContent = 'Yangi Filial';
    document.getElementById('branchForm').action = '{{ route("admin.branches.store") }}';
    document.getElementById('branchFormMethod').value = '';
    document.getElementById('branchStatusGroup').style.display = 'none';
    document.getElementById('branchSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('branchForm').reset();
    
    document.getElementById('branchSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editBranch(branchId) {
    isBranchEditMode = true;
    document.getElementById('branchPanelTitle').textContent = 'Filialni Tahrirlash';
    document.getElementById('branchForm').action = `/admin/branches/${branchId}`;
    document.getElementById('branchFormMethod').value = 'PUT';
    document.getElementById('branchId').value = branchId;
    document.getElementById('branchStatusGroup').style.display = 'block';
    document.getElementById('branchSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load branch data via AJAX
    fetch(`/admin/branches/${branchId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('branchName').value = data.name || '';
            document.getElementById('branchAddress').value = data.address || '';
            document.getElementById('branchPhone').value = data.phone || '';
            document.getElementById('branchEmail').value = data.email || '';
            document.getElementById('branchStatus').value = data.is_active ? '1' : '0';
            document.getElementById('branchDescription').value = data.description || '';
        })
        .catch(error => {
            console.error('Error loading branch data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('branchSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeBranchSlidePanel() {
    document.getElementById('branchSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('branchForm').reset();
    }, 400);
}

// Form validation
document.getElementById('branchForm').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'address', 'phone'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('branch' + field.charAt(0).toUpperCase() + field.slice(1));
        if (input && !input.value.trim()) {
            input.style.borderColor = '#f44336';
            isValid = false;
        } else if (input) {
            input.style.borderColor = 'var(--gemini-border)';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Iltimos, barcha majburiy maydonlarni to\'ldiring!');
    }
});

// Phone number formatting
document.getElementById('branchPhone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value.startsWith('998')) {
        value = '+' + value;
    } else if (value.length > 0 && !value.startsWith('998')) {
        value = '+998' + value;
    }
    this.value = value;
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBranchSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('branchSlidePanel').classList.contains('active')) {
            document.getElementById('branchSubmitBtn').click();
        }
    }
});
</script>
@endsection