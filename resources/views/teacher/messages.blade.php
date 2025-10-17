@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Xabarlar</h1>
    <p class="gemini-card-subtitle">O'quvchilar va ota-onalar bilan muloqot qiling</p>
</div>

<div style="display: grid; grid-template-columns: 350px 1fr; gap: 24px; height: 600px;">
    <div class="gemini-card" style="margin: 0; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="margin: 0; font-size: 18px; font-weight: 500;">Suhbatlar</h2>
            <div style="display: flex; gap: 8px;">
                <button class="gemini-btn" style="padding: 6px 8px; background: var(--gemini-blue);" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="gemini-btn" style="padding: 6px 8px; background: #4caf50;" data-bs-toggle="modal" data-bs-target="#announcementModal">
                    <i class="fas fa-bullhorn"></i>
                </button>
            </div>
        </div>
        <div style="flex: 1; overflow-y: auto;">
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <div style="padding: 12px; background: rgba(33, 150, 243, 0.1); border-radius: 8px; cursor: pointer; border-left: 4px solid #2196f3;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <h4 style="margin: 0; font-size: 14px; font-weight: 500;">Ali Valiyev</h4>
                                <span style="font-size: 12px; color: var(--gemini-text-secondary);">16:30</span>
                            </div>
                            <p style="margin: 0; font-size: 13px; color: var(--gemini-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Vazifa haqida savol bor...</p>
                            <span style="background: #2196f3; color: white; padding: 2px 6px; border-radius: 10px; font-size: 10px; margin-top: 4px; display: inline-block;">1</span>
                        </div>
                    </div>
                </div>

                <div style="padding: 12px; background: var(--gemini-surface); border-radius: 8px; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: #4caf50; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users" style="color: white; font-size: 16px;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <h4 style="margin: 0; font-size: 14px; font-weight: 500;">JS-01 Guruh</h4>
                                <span style="font-size: 12px; color: var(--gemini-text-secondary);">15:45</span>
                            </div>
                            <p style="margin: 0; font-size: 13px; color: var(--gemini-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Malika: Ertangi dars bo'ladimi?</p>
                            <span style="background: #4caf50; color: white; padding: 2px 6px; border-radius: 10px; font-size: 10px; margin-top: 4px; display: inline-block;">3</span>
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
                                <p class="mb-1 text-truncate">Yangi jadval haqida</p>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Message -->
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <img src="/images/default-user.svg" width="40" height="40" class="rounded-circle me-3" alt="Parent">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">Sardor onasi</h6>
                                    <small>2 kun oldin</small>
                                </div>
                                <p class="mb-1 text-truncate">O'g'limning taraqqiyoti haqida</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="gemini-card" style="margin: 0; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--gemini-border);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 500;">Ali Valiyev</h3>
                    <div style="display: flex; align-items: center; gap: 4px; font-size: 12px; color: #4caf50;">
                        <i class="fas fa-circle" style="font-size: 8px;"></i>
                        <span>Online</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="gemini-btn" style="padding: 6px 8px; background: var(--gemini-blue);">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="gemini-btn" style="padding: 6px 8px; background: var(--gemini-blue);">
                    <i class="fas fa-video"></i>
                </button>
            </div>
        </div>
            
        <div style="flex: 1; overflow-y: auto; padding: 16px 0; display: flex; flex-direction: column; gap: 16px;">
            <div style="display: flex; gap: 8px;">
                <img src="/images/default-user.svg" width="32" height="32" style="border-radius: 50%;" alt="Student">
                <div style="flex: 1;">
                    <div style="background: var(--gemini-bg); border-radius: 12px; padding: 12px; max-width: 80%;">
                        <p style="margin: 0 0 4px 0; line-height: 1.4;">Assalomu alaykum ustoz! Calculator vazifasi haqida savol bor edi.</p>
                        <small style="color: var(--gemini-text-secondary); font-size: 11px;">Bugun 16:25</small>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 8px;">
                <img src="/images/default-user.svg" width="32" height="32" style="border-radius: 50%;" alt="Student">
                <div style="flex: 1;">
                    <div style="background: var(--gemini-bg); border-radius: 12px; padding: 12px; max-width: 80%;">
                        <p style="margin: 0 0 4px 0; line-height: 1.4;">CSS qismida qanday qilib tugmalarni chiroyli qilish mumkin?</p>
                        <small style="color: var(--gemini-text-secondary); font-size: 11px;">Bugun 16:26</small>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <div style="background: var(--gemini-blue); color: white; border-radius: 12px; padding: 12px; max-width: 80%;">
                    <p style="margin: 0 0 4px 0; line-height: 1.4;">Wa alaykum assalom! CSS da border-radius, box-shadow va hover effektlarini ishlatishingiz mumkin.</p>
                    <small style="opacity: 0.8; font-size: 11px;">Bugun 16:28</small>
                </div>
            </div>

                <div class="d-flex justify-content-end mb-3">
                    <div class="bg-primary text-white rounded p-3" style="max-width: 70%;">
                        <p class="mb-1">Misol: button { border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }</p>
                        <small class="opacity-75">Bugun 16:29</small>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <img src="/images/default-user.svg" width="35" height="35" class="rounded-circle me-2" alt="Student">
                    <div class="flex-grow-1">
                        <div class="bg-light rounded p-3">
                            <p class="mb-1">Rahmat ustoz! Sinab ko'raman.</p>
                            <small class="text-muted">Bugun 16:30</small>
                        </div>
                    </div>
                </div>
        </div>

        <div style="border-top: 1px solid var(--gemini-border); padding-top: 16px;">
            <div style="display: flex; gap: 8px; align-items: center;">
                <input type="text" class="gemini-input" placeholder="Xabar yozing..." style="flex: 1;">
                <button class="gemini-btn" style="padding: 8px; background: var(--gemini-bg);">
                    <i class="fas fa-paperclip"></i>
                </button>
                <button class="gemini-btn" style="padding: 8px; background: var(--gemini-blue);">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Tezkor Amallar</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#announcementModal">
                            <i class="fas fa-bullhorn fa-2x mb-2"></i>
                            <br>E'lon Yuborish
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success w-100">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <br>Guruh Xabari
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-warning w-100">
                            <i class="fas fa-user-friends fa-2x mb-2"></i>
                            <br>Ota-onalarga
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-info w-100">
                            <i class="fas fa-bell fa-2x mb-2"></i>
                            <br>Eslatma
                        </button>
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
                            <option>O'quvchini tanlang</option>
                            <option>Ali Valiyev</option>
                            <option>Malika Karimova</option>
                            <option>Sardor Toshev</option>
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

<!-- Announcement Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">E'lon Yuborish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Kimga yuborish</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="allStudents" checked>
                            <label class="form-check-label" for="allStudents">
                                Barcha o'quvchilarim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="specificGroup">
                            <label class="form-check-label" for="specificGroup">
                                Muayyan guruh
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">E'lon sarlavhasi</label>
                        <input type="text" class="form-control" placeholder="Masalan: Ertangi dars bekor qilindi">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">E'lon matni</label>
                        <textarea class="form-control" rows="4" placeholder="E'lon matnini yozing..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sendSMS">
                            <label class="form-check-label" for="sendSMS">
                                SMS orqali ham yuborish
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-success">E'lon Yuborish</button>
            </div>
        </div>
    </div>
</div>
@endsection