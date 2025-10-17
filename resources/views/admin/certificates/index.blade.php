@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Sertifikatlar</h1>
            <p class="gemini-card-subtitle">O'quvchilar sertifikatlarini boshqaring</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="gemini-btn btn-animate" onclick="openCertificateSlidePanel()">
                <i class="fas fa-plus"></i> Yangi sertifikat
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $certificates->total() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Jami sertifikatlar</div>
        </div>
        <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; text-align: center;">
            <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $certificates->where('is_sent', true)->count() ?? 0 }}</div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">Yuborilgan</div>
        </div>
    </div>

    <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('admin.certificates.index') }}" style="display: flex; gap: 12px; align-items: end;">
            <div style="flex: 1;">
                <input type="text" name="search" class="gemini-input" placeholder="O'quvchi yoki sertifikat raqami bo'yicha qidirish..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-search"></i> Qidirish
            </button>
        </form>
    </div>

    <table class="gemini-table">
        <thead>
            <tr>
                <th>Sertifikat</th>
                <th>O'quvchi</th>
                <th>Kurs</th>
                <th>Sana</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certificates ?? [] as $certificate)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff9800, #f57c00); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-certificate" style="color: white; font-size: 16px;"></i>
                        </div>
                        <strong>{{ $certificate->certificate_number ?? 'N/A' }}</strong>
                    </div>
                </td>
                <td>{{ $certificate->student->full_name ?? 'N/A' }}</td>
                <td>{{ $certificate->course->name ?? 'N/A' }}</td>
                <td>{{ $certificate->issued_date ? $certificate->issued_date->format('d.m.Y') : 'N/A' }}</td>
                <td>
                    <span style="background: {{ ($certificate->is_sent ?? false) ? 'rgba(76, 175, 80, 0.1)' : 'rgba(255, 193, 7, 0.1)' }}; color: {{ ($certificate->is_sent ?? false) ? '#4caf50' : '#ff9800' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ ($certificate->is_sent ?? false) ? '#4caf50' : '#ff9800' }};">
                        {{ ($certificate->is_sent ?? false) ? 'Yuborilgan' : 'Yuborilmagan' }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.certificates.show', $certificate) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.certificates.download', $certificate) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px;" onclick="editCertificate({{ $certificate->id ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Sertifikatlar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Certificate Slide Panel -->
<div id="certificateSlidePanel" class="slide-panel">
    <div class="slide-panel-overlay" onclick="closeCertificateSlidePanel()"></div>
    <div class="slide-panel-content">
        <div class="slide-panel-header">
            <div>
                <h2 id="certificatePanelTitle">Yangi Sertifikat</h2>
                <p class="slide-panel-subtitle">Sertifikat ma'lumotlarini kiriting</p>
            </div>
            <button class="slide-panel-close" onclick="closeCertificateSlidePanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="slide-panel-body">
            <form id="certificateForm" method="POST" action="{{ route('admin.certificates.store') }}">
                @csrf
                <input type="hidden" id="certificateId" name="certificate_id">
                <input type="hidden" id="certificateFormMethod" name="_method">
                
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-certificate"></i>
                        Sertifikat Ma'lumotlari
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">O'quvchi *</label>
                            <select name="student_id" id="certificateStudent" class="form-input" required>
                                <option value="">O'quvchini tanlang...</option>
                                @foreach($students ?? [] as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kurs *</label>
                            <select name="course_id" id="certificateCourse" class="form-input" required>
                                <option value="">Kursni tanlang...</option>
                                @foreach($courses ?? [] as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Sertifikat raqami</label>
                            <input type="text" name="certificate_number" id="certificateNumber" class="form-input" placeholder="Avtomatik generatsiya qilinadi">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Berilgan sana *</label>
                            <input type="date" name="issued_date" id="certificateDate" class="form-input" value="{{ today()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Baho</label>
                            <select name="grade" id="certificateGrade" class="form-input">
                                <option value="">Bahoni tanlang</option>
                                <option value="A">A - A'lo</option>
                                <option value="B">B - Yaxshi</option>
                                <option value="C">C - Qoniqarli</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="certificateStatusGroup" style="display: none;">
                            <label class="form-label">Holat</label>
                            <select name="is_sent" id="certificateStatus" class="form-input">
                                <option value="0">Yuborilmagan</option>
                                <option value="1">Yuborilgan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Qo'shimcha ma'lumot</label>
                        <textarea name="notes" id="certificateNotes" class="form-input" rows="3" placeholder="Sertifikat haqida qo'shimcha ma'lumot..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="slide-panel-footer">
            <button type="button" class="btn-secondary" onclick="closeCertificateSlidePanel()">
                <i class="fas fa-times"></i> Bekor qilish
            </button>
            <button type="submit" form="certificateForm" class="btn-primary" id="certificateSubmitBtn">
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
let isCertificateEditMode = false;

function openCertificateSlidePanel() {
    isCertificateEditMode = false;
    document.getElementById('certificatePanelTitle').textContent = 'Yangi Sertifikat';
    document.getElementById('certificateForm').action = '{{ route("admin.certificates.store") }}';
    document.getElementById('certificateFormMethod').value = '';
    document.getElementById('certificateStatusGroup').style.display = 'none';
    document.getElementById('certificateSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Saqlash';
    
    // Clear form
    document.getElementById('certificateForm').reset();
    document.getElementById('certificateDate').value = '{{ today()->format("Y-m-d") }}';
    
    document.getElementById('certificateSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function editCertificate(certificateId) {
    isCertificateEditMode = true;
    document.getElementById('certificatePanelTitle').textContent = 'Sertifikatni Tahrirlash';
    document.getElementById('certificateForm').action = `/admin/certificates/${certificateId}`;
    document.getElementById('certificateFormMethod').value = 'PUT';
    document.getElementById('certificateId').value = certificateId;
    document.getElementById('certificateStatusGroup').style.display = 'block';
    document.getElementById('certificateSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Yangilash';
    
    // Clear form first
    document.getElementById('certificateForm').reset();
    
    // Open modal immediately
    document.getElementById('certificateSlidePanel').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Load certificate data via AJAX
    setTimeout(() => {
        fetch(`/admin/certificates/${certificateId}`, {
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
            document.getElementById('certificateStudent').value = data.student_id || '';
            document.getElementById('certificateCourse').value = data.course_id || '';
            document.getElementById('certificateNumber').value = data.certificate_number || '';
            document.getElementById('certificateDate').value = data.issued_date || '';
            document.getElementById('certificateGrade').value = data.grade || '';
            document.getElementById('certificateStatus').value = data.is_sent ? '1' : '0';
            document.getElementById('certificateNotes').value = data.notes || '';
        })
        .catch(error => {
            console.error('Error:', error);
            // Don't show error, just leave form empty for manual entry
        });
    }, 100);
}

function closeCertificateSlidePanel() {
    document.getElementById('certificateSlidePanel').classList.remove('active');
    document.body.style.overflow = 'auto';
    
    // Clear form after animation
    setTimeout(() => {
        document.getElementById('certificateForm').reset();
    }, 400);
}

// Form validation
document.getElementById('certificateForm').addEventListener('submit', function(e) {
    const requiredFields = ['student_id', 'course_id', 'issued_date'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById('certificate' + field.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join('').replace('Id', ''));
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

// Auto-generate certificate number
document.getElementById('certificateStudent').addEventListener('change', function() {
    if (this.value && !isCertificateEditMode) {
        const timestamp = Date.now().toString().slice(-6);
        const studentId = this.value.toString().padStart(3, '0');
        document.getElementById('certificateNumber').value = `CERT-${studentId}-${timestamp}`;
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertificateSlidePanel();
    }
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        if (document.getElementById('certificateSlidePanel').classList.contains('active')) {
            document.getElementById('certificateSubmitBtn').click();
        }
    }
});
</script>
@endsection