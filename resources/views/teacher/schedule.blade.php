@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Dars Jadvali</h1>
    <p class="gemini-card-subtitle">Haftalik dars jadvalingizni ko'ring va boshqaring</p>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: center;">
        <div style="display: flex; gap: 4px;">
            <button class="gemini-btn" style="background: var(--gemini-blue); flex: 1;">Hafta</button>
            <button class="gemini-btn" style="background: var(--gemini-bg); flex: 1;">Oy</button>
        </div>
        <div style="display: flex; align-items: center; gap: 4px;">
            <button class="gemini-btn" style="padding: 8px; background: var(--gemini-bg);">
                <i class="fas fa-chevron-left"></i>
            </button>
            <input type="week" class="gemini-input" value="{{ date('Y-\WW') }}" style="text-align: center; flex: 1;">
            <button class="gemini-btn" style="padding: 8px; background: var(--gemini-bg);">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <button class="gemini-btn" style="background: #4caf50;" data-bs-toggle="modal" data-bs-target="#addLessonModal">
            <i class="fas fa-plus"></i> Dars Qo'shish
        </button>
    </div>
</div>

<div class="gemini-card">
    <h2 class="gemini-card-title">Haftalik Dars Jadvali</h2>
    
    <div style="overflow-x: auto;">
        <div style="min-width: 800px;">
            <div style="display: grid; grid-template-columns: 100px repeat(6, 1fr); gap: 8px; padding: 16px; background: var(--gemini-bg); border-radius: 8px; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: var(--gemini-text-secondary);">
                <div>Vaqt</div>
                <div>Dushanba</div>
                <div>Seshanba</div>
                <div>Chorshanba</div>
                <div>Payshanba</div>
                <div>Juma</div>
                <div>Shanba</div>
            </div>
            <div style="display: grid; grid-template-columns: 100px repeat(6, 1fr); gap: 8px; align-items: start; margin-bottom: 8px; min-height: 80px;">
                <div style="font-weight: 500; text-align: center; padding: 8px; background: var(--gemini-bg); border-radius: 4px; display: flex; align-items: center; justify-content: center;">09:00-10:30</div>
                <div></div>
                <div style="background: rgba(33, 150, 243, 0.1); border-radius: 8px; padding: 12px; border-left: 4px solid #2196f3;">
                    <div style="font-weight: 500; margin-bottom: 4px;">JavaScript</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 4px;">JS-01 | Xona: 101</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 8px;">15 o'quvchi</div>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: var(--gemini-blue);">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div></div>
                <div style="background: rgba(33, 150, 243, 0.1); border-radius: 8px; padding: 12px; border-left: 4px solid #2196f3;">
                    <div style="font-weight: 500; margin-bottom: 4px;">JavaScript</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 4px;">JS-01 | Xona: 101</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 8px;">15 o'quvchi</div>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: var(--gemini-blue);">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div></div>
                <div></div>
            </div>
            <div style="display: grid; grid-template-columns: 100px repeat(6, 1fr); gap: 8px; align-items: start; margin-bottom: 8px; min-height: 80px;">
                <div style="font-weight: 500; text-align: center; padding: 8px; background: var(--gemini-bg); border-radius: 4px; display: flex; align-items: center; justify-content: center;">11:00-12:30</div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div style="background: rgba(76, 175, 80, 0.1); border-radius: 8px; padding: 12px; border-left: 4px solid #4caf50;">
                    <div style="font-weight: 500; margin-bottom: 4px;">React</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 4px;">RC-01 | Xona: 102</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 8px;">12 o'quvchi</div>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #4caf50;">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div></div>
            </div>
            <div style="display: grid; grid-template-columns: 100px repeat(6, 1fr); gap: 8px; align-items: start; min-height: 80px;">
                <div style="font-weight: 500; text-align: center; padding: 8px; background: var(--gemini-bg); border-radius: 4px; display: flex; align-items: center; justify-content: center;">14:00-15:30</div>
                <div style="background: rgba(255, 152, 0, 0.1); border-radius: 8px; padding: 12px; border-left: 4px solid #ff9800;">
                    <div style="font-weight: 500; margin-bottom: 4px;">HTML/CSS</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 4px;">WD-02 | Xona: 103</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 8px;">18 o'quvchi</div>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #ff9800;">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div></div>
                <div style="background: rgba(255, 152, 0, 0.1); border-radius: 8px; padding: 12px; border-left: 4px solid #ff9800;">
                    <div style="font-weight: 500; margin-bottom: 4px;">HTML/CSS</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 4px;">WD-02 | Xona: 103</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 8px;">18 o'quvchi</div>
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 12px; background: #ff9800;">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</div>

