@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Kurslar</h1>
            <p class="gemini-card-subtitle">Barcha kurslarni boshqaring va yangilarini yarating</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.courses.applications') }}" class="gemini-btn" style="background: #2196f3; color: white;">
                <i class="fas fa-file-alt"></i> Kurs arizalari
            </a>
            <button class="gemini-btn btn-animate" onclick="openCourseSlidePanel()">
                <i class="fas fa-plus"></i> Yangi kurs
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $courses->total() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami kurslar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $courses->where('status', 'active')->count() }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Faol kurslar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #ff9800;">{{ $courses->sum('groups_count') ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami guruhlar</div>
        </div>
    </div>

    <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('admin.courses.index') }}" style="display: flex; gap: 12px; align-items: end;">
            <div style="flex: 1;">
                <input type="text" name="search" class="gemini-input" placeholder="Kurs nomi bo'yicha qidirish..." value="{{ request('search') }}">
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
                <th>Kurs</th>
                <th>Davomiylik</th>
                <th>Narx</th>
                <th>Guruhlar</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $course->photo_url }}" width="40" height="40" style="border-radius: 8px;" alt="{{ $course->name }}">
                        <strong>{{ $course->name }}</strong>
                    </div>
                </td>
                <td>{{ $course->duration_months }} oy</td>
                <td>{{ number_format($course->price) }} so'm</td>
                <td>{{ $course->groups_count }}</td>
                <td>
                    <span style="background: {{ $course->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $course->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ $course->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                        {{ $course->status == 'active' ? 'Faol' : 'Nofaol' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.courses.show', $course) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" onclick="editCourse({{ $course->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
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
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Kurslar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Course Slide Panel -->
<div id="courseSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeCourseSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="coursePanelTitle">Yangi Kurs</h2>
                <p class="slide-panel-subtitle">Kurs ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeCourseSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="courseForm" method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="courseId" name="course_id">
                <input type="hidden" id="courseFormMethod" name="_method">
                
                <!-- Basic Info Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-book"></i>
                        Asosiy Ma'lumotlar
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Kurs nomi *</label>
                        <input type="text" name="name" id="courseName" class="form-input" required placeholder="Masalan: Matematika kursi">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tavsif</label>
                        <textarea name="description" id="courseDescription" class="form-input" rows="4" placeholder="Kurs haqida batafsil ma'lumot..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Kurs rasmi</label>
                        <div class="file-upload-area">
                            <input type="file" name="photo" id="coursePhoto" class="file-input" accept="image/*">
                            <div class="file-upload-content">
                                <i class="fas fa-image"></i>
                                <p>Kurs rasmini yuklang</p>
                                <small>JPG, PNG formatida, maksimal 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Details Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-cog"></i>
                        Kurs Tafsilotlari
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Davomiylik (oy) *</label>
                            <input type="number" name="duration_months" id="courseDuration" class="form-input" required min="1" max="24" placeholder="6">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Narx (so'm) *</label>
                            <input type="number" name="price" id="coursePrice" class="form-input" required min="0" step="10000" placeholder="500000">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Darslar soni *</label>
                            <input type="number" name="lessons_count" id="courseLessons" class="form-input" required min="1" placeholder="48">
                        </div>
                        
                        <div class="form-group" id="courseStatusGroup" style="display: none;">
                            <label class="form-label">Holat</label>
                            <select name="status" id="courseStatus" class="form-input">
                                <option value="active">Faol</option>
                                <option value="inactive">Nofaol</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Kurs dasturi</label>
                        <textarea name="curriculum" id="courseCurriculum" class="form-input" rows="6" placeholder="1-modul: Asoslar\n2-modul: O'rta daraja\n3-modul: Yuqori daraja"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Talablar</label>
                        <textarea name="requirements" id="courseRequirements" class="form-input" rows="3" placeholder="Boshlang'ich bilim, kompyuter ko'nikmalari"></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeCourseSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="courseForm" class="btn-primary" id="courseSubmitBtn">
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
let isCourseEditMode = false;

function openCourseSlidePanel() {
    isCourseEditMode = false;
    document.getElementById('coursePanelTitle').textContent = 'Yangi Kurs';
    document.getElementById('courseForm').action = '{{ route("admin.courses.store") }}';
    document.getElementById('courseFormMethod').value = '';
    document.getElementById('courseStatusGroup').style.display = 'none';
    document.getElementById('courseSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('courseForm').reset();
    
    document.getElementById('courseSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editCourse(courseId) {
    isCourseEditMode = true;
    document.getElementById('coursePanelTitle').textContent = 'Kursni Tahrirlash';
    document.getElementById('courseForm').action = `/admin/courses/${courseId}`;
    document.getElementById('courseFormMethod').value = 'PUT';
    document.getElementById('courseId').value = courseId;
    document.getElementById('courseStatusGroup').style.display = 'block';
    document.getElementById('courseSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Load course data via AJAX
    fetch(`/admin/courses/${courseId}`, {
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
            document.getElementById('courseName').value = data.name || '';
            document.getElementById('courseDescription').value = data.description || '';
            document.getElementById('courseDuration').value = data.duration_months || '';
            document.getElementById('coursePrice').value = data.price || '';
            document.getElementById('courseLessons').value = data.lessons_count || '';
            document.getElementById('courseStatus').value = data.status || 'active';
            document.getElementById('courseCurriculum').value = data.curriculum || '';
            document.getElementById('courseRequirements').value = data.requirements || '';
        })
        .catch(error => {
            console.error('Error loading course data:', error);
            alert('Ma\'lumotlarni yuklashda xatolik yuz berdi');
        });
    
    document.getElementById('courseSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCourseSlidePanel() {
    document.getElementById('courseSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('courseForm').reset();
    }, 400);
}

// File upload preview
document.getElementById('coursePhoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const content = document.querySelector('#courseSlidePanel .file-upload-content');
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
document.getElementById('courseForm').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'duration_months', 'price', 'lessons_count'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('course' + field.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('').replace('Months', 'Duration').replace('Count', 'Lessons'));
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

// Price formatting
document.getElementById('coursePrice').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value) {
        this.value = parseInt(value);
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCourseSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('courseSlidePanel').classList.contains('active')) {
            document.getElementById('courseSubmitBtn').click();
        }
    }
});
</script>

@endsection