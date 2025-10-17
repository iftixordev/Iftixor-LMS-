@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">O'qituvchilar</h1>
            <p class="gemini-card-subtitle">O'qituvchilarni boshqaring va ularning faoliyatini kuzatib boring</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.teachers.salary-report') }}" class="gemini-btn" style="background: #ff9800; color: white;">
                <i class="fas fa-chart-bar"></i> Maosh hisoboti
            </a>
            <button class="gemini-btn btn-animate" onclick="openTeacherSlidePanel()">
                <i class="fas fa-plus"></i> Yangi o'qituvchi
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $teachers->total() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami o'qituvchilar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $teachers->where('status', 'active')->count() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Faol o'qituvchilar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #ff9800;">{{ $teachers->sum('groups_count') ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami guruhlar</div>
        </div>
    </div>

    <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('admin.teachers.index') }}" style="display: flex; gap: 12px; align-items: end;">
            <div style="flex: 1;">
                <input type="text" name="search" class="gemini-input" placeholder="Ism, email yoki telefon bo'yicha qidirish..." value="{{ request('search') }}">
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
                <th>O'qituvchi</th>
                <th>Telefon</th>
                <th>Mutaxassislik</th>
                <th>Maosh</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $teacher->photo_url }}" width="40" height="40" style="border-radius: 50%;" alt="{{ $teacher->full_name }}">
                        <div>
                            <strong>{{ $teacher->full_name }}</strong>
                            <br><small style="color: var(--gemini-text-secondary);">{{ $teacher->email }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $teacher->phone }}</td>
                <td>{{ $teacher->specializations }}</td>
                <td>{{ number_format($teacher->hourly_rate) }} so'm</td>
                <td>
                    <span style="background: {{ $teacher->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $teacher->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ $teacher->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                        {{ $teacher->status == 'active' ? 'Faol' : 'Nofaol' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" onclick="editTeacher({{ $teacher->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
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
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">O'qituvchilar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Teacher Slide Panel -->
<div id="teacherSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeTeacherSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="teacherPanelTitle">Yangi O'qituvchi</h2>
                <p class="slide-panel-subtitle">O'qituvchi ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeTeacherSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="teacherForm" method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="teacherId" name="teacher_id">
                <input type="hidden" id="teacherFormMethod" name="_method">
                
                <!-- Personal Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Shaxsiy Ma'lumotlar
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ism *</label>
                            <input type="text" name="first_name" id="teacherFirstName" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Familiya *</label>
                            <input type="text" name="last_name" id="teacherLastName" class="form-input" required>
                        </div>
                        

                        
                        <div class="form-group">
                            <label class="form-label">Telefon *</label>
                            <input type="tel" name="phone" id="teacherPhone" class="form-input" required placeholder="+998901234567">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Manzil</label>
                        <textarea name="address" id="teacherAddress" class="form-input" rows="2"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Rasm</label>
                        <div class="file-upload-area">
                            <input type="file" name="photo" id="teacherPhoto" class="file-input" accept="image/*">
                            <div class="file-upload-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Rasm yuklash uchun bosing yoki sudrab tashlang</p>
                                <small>JPG, PNG formatida, maksimal 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Professional Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-graduation-cap"></i>
                        Kasbiy Ma'lumotlar
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mutaxassislik *</label>
                            <input type="text" name="specializations" id="teacherSpecializations" class="form-input" required placeholder="Matematika, Fizika">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ta'lim</label>
                            <input type="text" name="education" id="teacherEducation" class="form-input" placeholder="Oliy ma'lumot">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Soatlik tarif *</label>
                            <input type="number" name="hourly_rate" id="teacherHourlyRate" class="form-input" required min="0" step="1000" placeholder="50000">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Ishga qabul qilingan sana *</label>
                            <input type="date" name="hire_date" id="teacherHireDate" class="form-input" value="{{ today()->format('Y-m-d') }}" required>
                        </div>
                        
                        <div class="form-group" id="teacherStatusGroup" style="display: none;">
                            <label class="form-label">Holat</label>
                            <select name="status" id="teacherStatus" class="form-input">
                                <option value="active">Faol</option>
                                <option value="inactive">Nofaol</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeTeacherSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="teacherForm" class="btn-primary" id="teacherSubmitBtn">
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
let isTeacherEditMode = false;

function openTeacherSlidePanel() {
    isTeacherEditMode = false;
    document.getElementById('teacherPanelTitle').textContent = 'Yangi O\'qituvchi';
    document.getElementById('teacherForm').action = '{{ route("admin.teachers.store") }}';
    document.getElementById('teacherFormMethod').value = '';
    document.getElementById('teacherStatusGroup').style.display = 'none';
    document.getElementById('teacherSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('teacherForm').reset();
    document.getElementById('teacherHireDate').value = '{{ today()->format("Y-m-d") }}';
    
    document.getElementById('teacherSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editTeacher(teacherId) {
    isTeacherEditMode = true;
    document.getElementById('teacherPanelTitle').textContent = 'O\'qituvchini Tahrirlash';
    document.getElementById('teacherForm').action = `/admin/teachers/${teacherId}`;
    document.getElementById('teacherFormMethod').value = 'PUT';
    document.getElementById('teacherId').value = teacherId;
    document.getElementById('teacherStatusGroup').style.display = 'block';
    document.getElementById('teacherSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load teacher data via AJAX
    fetch(`/admin/teachers/${teacherId}`, {
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
            document.getElementById('teacherFirstName').value = data.first_name || '';
            document.getElementById('teacherLastName').value = data.last_name || '';
            document.getElementById('teacherPhone').value = data.phone || '';
            document.getElementById('teacherAddress').value = data.address || '';
            document.getElementById('teacherSpecializations').value = data.specializations || '';
            document.getElementById('teacherEducation').value = data.education || '';
            document.getElementById('teacherHourlyRate').value = data.hourly_rate || '';
            document.getElementById('teacherHireDate').value = data.hire_date || '';
            document.getElementById('teacherStatus').value = data.status || 'active';
        })
        .catch(error => {
            console.error('Error loading teacher data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('teacherSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeTeacherSlidePanel() {
    document.getElementById('teacherSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('teacherForm').reset();
    }, 400);
}

// File upload preview
document.getElementById('teacherPhoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = document.querySelector('#teacherSlidePanel .file-upload-content');
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
document.getElementById('teacherForm').addEventListener('submit', function(e) {
    const requiredFields = ['first_name', 'last_name', 'phone', 'specializations', 'hourly_rate', 'hire_date'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('teacher' + field.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(''));
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

// Phone number formatting for teacher
document.getElementById('teacherPhone').addEventListener('input', function() {
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
        closeTeacherSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('teacherSlidePanel').classList.contains('active')) {
            document.getElementById('teacherSubmitBtn').click();
        }
    }
});
</script>

@endsection