<div class="gemini-card" style="margin-top: 24px;">
    <h2 class="gemini-card-title">Bugungi Darslar</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
        <div style="background: var(--gemini-surface); border-radius: 8px; padding: 20px; border-left: 4px solid #2196f3;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 500; color: #2196f3;">JavaScript Asoslari</h3>
                <span style="background: rgba(33, 150, 243, 0.1); color: #2196f3; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">Faol</span>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="margin-bottom: 8px;"><strong>Vaqt:</strong> 09:00 - 10:30</div>
                <div style="margin-bottom: 8px;"><strong>Guruh:</strong> JS-01</div>
                <div style="margin-bottom: 8px;"><strong>Xona:</strong> 101</div>
                <div><strong>O'quvchilar:</strong> 15 kishi</div>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('teacher.attendance') }}" class="gemini-btn" style="background: #4caf50; flex: 1; text-align: center; text-decoration: none;">
                    <i class="fas fa-check"></i> Davomat
                </a>
                <button class="gemini-btn" style="background: var(--gemini-blue); flex: 1;">
                    <i class="fas fa-edit"></i> Tahrirlash
                </button>
            </div>
        </div>
        
        <div style="background: var(--gemini-surface); border-radius: 8px; padding: 20px; border-left: 4px solid #4caf50;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 500; color: #4caf50;">React Development</h3>
                <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">Faol</span>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="margin-bottom: 8px;"><strong>Vaqt:</strong> 14:00 - 15:30</div>
                <div style="margin-bottom: 8px;"><strong>Guruh:</strong> RC-01</div>
                <div style="margin-bottom: 8px;"><strong>Xona:</strong> 102</div>
                <div><strong>O'quvchilar:</strong> 12 kishi</div>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('teacher.attendance') }}" class="gemini-btn" style="background: #4caf50; flex: 1; text-align: center; text-decoration: none;">
                    <i class="fas fa-check"></i> Davomat
                </a>
                <button class="gemini-btn" style="background: #4caf50; flex: 1;">
                    <i class="fas fa-edit"></i> Tahrirlash
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Lesson Modal -->
<div class="modal fade" id="addLessonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yangi Dars Qo'shish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Guruh</label>
                        <select class="form-select">
                            <option>JS-01 - JavaScript Asoslari</option>
                            <option>RC-01 - React Development</option>
                            <option>WD-02 - Web Design</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Kun</label>
                                <select class="form-select">
                                    <option>Dushanba</option>
                                    <option>Seshanba</option>
                                    <option>Chorshanba</option>
                                    <option>Payshanba</option>
                                    <option>Juma</option>
                                    <option>Shanba</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Xona</label>
                                <select class="form-select">
                                    <option>101</option>
                                    <option>102</option>
                                    <option>103</option>
                                    <option>201</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Boshlanish vaqti</label>
                                <input type="time" class="form-control" value="09:00">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Tugash vaqti</label>
                                <input type="time" class="form-control" value="10:30">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Dars mavzusi</label>
                        <input type="text" class="form-control" placeholder="Masalan: Variables va Data Types">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary">Saqlash</button>
            </div>
        </div>
    </div>
</div>

<style>
.schedule-table td {
    height: 120px;
    vertical-align: top;
    position: relative;
}

.lesson-card {
    border-radius: 8px;
    min-height: 80px;
}
</style>
@endsection