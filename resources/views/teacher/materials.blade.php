@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">O'quv Materiallari</h1>
    <p class="gemini-card-subtitle">Kurslar uchun materiallar yuklang va boshqaring</p>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: center;">
        <select class="gemini-input">
            <option>Barcha kurslar</option>
            <option>JavaScript Asoslari</option>
            <option>React Development</option>
            <option>HTML/CSS</option>
        </select>
        <div style="position: relative;">
            <input type="text" class="gemini-input" placeholder="Materiallarni qidirish..." style="padding-right: 40px;">
            <button class="gemini-btn" style="position: absolute; right: 4px; top: 50%; transform: translateY(-50%); padding: 6px 8px; background: var(--gemini-blue);">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <button class="gemini-btn" style="background: var(--gemini-blue);" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="fas fa-upload"></i> Material Yuklash
        </button>
    </div>
</div>

<div class="gemini-card">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding: 16px; background: var(--gemini-bg); border-radius: 8px; cursor: pointer;" onclick="toggleMaterials('js-materials')">
        <div style="width: 48px; height: 48px; background: rgba(255, 193, 7, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <i class="fab fa-js-square" style="font-size: 24px; color: #ffc107;"></i>
        </div>
        <div style="flex: 1;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 500;">JavaScript Asoslari</h3>
            <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">12 ta material</p>
        </div>
        <i class="fas fa-chevron-down" id="js-materials-icon" style="color: var(--gemini-text-secondary); transition: transform 0.3s ease;"></i>
    </div>
    
    <div id="js-materials" style="display: block;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 16px;">
            <div style="background: var(--gemini-surface); border-radius: 8px; padding: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: rgba(244, 67, 54, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-play-circle" style="color: #f44336; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">1-dars: JavaScript Kirish</h4>
                            <p style="margin: 0 0 4px 0; color: var(--gemini-text-secondary); font-size: 14px;">Video - 45 daqiqa</p>
                            <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 12px;">Yuklangan: 15.12.2024</p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="gemini-btn" style="padding: 6px 8px; background: var(--gemini-bg);" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Ko'rish</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Tahrirlash</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i>Ulashish</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>O'chirish</a></li>
                        </ul>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">Faol</span>
                    <span style="color: var(--gemini-text-secondary); font-size: 12px;">156 ko'rishlar</span>
                </div>
            </div>

            <div style="background: var(--gemini-surface); border-radius: 8px; padding: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: rgba(244, 67, 54, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-pdf" style="color: #f44336; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 500;">JavaScript Qo'llanma</h4>
                            <p style="margin: 0 0 4px 0; color: var(--gemini-text-secondary); font-size: 14px;">PDF - 2.5 MB</p>
                            <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 12px;">Yuklangan: 16.12.2024</p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="gemini-btn" style="padding: 6px 8px; background: var(--gemini-bg);" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Yuklab olish</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Tahrirlash</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i>Ulashish</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>O'chirish</a></li>
                        </ul>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">Faol</span>
                    <span style="color: var(--gemini-text-secondary); font-size: 12px;">89 yuklab olish</span>
                </div>
            </div>

                    <!-- Presentation -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-file-powerpoint fa-2x text-warning me-3"></i>
                                        <div>
                                            <h6>Variables va Data Types</h6>
                                            <p class="text-muted small mb-1">PowerPoint - 1.8 MB</p>
                                            <small class="text-muted">Yuklangan: 17.12.2024</small>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Ko'rish</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Tahrirlash</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i>Ulashish</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>O'chirish</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success">Faol</span>
                                    <small class="text-muted">67 ko'rishlar</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Code Examples -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-code fa-2x text-success me-3"></i>
                                        <div>
                                            <h6>Amaliy Misollar</h6>
                                            <p class="text-muted small mb-1">ZIP - 500 KB</p>
                                            <small class="text-muted">Yuklangan: 18.12.2024</small>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Yuklab olish</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Tahrirlash</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-share me-2"></i>Ulashish</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>O'chirish</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success">Faol</span>
                                    <small class="text-muted">45 yuklab olish</small>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<div class="gemini-card" style="margin-top: 24px;">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding: 16px; background: var(--gemini-bg); border-radius: 8px; cursor: pointer;" onclick="toggleMaterials('react-materials')">
        <div style="width: 48px; height: 48px; background: rgba(33, 150, 243, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <i class="fab fa-react" style="font-size: 24px; color: #2196f3;"></i>
        </div>
        <div style="flex: 1;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 500;">React Development</h3>
            <p style="margin: 0; color: var(--gemini-text-secondary); font-size: 14px;">8 ta material</p>
        </div>
        <i class="fas fa-chevron-down" id="react-materials-icon" style="color: var(--gemini-text-secondary); transition: transform 0.3s ease; transform: rotate(-90deg);"></i>
    </div>
    
    <div id="react-materials" style="display: none;">
        <div style="text-align: center; padding: 40px 20px; color: var(--gemini-text-secondary);">
            <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
            <p style="margin: 0; font-size: 16px;">React kursi uchun materiallar</p>
        </div>
    </div>
</div>

<script>
function toggleMaterials(id) {
    const content = document.getElementById(id);
    const icon = document.getElementById(id + '-icon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.display = 'none';
        icon.style.transform = 'rotate(-90deg)';
    }
}
</script>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Material Yuklash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kurs</label>
                                <select class="form-select">
                                    <option>JavaScript Asoslari</option>
                                    <option>React Development</option>
                                    <option>HTML/CSS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Material turi</label>
                                <select class="form-select">
                                    <option>Video dars</option>
                                    <option>PDF hujjat</option>
                                    <option>Taqdimot</option>
                                    <option>Kod namunalari</option>
                                    <option>Boshqa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Material nomi</label>
                        <input type="text" class="form-control" placeholder="Masalan: JavaScript Kirish">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tavsif</label>
                        <textarea class="form-control" rows="3" placeholder="Material haqida qisqacha ma'lumot..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Fayl yuklash</label>
                        <input type="file" class="form-control" multiple>
                        <small class="text-muted">Maksimal hajm: 50MB. Qo'llab-quvvatlanadigan formatlar: PDF, PPT, MP4, ZIP</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="shareWithStudents" checked>
                                    <label class="form-check-label" for="shareWithStudents">
                                        O'quvchilar bilan ulashish
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allowDownload" checked>
                                    <label class="form-check-label" for="allowDownload">
                                        Yuklab olishga ruxsat berish
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary">Yuklash</button>
            </div>
        </div>
    </div>
</div>
@endsection