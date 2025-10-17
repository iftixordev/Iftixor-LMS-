@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 16px;">
        <h1 class="gemini-card-title">Guruhlar</h1>
        <button class="gemini-btn btn-animate" onclick="openGroupSlidePanel()">
            <i class="fas fa-plus"></i> Yangi guruh
        </button>
    </div>

    <form method="GET" style="display: flex; gap: 12px; margin-bottom: 24px;">
        <input type="text" name="search" class="gemini-input" placeholder="Qidirish..." value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="gemini-btn">
            <i class="fas fa-search"></i> Qidirish
        </button>
    </form>

    <table class="gemini-table">
        <thead>
            <tr>
                <th>Guruh</th>
                <th>Kurs</th>
                <th>O'qituvchi</th>
                <th>O'quvchilar</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groups as $group)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $group->photo_url }}" width="40" height="40" style="border-radius: 8px;" alt="{{ $group->name }}">
                        <strong>{{ $group->name }}</strong>
                    </div>
                </td>
                <td>{{ $group->course->name }}</td>
                <td>{{ $group->teacher->full_name }}</td>
                <td>{{ $group->students_count }}/{{ $group->max_students }}</td>
                <td>
                    <span style="background: {{ $group->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $group->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ $group->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                        {{ $group->status == 'active' ? 'Faol' : 'Nofaol' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.groups.show', $group) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" onclick="editGroup({{ $group->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.groups.destroy', $group) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
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
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Guruhlar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Group Slide Panel -->
<div id="groupSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeGroupSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="groupPanelTitle">Yangi Guruh</h2>
                <p class="slide-panel-subtitle">Guruh ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeGroupSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="groupForm" method="POST" action="{{ route('admin.groups.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="groupId" name="group_id">
                <input type="hidden" id="groupFormMethod" name="_method">
                
                <!-- Basic Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i>
                        Asosiy Ma'lumotlar
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Guruh nomi *</label>
                        <input type="text" name="name" id="groupName" class="form-input" required placeholder="Masalan: Matematika-1">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Kurs *</label>
                            <select name="course_id" id="groupCourse" class="form-input" required>
                                <option value="">Kursni tanlang</option>
                                @foreach($courses ?? [] as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">O'qituvchi *</label>
                            <select name="teacher_id" id="groupTeacher" class="form-input" required>
                                <option value="">O'qituvchini tanlang</option>
                                @foreach($teachers ?? [] as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Guruh rasmi</label>
                        <div class="file-upload-area">
                            <input type="file" name="photo" id="groupPhoto" class="file-input" accept="image/*">
                            <div class="file-upload-content">
                                <i class="fas fa-image"></i>
                                <p>Guruh rasmini yuklang</p>
                                <small>JPG, PNG formatida, maksimal 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Schedule Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-calendar"></i>
                        Jadval Ma'lumotlari
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Boshlanish sanasi *</label>
                            <input type="date" name="start_date" id="groupStartDate" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tugash sanasi *</label>
                            <input type="date" name="end_date" id="groupEndDate" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Maksimal o'quvchilar *</label>
                            <input type="number" name="max_students" id="groupMaxStudents" class="form-input" required min="1" max="50" value="15">
                        </div>
                        
                        <div class="form-group" id="groupStatusGroup" style="display: none;">
                            <label class="form-label">Holat</label>
                            <select name="status" id="groupStatus" class="form-input">
                                <option value="active">Faol</option>
                                <option value="inactive">Nofaol</option>
                                <option value="completed">Tugallangan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Izoh</label>
                        <textarea name="description" id="groupDescription" class="form-input" rows="3" placeholder="Guruh haqida qo'shimcha ma'lumot..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeGroupSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="groupForm" class="btn-primary" id="groupSubmitBtn">
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
let isGroupEditMode = false;

function openGroupSlidePanel() {
    isGroupEditMode = false;
    document.getElementById('groupPanelTitle').textContent = 'Yangi Guruh';
    document.getElementById('groupForm').action = '{{ route("admin.groups.store") }}';
    document.getElementById('groupFormMethod').value = '';
    document.getElementById('groupStatusGroup').style.display = 'none';
    document.getElementById('groupSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('groupForm').reset();
    document.getElementById('groupMaxStudents').value = '15';
    
    document.getElementById('groupSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editGroup(groupId) {
    isGroupEditMode = true;
    document.getElementById('groupPanelTitle').textContent = 'Guruhni Tahrirlash';
    document.getElementById('groupForm').action = `/admin/groups/${groupId}`;
    document.getElementById('groupFormMethod').value = 'PUT';
    document.getElementById('groupId').value = groupId;
    document.getElementById('groupStatusGroup').style.display = 'block';
    document.getElementById('groupSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load group data via AJAX
    fetch(`/admin/groups/${groupId}`, {
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
            document.getElementById('groupName').value = data.name || '';
            document.getElementById('groupCourse').value = data.course_id || '';
            document.getElementById('groupTeacher').value = data.teacher_id || '';
            document.getElementById('groupStartDate').value = data.start_date || '';
            document.getElementById('groupEndDate').value = data.end_date || '';
            document.getElementById('groupMaxStudents').value = data.max_students || 15;
            document.getElementById('groupStatus').value = data.status || 'active';
            document.getElementById('groupDescription').value = data.description || '';
        })
        .catch(error => {
            console.error('Error loading group data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('groupSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeGroupSlidePanel() {
    document.getElementById('groupSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('groupForm').reset();
    }, 400);
}

// File upload preview
document.getElementById('groupPhoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = document.querySelector('#groupSlidePanel .file-upload-content');
            content.innerHTML = `
                <img src="${e.target.result}" style="max-width: 120px; max-height: 80px; border-radius: 8px; margin-bottom: 8px; object-fit: cover;">
                <p>${file.name}</p>
                <small>Rasm yuklandi</small>
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.getElementById('groupForm').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'course_id', 'teacher_id', 'start_date', 'end_date', 'max_students'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('group' + field.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('').replace('Id', ''));
        if (input && !input.value.trim()) {
            input.style.borderColor = '#f44336';
            isValid = false;
        } else if (input) {
            input.style.borderColor = 'var(--yt-spec-10-percent-layer)';
        }
    });
    
    // Check if end date is after start date
    const startDate = document.getElementById('groupStartDate').value;
    const endDate = document.getElementById('groupEndDate').value;
    if (startDate && endDate && new Date(endDate) <= new Date(startDate)) {
        document.getElementById('groupEndDate').style.borderColor = '#f44336';
        isValid = false;
        alert('Tugash sanasi boshlanish sanasidan keyin bo\'lishi kerak!');
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Iltimos, barcha majburiy maydonlarni to\'g\'ri to\'ldiring!');
    }
});

// Auto-calculate end date based on course duration
document.getElementById('groupCourse').addEventListener('change', function() {
    const courseId = this.value;
    const startDate = document.getElementById('groupStartDate').value;
    
    if (courseId && startDate) {
        // This would need course duration data - for now just add 6 months
        const start = new Date(startDate);
        start.setMonth(start.getMonth() + 6);
        document.getElementById('groupEndDate').value = start.toISOString().split('T')[0];
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeGroupSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('groupSlidePanel').classList.contains('active')) {
            document.getElementById('groupSubmitBtn').click();
        }
    }
});
</script>

@endsection