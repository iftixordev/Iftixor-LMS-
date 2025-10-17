@extends('layouts.admin')

@section('content')
<!-- Include Advanced Filters -->
@include('components.advanced-filters')

<!-- Include Bulk Actions -->
@include('components.bulk-actions')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">O'quvchilar</h1>
            <p class="gemini-card-subtitle">Barcha o'quvchilarni boshqaring va kuzatib boring</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="gemini-btn" onclick="exportToExcel()" style="background: #4caf50; color: white;">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button class="gemini-btn btn-animate" onclick="openStudentSlidePanel()">
                <i class="fas fa-plus"></i> Yangi o'quvchi
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $students->total() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami o'quvchilar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $students->filter(function($student) { return $student->status == 'active'; })->count() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Faol o'quvchilar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #ff9800;">{{ $students->filter(function($student) { return $student->created_at && $student->created_at >= now()->startOfMonth(); })->count() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Bu oyda qo'shilgan</div>
        </div>
    </div>

    <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('admin.students.index') }}" style="display: flex; gap: 12px; align-items: end;">
            <div style="flex: 1;">
                <input type="text" name="search" class="gemini-input" placeholder="Ism, telefon yoki ID bo'yicha qidirish..." value="{{ request('search') }}">
            </div>
            <div>
                <select name="status" class="gemini-input" style="width: 150px;">
                    <option value="">Barcha holatlar</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nofaol</option>
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
                <th>
                    <label class="checkbox-container">
                        <input type="checkbox" id="masterCheckbox" class="bulk-checkbox master-checkbox">
                        <span class="checkmark"></span>
                    </label>
                </th>
                <th>O'quvchi</th>
                <th>Telefon</th>
                <th>Kurs/Guruh</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr data-id="{{ $student->id }}">
                <td>
                    <label class="checkbox-container">
                        <input type="checkbox" class="bulk-checkbox row-checkbox" value="{{ $student->id }}">
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $student->photo_url }}" width="40" height="40" style="border-radius: 50%;" alt="{{ $student->full_name }}">
                        <div>
                            <strong>{{ $student->full_name }}</strong>
                            <br><small style="color: var(--gemini-text-secondary);">{{ $student->student_id }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $student->phone ?? '-' }}</td>
                <td>
                    @if($student->groups && $student->groups->count() > 0)
                        @php $group = $student->groups->first(); @endphp
                        {{ $group->course->name ?? 'N/A' }} - {{ $group->name ?? 'N/A' }}
                    @else
                        <span style="color: var(--gemini-text-secondary);">Guruhsiz</span>
                    @endif
                </td>
                <td>
                    <span style="background: {{ $student->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $student->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ $student->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                        {{ $student->status == 'active' ? 'Faol' : 'Nofaol' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.students.show', $student) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" title="Ko'rish">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.students.progress', $student) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;" title="Progress">
                            <i class="fas fa-chart-line"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" title="Tahrirlash" onclick="editStudent({{ $student->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;" title="O'chirish">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">O'quvchilar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Student Slide Panel -->
<div id="studentSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeStudentSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="panelTitle">Yangi O'quvchi</h2>
                <p class="slide-panel-subtitle">O'quvchi ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeStudentSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="studentForm" method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="studentId" name="student_id">
                <input type="hidden" id="formMethod" name="_method">
                
                <!-- Personal Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Shaxsiy Ma'lumotlar
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ism *</label>
                            <input type="text" name="first_name" id="firstName" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Familiya *</label>
                            <input type="text" name="last_name" id="lastName" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tug'ilgan sana *</label>
                            <input type="date" name="birth_date" id="birthDate" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jinsi *</label>
                            <select name="gender" id="gender" class="form-input" required>
                                <option value="">Tanlang</option>
                                <option value="male">Erkak</option>
                                <option value="female">Ayol</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Telefon</label>
                            <input type="tel" name="phone" id="phone" class="form-input" placeholder="+998901234567">
                        </div>
                        

                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Manzil</label>
                        <textarea name="address" id="address" class="form-input" rows="2"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Rasm</label>
                        <div class="file-upload-area">
                            <input type="file" name="photo" id="photo" class="file-input" accept="image/*">
                            <div class="file-upload-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Rasm yuklash uchun bosing yoki sudrab tashlang</p>
                                <small>JPG, PNG formatida, maksimal 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Parent Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i>
                        Ota-ona Ma'lumotlari
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ota-ona ismi</label>
                            <input type="text" name="parent_name" id="parentName" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ota-ona telefoni</label>
                            <input type="tel" name="parent_phone" id="parentPhone" class="form-input" placeholder="+998901234567">
                        </div>
                        

                    </div>
                </div>
                
                <!-- Academic Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-graduation-cap"></i>
                        O'quv Ma'lumotlari
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ro'yxatga olingan sana *</label>
                            <input type="date" name="enrollment_date" id="enrollmentDate" class="form-input" value="{{ today()->format('Y-m-d') }}" required>
                        </div>
                        
                        <div class="form-group" id="statusGroup" style="display: none;">
                            <label class="form-label">Holat</label>
                            <select name="status" id="status" class="form-input">
                                <option value="active">Faol</option>
                                <option value="inactive">Nofaol</option>
                                <option value="graduated">Bitirgan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Izohlar</label>
                        <textarea name="notes" id="notes" class="form-input" rows="3" placeholder="Qo'shimcha ma'lumotlar..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeStudentSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="studentForm" class="btn-primary" id="submitBtn">
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
    width: min(800px, 95vw);
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
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
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
}

.form-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

.file-upload-area {
    position: relative;
    border: 2px dashed var(--gemini-border);
    border-radius: 8px;
    padding: 24px;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #2196f3;
    background: rgba(33, 150, 243, 0.05);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-content i {
    font-size: 32px;
    color: var(--gemini-text-secondary);
    margin-bottom: 12px;
}

.file-upload-content p {
    margin: 0 0 4px 0;
    color: var(--gemini-text);
    font-weight: 500;
}

.file-upload-content small {
    color: var(--gemini-text-secondary);
    font-size: 12px;
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
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let isEditMode = false;

function openStudentSlidePanel() {
    isEditMode = false;
    document.getElementById('panelTitle').textContent = 'Yangi O\'quvchi';
    document.getElementById('studentForm').action = '{{ route("admin.students.store") }}';
    document.getElementById('formMethod').value = '';
    document.getElementById('statusGroup').style.display = 'none';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('studentForm').reset();
    document.getElementById('enrollmentDate').value = '{{ today()->format("Y-m-d") }}';
    
    document.getElementById('studentSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editStudent(studentId) {
    isEditMode = true;
    document.getElementById('panelTitle').textContent = 'O\'quvchini Tahrirlash';
    document.getElementById('studentForm').action = `/admin/students/${studentId}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('studentId').value = studentId;
    document.getElementById('statusGroup').style.display = 'block';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load student data via AJAX
    fetch(`/admin/students/${studentId}`, {
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
            document.getElementById('firstName').value = data.first_name || '';
            document.getElementById('lastName').value = data.last_name || '';
            document.getElementById('birthDate').value = data.birth_date || '';
            document.getElementById('gender').value = data.gender || '';
            document.getElementById('phone').value = data.phone || '';
            document.getElementById('address').value = data.address || '';
            document.getElementById('parentName').value = data.parent_name || '';
            document.getElementById('parentPhone').value = data.parent_phone || '';
            document.getElementById('enrollmentDate').value = data.enrollment_date || '';
            document.getElementById('status').value = data.status || 'active';
            document.getElementById('notes').value = data.notes || '';
        })
        .catch(error => {
            console.error('Error loading student data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('studentSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeStudentSlidePanel() {
    document.getElementById('studentSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('studentForm').reset();
    }, 400);
}

function exportToExcel() {
    window.location.href = '{{ route("admin.students.index") }}?export=excel';
}

// File upload preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = document.querySelector('.file-upload-content');
            content.innerHTML = `
                <img src="${e.target.result}" style="max-width: 100px; max-height: 100px; border-radius: 8px; margin-bottom: 8px;">
                <p>${file.name}</p>
                <small>Rasm yuklandi</small>
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.getElementById('studentForm').addEventListener('submit', function(e) {
    const requiredFields = ['first_name', 'last_name', 'birth_date', 'gender', 'enrollment_date'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field.replace('_', ''));
        if (input && !input.value.trim()) {
            input.style.borderColor = '#f44336';
            isValid = false;
        } else if (input) {
            input.style.borderColor = 'var(--yt-spec-10-percent-layer)';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Iltimos, barcha majburiy maydonlarni to\'ldiring!');
    }
});

// Phone number formatting
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.startsWith('998')) {
        value = '+' + value;
    } else if (value.length > 0 && !value.startsWith('998')) {
        value = '+998' + value;
    }
    input.value = value;
}

document.getElementById('phone').addEventListener('input', function() {
    formatPhoneNumber(this);
});

document.getElementById('parentPhone').addEventListener('input', function() {
    formatPhoneNumber(this);
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeStudentSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('studentSlidePanel').classList.contains('active')) {
            document.getElementById('submitBtn').click();
        }
    }
});
</script>
@endsection