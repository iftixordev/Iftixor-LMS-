@extends('layouts.student')

@section('page-title', 'O\'quv Materiallari')

@section('content')
<!-- Course Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <select class="form-select">
                    <option>Barcha kurslar</option>
                    <option>JavaScript Asoslari</option>
                    <option>React Development</option>
                    <option>HTML/CSS</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Materiallarni qidirish...">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Materials by Course -->
<div class="accordion" id="materialsAccordion">
    <!-- JavaScript Course -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#js-materials">
                <i class="fab fa-js-square fa-2x text-warning me-3"></i>
                <div>
                    <strong>JavaScript Asoslari</strong>
                    <br><small class="text-muted">15 ta material</small>
                </div>
            </button>
        </h2>
        <div id="js-materials" class="accordion-collapse collapse show">
            <div class="accordion-body">
                <div class="row">
                    <!-- Video Material -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-play-circle fa-2x text-danger me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6>1-dars: JavaScript Kirish</h6>
                                        <p class="text-muted small mb-2">Video dars - 45 daqiqa</p>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <small class="text-success">Ko'rilgan</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-play"></i> Ko'rish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PDF Material -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6>JavaScript Qo'llanma</h6>
                                        <p class="text-muted small mb-2">PDF - 2.5 MB</p>
                                        <small class="text-muted">Yuklangan: 15.12.2024</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i> Yuklab olish
                                    </button>
                                    <button class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i> Ko'rish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Presentation -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-file-powerpoint fa-2x text-warning me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6>Variables va Data Types</h6>
                                        <p class="text-muted small mb-2">PowerPoint - 1.8 MB</p>
                                        <small class="text-muted">Yuklangan: 16.12.2024</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i> Yuklab olish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Code Example -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-code fa-2x text-success me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6>Amaliy Misollar</h6>
                                        <p class="text-muted small mb-2">ZIP fayl - 500 KB</p>
                                        <small class="text-muted">Kod namunalari</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download"></i> Yuklab olish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- React Course -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#react-materials">
                <i class="fab fa-react fa-2x text-info me-3"></i>
                <div>
                    <strong>React Development</strong>
                    <br><small class="text-muted">8 ta material</small>
                </div>
            </button>
        </h2>
        <div id="react-materials" class="accordion-collapse collapse">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-play-circle fa-2x text-danger me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6>React Components</h6>
                                        <p class="text-muted small mb-2">Video - 38 daqiqa</p>
                                        <div class="progress mb-2" style="height: 5px;">
                                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                                        </div>
                                        <small class="text-warning">60% ko'rilgan</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-play"></i> Davom etish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Downloads -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0">So'nggi Yuklab Olinganlar</h6>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-pdf text-danger me-3"></i>
                    <div>
                        <h6 class="mb-1">JavaScript Qo'llanma</h6>
                        <small class="text-muted">Bugun, 14:30</small>
                    </div>
                </div>
                <button class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-code text-success me-3"></i>
                    <div>
                        <h6 class="mb-1">Amaliy Misollar</h6>
                        <small class="text-muted">Kecha, 16:45</small>
                    </div>
                </div>
                <button class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection