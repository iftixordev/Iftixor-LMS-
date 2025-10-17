@extends('layouts.student')

@section('page-title', 'Vazifalar')

@section('content')
<!-- Filter Tabs -->
<ul class="nav nav-pills mb-4" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all">Barchasi</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pending">Kutilayotgan</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#submitted">Topshirilgan</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#graded">Baholangan</button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="all">
        <!-- Pending Assignment -->
        <div class="card mb-3 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title">JavaScript Loyiha - Calculator</h6>
                        <p class="text-muted mb-2">JavaScript asoslari kursi</p>
                        <p class="card-text">HTML, CSS va JavaScript yordamida oddiy kalkulyator yarating. Barcha asosiy matematik amallar bo'lishi kerak.</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Berilgan: 15.12.2024
                            <i class="fas fa-clock ms-3 me-1"></i>Muddat: 22.12.2024
                        </small>
                    </div>
                    <span class="badge bg-warning">Kutilayotgan</span>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#submitModal">
                        <i class="fas fa-upload"></i> Topshirish
                    </button>
                    <a href="#" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-download"></i> Faylni Yuklab Olish
                    </a>
                </div>
            </div>
        </div>

        <!-- Submitted Assignment -->
        <div class="card mb-3 border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title">HTML/CSS Layout Vazifasi</h6>
                        <p class="text-muted mb-2">Web Dizayn kursi</p>
                        <p class="card-text">Responsive web sahifa yarating. Bootstrap yoki CSS Grid ishlatishingiz mumkin.</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Topshirilgan: 18.12.2024
                            <i class="fas fa-file ms-3 me-1"></i>layout-project.zip
                        </small>
                    </div>
                    <span class="badge bg-info">Tekshirilayotgan</span>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-secondary btn-sm" disabled>
                        <i class="fas fa-check"></i> Topshirilgan
                    </button>
                </div>
            </div>
        </div>

        <!-- Graded Assignment -->
        <div class="card mb-3 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title">CSS Flexbox Mashq</h6>
                        <p class="text-muted mb-2">Web Dizayn kursi</p>
                        <p class="card-text">Flexbox yordamida turli layoutlar yarating.</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Baholangan: 20.12.2024
                            <i class="fas fa-star ms-3 me-1 text-warning"></i>Baho: 85/100
                        </small>
                        <div class="mt-2">
                            <strong class="text-success">O'qituvchi izohi:</strong>
                            <p class="mb-0 small">Yaxshi ish! Flexbox xususiyatlarini to'g'ri ishlatgansiz. Responsive dizaynga ko'proq e'tibor bering.</p>
                        </div>
                    </div>
                    <span class="badge bg-success">Baholangan</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Assignment Modal -->
<div class="modal fade" id="submitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vazifani Topshirish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Fayl yuklash</label>
                        <input type="file" class="form-control" accept=".zip,.rar,.pdf,.doc,.docx">
                        <small class="text-muted">Maksimal hajm: 10MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Izoh (ixtiyoriy)</label>
                        <textarea class="form-control" rows="3" placeholder="Vazifa haqida qo'shimcha ma'lumot..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Havola (ixtiyoriy)</label>
                        <input type="url" class="form-control" placeholder="GitHub, CodePen yoki boshqa havola">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary">Topshirish</button>
            </div>
        </div>
    </div>
</div>
@endsection