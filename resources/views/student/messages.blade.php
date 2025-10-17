@extends('layouts.student')

@section('page-title', 'Xabarlar')

@section('content')
<div class="row">
    <!-- Messages List -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Suhbatlar</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <!-- Teacher Message -->
                    <div class="list-group-item list-group-item-action active">
                        <div class="d-flex align-items-center">
                            <img src="/images/default-user.svg" width="40" height="40" class="rounded-circle me-3" alt="Teacher">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Aziz Karimov</h6>
                                    <small>14:30</small>
                                </div>
                                <p class="mb-1 text-truncate">Vazifangizni ko'rib chiqdim...</p>
                                <span class="badge bg-primary">2</span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Message -->
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <img src="/images/default-user.svg" width="40" height="40" class="rounded-circle me-3" alt="Admin">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Ma'muriyat</h6>
                                    <small>Kecha</small>
                                </div>
                                <p class="mb-1 text-truncate">To'lov haqida eslatma</p>
                            </div>
                        </div>
                    </div>

                    <!-- Group Chat -->
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">JS-01 Guruh</h6>
                                    <small>16:45</small>
                                </div>
                                <p class="mb-1 text-truncate">Sardor: Ertangi dars bo'ladimi?</p>
                                <span class="badge bg-success">5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <img src="/images/default-user.svg" width="40" height="40" class="rounded-circle me-3" alt="Teacher">
                    <div>
                        <h6 class="mb-0">Aziz Karimov</h6>
                        <small class="text-success">
                            <i class="fas fa-circle"></i> Online
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="card-body" style="height: 400px; overflow-y: auto;">
                <!-- Received Message -->
                <div class="d-flex mb-3">
                    <img src="/images/default-user.svg" width="35" height="35" class="rounded-circle me-2" alt="Teacher">
                    <div class="flex-grow-1">
                        <div class="bg-light rounded p-3">
                            <p class="mb-1">Salom! Vazifangizni ko'rib chiqdim. Juda yaxshi ish qilgansiz!</p>
                            <small class="text-muted">Bugun 14:25</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <img src="/images/default-user.svg" width="35" height="35" class="rounded-circle me-2" alt="Teacher">
                    <div class="flex-grow-1">
                        <div class="bg-light rounded p-3">
                            <p class="mb-1">Faqat bir nechta kichik xatoliklar bor. Ularni to'g'irlasangiz 95 ball olasiz.</p>
                            <small class="text-muted">Bugun 14:26</small>
                        </div>
                    </div>
                </div>

                <!-- Sent Message -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="bg-primary text-white rounded p-3" style="max-width: 70%;">
                        <p class="mb-1">Rahmat! Qaysi qismlarni to'g'irlashim kerak?</p>
                        <small class="opacity-75">Bugun 14:28</small>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <img src="/images/default-user.svg" width="35" height="35" class="rounded-circle me-2" alt="Teacher">
                    <div class="flex-grow-1">
                        <div class="bg-light rounded p-3">
                            <p class="mb-1">CSS qismida responsive dizayn yetishmayapti. Media query'larni qo'shing.</p>
                            <small class="text-muted">Bugun 14:30</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <div class="bg-primary text-white rounded p-3" style="max-width: 70%;">
                        <p class="mb-1">Tushundim, tuzatib yuboraman!</p>
                        <small class="opacity-75">Bugun 14:32</small>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Xabar yozing...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcements -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">E'lonlar</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <div class="d-flex">
                        <i class="fas fa-bullhorn fa-2x me-3"></i>
                        <div>
                            <h6>Yangi Kurs E'loni</h6>
                            <p class="mb-1">Node.js kursi 25-dekabr kuni boshlanadi. Ro'yxatdan o'tish davom etmoqda.</p>
                            <small class="text-muted">20.12.2024 - Ma'muriyat</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h6>To'lov Eslatmasi</h6>
                            <p class="mb-1">Yanvar oyining to'lovini 25-dekabrgacha amalga oshiring.</p>
                            <small class="text-muted">18.12.2024 - Moliya bo'limi</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success">
                    <div class="d-flex">
                        <i class="fas fa-trophy fa-2x me-3"></i>
                        <div>
                            <h6>Tabriklaymiz!</h6>
                            <p class="mb-1">Siz JavaScript kursini muvaffaqiyatli yakunladingiz. Sertifikat tez orada tayyorlanadi.</p>
                            <small class="text-muted">15.12.2024 - O'quv bo'limi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yangi Xabar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Kimga</label>
                        <select class="form-select">
                            <option>O'qituvchini tanlang</option>
                            <option>Aziz Karimov - JavaScript</option>
                            <option>Bobur Toshev - React</option>
                            <option>Ma'muriyat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mavzu</label>
                        <input type="text" class="form-control" placeholder="Xabar mavzusi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Xabar</label>
                        <textarea class="form-control" rows="4" placeholder="Xabaringizni yozing..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary">Yuborish</button>
            </div>
        </div>
    </div>
</div>
@endsection