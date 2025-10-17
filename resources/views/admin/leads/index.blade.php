@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Potensial Mijozlar</h1>
            <p class="gemini-card-subtitle">Yangi mijozlar va qiziquvchilarni boshqaring</p>
        </div>
        <button class="gemini-btn btn-animate" onclick="openLeadSlidePanel()">
            <i class="fas fa-plus"></i> Yangi mijoz
        </button>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $leads->total() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami mijozlar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $leads->where('status', 'interested')->count() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Qiziquvchilar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #ff9800;">{{ $leads->where('status', 'contacted')->count() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Aloqada</div>
        </div>
    </div>

    <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('admin.leads.index') }}" style="display: flex; gap: 12px; align-items: end;">
            <div style="flex: 1;">
                <input type="text" name="search" class="gemini-input" placeholder="Ism yoki telefon bo'yicha qidirish..." value="{{ request('search') }}">
            </div>
            <div>
                <select name="status" class="gemini-input" style="width: 150px;">
                    <option value="">Barcha holatlar</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Yangi</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Aloqada</option>
                    <option value="interested" {{ request('status') == 'interested' ? 'selected' : '' }}>Qiziquvchi</option>
                    <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>O'quvchi bo'ldi</option>
                    <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Yo'qolgan</option>
                </select>
            </div>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-search"></i> Qidirish
            </button>
        </form>
    </div>

    <table class="gemini-table">
        <thead>
            <tr>
                <th>Mijoz</th>
                <th>Telefon</th>
                <th>Kurs</th>
                <th>Holat</th>
                <th>Sana</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads ?? [] as $lead)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #2196f3, #21cbf3); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user" style="color: white; font-size: 16px;"></i>
                        </div>
                        <div>
                            <strong>{{ $lead->full_name ?? 'N/A' }}</strong>
                            @if($lead->email ?? false)
                            <br><small style="color: var(--gemini-text-secondary);">{{ $lead->email }}</small>
                            @endif
                        </div>
                    </div>
                </td>
                <td>{{ $lead->phone ?? '-' }}</td>
                <td>{{ $lead->course->name ?? 'Tanlanmagan' }}</td>
                <td>
                    @php
                        $statusColors = [
                            'new' => ['bg' => 'rgba(33, 150, 243, 0.1)', 'color' => '#2196f3', 'text' => 'Yangi'],
                            'contacted' => ['bg' => 'rgba(255, 152, 0, 0.1)', 'color' => '#ff9800', 'text' => 'Aloqada'],
                            'interested' => ['bg' => 'rgba(76, 175, 80, 0.1)', 'color' => '#4caf50', 'text' => 'Qiziquvchi'],
                            'converted' => ['bg' => 'rgba(76, 175, 80, 0.1)', 'color' => '#4caf50', 'text' => 'O\'quvchi'],
                            'lost' => ['bg' => 'rgba(158, 158, 158, 0.1)', 'color' => '#9e9e9e', 'text' => 'Yo\'qolgan']
                        ];
                        $status = $statusColors[$lead->status ?? 'new'] ?? $statusColors['new'];
                    @endphp
                    <span style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ $status['color'] }};">
                        {{ $status['text'] }}
                    </span>
                </td>
                <td>{{ $lead->created_at ? $lead->created_at->format('d.m.Y') : 'N/A' }}</td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" onclick="editLead({{ $lead->id ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Potensial mijozlar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Lead Slide Panel -->
<div id="leadSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeLeadSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="leadPanelTitle">Yangi Mijoz</h2>
                <p class="slide-panel-subtitle">Potensial mijoz ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeLeadSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="leadForm" method="POST" action="{{ route('admin.leads.store') }}">
                @csrf
                <input type="hidden" id="leadId" name="lead_id">
                <input type="hidden" id="leadFormMethod" name="_method">
                
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Shaxsiy Ma'lumotlar
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ism *</label>
                            <input type="text" name="first_name" id="leadFirstName" class="form-input" required placeholder="Ism">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Familiya *</label>
                            <input type="text" name="last_name" id="leadLastName" class="form-input" required placeholder="Familiya">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Telefon *</label>
                        <input type="tel" name="phone" id="leadPhone" class="form-input" required placeholder="+998901234567">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Manzil</label>
                        <textarea name="address" id="leadAddress" class="form-input" rows="2" placeholder="To'liq manzil..."></textarea>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-graduation-cap"></i>
                        Qiziqish Ma'lumotlari
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Qiziquvchi kurs</label>
                            <select name="course_id" id="leadCourse" class="form-input">
                                <option value="">Kursni tanlang</option>
                                @foreach($courses ?? [] as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Qayerdan bildi</label>
                            <select name="source" id="leadSource" class="form-input">
                                <option value="manual">Qo'lda kiritilgan</option>
                                <option value="website">Veb-sayt</option>
                                <option value="facebook">Facebook</option>
                                <option value="instagram">Instagram</option>
                                <option value="telegram">Telegram</option>
                                <option value="youtube">YouTube</option>
                                <option value="referral">Tavsiya</option>
                                <option value="advertisement">Reklama</option>
                                <option value="other">Boshqa</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group" id="leadStatusGroup" style="display: none;">
                        <label class="form-label">Holat</label>
                        <select name="status" id="leadStatus" class="form-input">
                            <option value="new">Yangi</option>
                            <option value="contacted">Aloqada</option>
                            <option value="interested">Qiziquvchi</option>
                            <option value="converted">O'quvchi bo'ldi</option>
                            <option value="lost">Yo'qolgan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Qo'shimcha ma'lumot</label>
                        <textarea name="notes" id="leadNotes" class="form-input" rows="3" placeholder="Mijoz haqida qo'shimcha ma'lumotlar..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeLeadSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="leadForm" class="btn-primary" id="leadSubmitBtn">
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
    width: min(700px, 95vw);
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
    border-bottom: 1px solid var(--gemini-border);
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
let isLeadEditMode = false;

function openLeadSlidePanel() {
    isLeadEditMode = false;
    document.getElementById('leadPanelTitle').textContent = 'Yangi Mijoz';
    document.getElementById('leadForm').action = '{{ route("admin.leads.store") }}';
    document.getElementById('leadFormMethod').value = '';
    document.getElementById('leadStatusGroup').style.display = 'none';
    document.getElementById('leadSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('leadForm').reset();
    
    document.getElementById('leadSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editLead(leadId) {
    isLeadEditMode = true;
    document.getElementById('leadPanelTitle').textContent = 'Mijozni Tahrirlash';
    document.getElementById('leadForm').action = `/admin/leads/${leadId}`;
    document.getElementById('leadFormMethod').value = 'PUT';
    document.getElementById('leadId').value = leadId;
    document.getElementById('leadStatusGroup').style.display = 'block';
    document.getElementById('leadSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load lead data via AJAX
    fetch(`/admin/leads/${leadId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('leadFirstName').value = data.first_name || '';
            document.getElementById('leadLastName').value = data.last_name || '';
            document.getElementById('leadPhone').value = data.phone || '';
            document.getElementById('leadAddress').value = data.address || '';
            document.getElementById('leadCourse').value = data.course_id || '';
            document.getElementById('leadSource').value = data.source || 'manual';
            document.getElementById('leadStatus').value = data.status || 'new';
            document.getElementById('leadNotes').value = data.notes || '';
        })
        .catch(error => {
            console.error('Error loading lead data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('leadSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLeadSlidePanel() {
    document.getElementById('leadSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    setTimeout(() => {
        document.getElementById('leadForm').reset();
    }, 400);
}

// Form validation
document.getElementById('leadForm').addEventListener('submit', function(e) {
    const requiredFields = ['first_name', 'last_name', 'phone'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('lead' + field.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(''));
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
document.getElementById('leadPhone').addEventListener('input', function() {
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
        closeLeadSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('leadSlidePanel').classList.contains('active')) {
            document.getElementById('leadSubmitBtn').click();
        }
    }
});
</script>
@endsection