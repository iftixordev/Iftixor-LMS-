@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Baholar Jurnali</h1>
    <p class="gemini-card-subtitle">O'quvchilar baholarini boshqaring va kuzating</p>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: center;">
        <select class="gemini-input">
            <option>JS-01 - JavaScript Asoslari</option>
            <option>RC-01 - React Development</option>
            <option>WD-02 - Web Design</option>
        </select>
        <select class="gemini-input">
            <option>Barcha baholar</option>
            <option>Testlar</option>
            <option>Loyihalar</option>
            <option>Uy vazifalari</option>
        </select>
        <div style="display: flex; gap: 8px;">
            <button class="gemini-btn" style="background: #4caf50; flex: 1;">
                <i class="fas fa-plus"></i> Yangi Baho
            </button>
            <button class="gemini-btn" style="background: var(--gemini-blue); flex: 1;">
                <i class="fas fa-download"></i> Eksport
            </button>
        </div>
    </div>
</div>

<div class="gemini-card">
    <h2 class="gemini-card-title">JS-01 Guruh - Baholar Jurnali</h2>
    
    <div style="overflow-x: auto;">
        <div style="min-width: 800px;">
            <div style="display: grid; grid-template-columns: 200px repeat(5, 100px) 80px 120px; gap: 8px; padding: 16px; background: var(--gemini-bg); border-radius: 8px; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: var(--gemini-text-secondary);">
                <div>O'quvchi</div>
                <div style="text-align: center;">Variables</div>
                <div style="text-align: center;">Functions</div>
                <div style="text-align: center;">Objects</div>
                <div style="text-align: center;">Calculator</div>
                <div style="text-align: center;">Todo App</div>
                <div style="text-align: center;">O'rtacha</div>
                <div style="text-align: center;">Amallar</div>
            </div>
            <div style="display: grid; grid-template-columns: 200px repeat(5, 100px) 80px 120px; gap: 8px; align-items: center; padding: 16px; background: var(--gemini-surface); border-radius: 8px; margin-bottom: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img src="/images/default-user.svg" width="30" height="30" style="border-radius: 50%;" alt="Student">
                    <span style="font-weight: 500;">Ali Valiyev</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">95</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">88</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(255, 152, 0, 0.1); color: #ff9800; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">75</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">92</span>
                </div>
                <div style="text-align: center;">
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: var(--gemini-blue);" data-bs-toggle="modal" data-bs-target="#addGradeModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div style="text-align: center; font-weight: 500; color: #4caf50;">87.5</div>
                <div style="display: flex; gap: 4px; justify-content: center;">
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: var(--gemini-blue);">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #ff9800;">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </div>
                    
            <div style="display: grid; grid-template-columns: 200px repeat(5, 100px) 80px 120px; gap: 8px; align-items: center; padding: 16px; background: var(--gemini-surface); border-radius: 8px; margin-bottom: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img src="/images/default-user.svg" width="30" height="30" style="border-radius: 50%;" alt="Student">
                    <span style="font-weight: 500;">Malika Karimova</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">90</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">85</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">82</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(255, 152, 0, 0.1); color: #ff9800; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">78</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(33, 150, 243, 0.1); color: #2196f3; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">Jarayonda</span>
                </div>
                <div style="text-align: center; font-weight: 500; color: #4caf50;">83.8</div>
                <div style="display: flex; gap: 4px; justify-content: center;">
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: var(--gemini-blue);">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #ff9800;">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </div>
                    
            <div style="display: grid; grid-template-columns: 200px repeat(5, 100px) 80px 120px; gap: 8px; align-items: center; padding: 16px; background: var(--gemini-surface); border-radius: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <img src="/images/default-user.svg" width="30" height="30" style="border-radius: 50%;" alt="Student">
                    <span style="font-weight: 500;">Sardor Toshev</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(255, 152, 0, 0.1); color: #ff9800; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">72</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(255, 152, 0, 0.1); color: #ff9800; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">68</span>
                </div>
                <div style="text-align: center;">
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #9e9e9e;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(255, 152, 0, 0.1); color: #ff9800; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">70</span>
                </div>
                <div style="text-align: center;">
                    <span style="background: rgba(158, 158, 158, 0.1); color: #9e9e9e; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">Topshirmagan</span>
                </div>
                <div style="text-align: center; font-weight: 500; color: #ff9800;">70.0</div>
                <div style="display: flex; gap: 4px; justify-content: center;">
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: var(--gemini-blue);">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #ff9800;">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-top: 24px;">
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4caf50;">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #4caf50;">80.4</div>
            <div class="gemini-stat-label">Guruh O'rtachasi</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196f3;">
            <i class="fas fa-users"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #2196f3;">15</div>
            <div class="gemini-stat-label">Jami O'quvchi</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #ff9800;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #ff9800;">3</div>
            <div class="gemini-stat-label">Qiyinchilik Bor</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196f3;">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #2196f3;">87%</div>
            <div class="gemini-stat-label">O'zlashtirish</div>
        </div>
    </div>
</div>

<!-- Add Grade Modal -->
<div class="modal fade" id="addGradeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Baho Qo'shish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">O'quvchi</label>
                        <select class="form-select">
                            <option>Ali Valiyev</option>
                            <option>Malika Karimova</option>
                            <option>Sardor Toshev</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Baho turi</label>
                        <select class="form-select">
                            <option>Test</option>
                            <option>Loyiha</option>
                            <option>Uy vazifasi</option>
                            <option>Amaliy ish</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mavzu</label>
                        <input type="text" class="form-control" placeholder="Masalan: Objects Test">
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Ball</label>
                                <input type="number" class="form-control" min="0" max="100" placeholder="85">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Maksimal ball</label>
                                <input type="number" class="form-control" value="100">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea class="form-control" rows="3" placeholder="Qo'shimcha izohlar..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-success">Saqlash</button>
            </div>
        </div>
    </div>
</div>
@endsection