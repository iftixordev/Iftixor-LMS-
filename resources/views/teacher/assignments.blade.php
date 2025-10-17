@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Vazifalar Boshqaruvi</h1>
    <p class="gemini-card-subtitle">O'quvchilar uchun vazifalar yarating va tekshiring</p>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div style="display: flex; gap: 8px;">
        <button class="gemini-btn" style="background: var(--gemini-blue);">
            <i class="fas fa-list"></i> Barchasi
        </button>
        <button class="gemini-btn" style="background: #ff9800;">
            <i class="fas fa-clock"></i> Tekshirilmagan
        </button>
        <button class="gemini-btn" style="background: #4caf50;">
            <i class="fas fa-check"></i> Baholangan
        </button>
    </div>
    <button class="gemini-btn" style="background: var(--gemini-blue);" data-bs-toggle="modal" data-bs-target="#createAssignmentModal">
        <i class="fas fa-plus"></i> Yangi Vazifa
    </button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 24px;">
    <div class="gemini-card" style="margin: 0; border-left: 4px solid #ff9800;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 500;">JavaScript Calculator</h2>
            <span style="background: rgba(255, 152, 0, 0.1); color: #ff9800; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 500;">
                5 ta tekshirilmagan
            </span>
        </div>
        
        <p style="margin: 0 0 8px 0; color: var(--gemini-text-secondary); font-size: 14px;">JS-01 Guruh</p>
        <p style="margin: 0 0 20px 0; color: var(--gemini-text-primary); line-height: 1.5;">HTML, CSS va JavaScript yordamida oddiy kalkulyator yarating.</p>
        
        <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Berilgan</span>
                    <div style="font-weight: 500;">15.12.2024</div>
                </div>
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Muddat</span>
                    <div style="font-weight: 500; color: #ff9800;">22.12.2024</div>
                </div>
            </div>
            
            <div style="margin-bottom: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 14px; color: var(--gemini-text-secondary);">Topshirish holati</span>
                    <span style="font-size: 14px; font-weight: 500; color: #4caf50;">60%</span>
                </div>
                <div style="background: var(--gemini-border); height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: #4caf50; height: 100%; width: 60%; transition: width 0.3s ease;"></div>
                </div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #ff9800; text-align: center;">
                <i class="fas fa-eye"></i> Tekshirish (5)
            </button>
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: var(--gemini-blue); text-align: center;">
                <i class="fas fa-edit"></i> Tahrirlash
            </button>
        </div>
    </div>

    <div class="gemini-card" style="margin: 0; border-left: 4px solid #4caf50;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 500;">HTML Layout Vazifasi</h2>
            <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 500;">
                Baholangan
            </span>
        </div>
        
        <p style="margin: 0 0 8px 0; color: var(--gemini-text-secondary); font-size: 14px;">WD-02 Guruh</p>
        <p style="margin: 0 0 20px 0; color: var(--gemini-text-primary); line-height: 1.5;">Responsive web sahifa yarating. Bootstrap ishlatishingiz mumkin.</p>
        
        <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Berilgan</span>
                    <div style="font-weight: 500;">10.12.2024</div>
                </div>
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Tugagan</span>
                    <div style="font-weight: 500; color: #4caf50;">18.12.2024</div>
                </div>
            </div>
            
            <div style="margin-bottom: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 14px; color: var(--gemini-text-secondary);">Baholash holati</span>
                    <span style="font-size: 14px; font-weight: 500; color: #4caf50;">100%</span>
                </div>
                <div style="background: var(--gemini-border); height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: #4caf50; height: 100%; width: 100%; transition: width 0.3s ease;"></div>
                </div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #4caf50; text-align: center;">
                <i class="fas fa-chart-bar"></i> Natijalar
            </button>
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: var(--gemini-blue); text-align: center;">
                <i class="fas fa-download"></i> Hisobot
            </button>
        </div>
    </div>

    <div class="gemini-card" style="margin: 0; border-left: 4px solid #2196f3;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 500;">React Components</h2>
            <span style="background: rgba(33, 150, 243, 0.1); color: #2196f3; padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 500;">
                Faol
            </span>
        </div>
        
        <p style="margin: 0 0 8px 0; color: var(--gemini-text-secondary); font-size: 14px;">RC-01 Guruh</p>
        <p style="margin: 0 0 20px 0; color: var(--gemini-text-primary); line-height: 1.5;">React komponentlar yaratish va props ishlatish.</p>
        
        <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Berilgan</span>
                    <div style="font-weight: 500;">20.12.2024</div>
                </div>
                <div>
                    <span style="font-size: 12px; color: var(--gemini-text-secondary);">Muddat</span>
                    <div style="font-weight: 500;">27.12.2024</div>
                </div>
            </div>
            
            <div style="margin-bottom: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 14px; color: var(--gemini-text-secondary);">Topshirish holati</span>
                    <span style="font-size: 14px; font-weight: 500; color: #2196f3;">25%</span>
                </div>
                <div style="background: var(--gemini-border); height: 8px; border-radius: 4px; overflow: hidden;">
                    <div style="background: #2196f3; height: 100%; width: 25%; transition: width 0.3s ease;"></div>
                </div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #2196f3; text-align: center;">
                <i class="fas fa-eye"></i> Ko'rish (3)
            </button>
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: #9e9e9e; text-align: center;">
                <i class="fas fa-bell"></i> Eslatma
            </button>
        </div>
    </div>
</div>

<div class="gemini-card" style="margin-top: 24px;">
    <h2 class="gemini-card-title">Tekshirishni Kutayotgan Vazifalar</h2>
    
    <div style="display: grid; gap: 16px;">
        <div style="display: grid; grid-template-columns: 60px 1fr 150px 150px 120px; gap: 16px; align-items: center; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
            <div style="display: flex; align-items: center; justify-content: center;">
                <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
            </div>
            <div>
                <div style="font-weight: 500; margin-bottom: 4px;">Ali Valiyev</div>
                <div style="font-size: 14px; color: var(--gemini-text-secondary);">JavaScript Calculator</div>
            </div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">20.12.2024 16:30</div>
            <div>
                <a href="#" style="color: #ff9800; text-decoration: none; font-size: 14px;">
                    <i class="fas fa-file-archive"></i> calculator.zip
                </a>
            </div>
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: var(--gemini-blue);" data-bs-toggle="modal" data-bs-target="#gradeModal">
                <i class="fas fa-star"></i> Baholash
            </button>
        </div>
        
        <div style="display: grid; grid-template-columns: 60px 1fr 150px 150px 120px; gap: 16px; align-items: center; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
            <div style="display: flex; align-items: center; justify-content: center;">
                <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
            </div>
            <div>
                <div style="font-weight: 500; margin-bottom: 4px;">Malika Karimova</div>
                <div style="font-size: 14px; color: var(--gemini-text-secondary);">JavaScript Calculator</div>
            </div>
            <div style="font-size: 14px; color: var(--gemini-text-secondary);">21.12.2024 14:15</div>
            <div>
                <a href="#" style="color: #2196f3; text-decoration: none; font-size: 14px;">
                    <i class="fas fa-link"></i> GitHub Link
                </a>
            </div>
            <button class="gemini-btn" style="padding: 8px 12px; font-size: 12px; background: var(--gemini-blue);">
                <i class="fas fa-star"></i> Baholash
            </button>
        </div>
    </div>
</div>

<!-- Create Assignment Modal -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yangi Vazifa Yaratish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Vazifa nomi *</label>
                                <input type="text" class="form-control" placeholder="Masalan: JavaScript Calculator">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Guruh *</label>
                                <select class="form-select">
                                    <option>JS-01 - JavaScript Asoslari</option>
                                    <option>RC-01 - React Development</option>
                                    <option>WD-02 - Web Design</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Vazifa tavsifi *</label>
                        <textarea class="form-control" rows="4" placeholder="Vazifa haqida batafsil ma'lumot..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Topshirish muddati *</label>
                                <input type="datetime-local" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Maksimal ball</label>
                                <input type="number" class="form-control" value="100">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Qo'shimcha fayllar</label>
                        <input type="file" class="form-control" multiple>
                        <small class="text-muted">Vazifa uchun kerakli fayllarni yuklang</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary">Vazifa Yaratish</button>
            </div>
        </div>
    </div>
</div>

<!-- Grade Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vazifani Baholash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>O'quvchi:</strong> Ali Valiyev<br>
                    <strong>Vazifa:</strong> JavaScript Calculator<br>
                    <strong>Topshirilgan:</strong> 20.12.2024 16:30
                </div>
                
                <form>
                    <div class="mb-3">
                        <label class="form-label">Ball (0-100)</label>
                        <input type="number" class="form-control" min="0" max="100" placeholder="85">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea class="form-control" rows="4" placeholder="Vazifa haqida fikr va tavsiyalar..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="allowResubmit">
                            <label class="form-check-label" for="allowResubmit">
                                Qayta topshirishga ruxsat berish
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-success">Baholash</button>
            </div>
        </div>
    </div>
</div>
@endsection