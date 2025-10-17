@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Davomat Jurnali</h1>
    <p class="gemini-card-subtitle">O'quvchilar davomatini boshqaring va kuzating</p>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Guruh</label>
            <select class="gemini-input">
                <option>JS-01 - JavaScript Asoslari</option>
                <option>RC-01 - React Development</option>
                <option>WD-02 - Web Design</option>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Sana</label>
            <input type="date" class="gemini-input" value="{{ date('Y-m-d') }}">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Dars vaqti</label>
            <select class="gemini-input">
                <option>09:00 - 10:30</option>
                <option>11:00 - 12:30</option>
                <option>14:00 - 15:30</option>
            </select>
        </div>
        <div>
            <button class="gemini-btn" style="background: var(--gemini-blue); width: 100%;">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </div>
</div>

<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 class="gemini-card-title" style="margin: 0;">JS-01 Guruh - 24.12.2024 - 09:00-10:30</h2>
        <div style="display: flex; gap: 8px;">
            <button class="gemini-btn" style="background: #4caf50; font-size: 12px; padding: 8px 12px;" onclick="markAll('present')">
                <i class="fas fa-check"></i> Barchasi Keldi
            </button>
            <button class="gemini-btn" style="background: #f44336; font-size: 12px; padding: 8px 12px;" onclick="markAll('absent')">
                <i class="fas fa-times"></i> Barchasi Kelmadi
            </button>
        </div>
    </div>
    
    <div style="display: grid; gap: 16px;">
        <div style="display: grid; grid-template-columns: 200px 1fr 120px 150px 60px; gap: 16px; align-items: center; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
                <div>
                    <div style="font-weight: 500; margin-bottom: 2px;">Ali Valiyev</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary);">ID: STU001</div>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <input type="radio" class="btn-check" name="attendance_1" id="present_1" checked>
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;" for="present_1">
                    <i class="fas fa-check"></i> Keldi
                </label>
                
                <input type="radio" class="btn-check" name="attendance_1" id="late_1">
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #ff9800;" for="late_1">
                    <i class="fas fa-clock"></i> Kechikdi
                </label>
                
                <input type="radio" class="btn-check" name="attendance_1" id="absent_1">
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336;" for="absent_1">
                    <i class="fas fa-times"></i> Kelmadi
                </label>
            </div>
            <input type="time" class="gemini-input" value="09:00" style="font-size: 14px;">
            <input type="text" class="gemini-input" placeholder="Izoh..." style="font-size: 14px;">
            <button class="gemini-btn" style="padding: 8px; background: var(--gemini-blue);">
                <i class="fas fa-chart-line"></i>
            </button>
        </div>
                    
        <div style="display: grid; grid-template-columns: 200px 1fr 120px 150px 60px; gap: 16px; align-items: center; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
                <div>
                    <div style="font-weight: 500; margin-bottom: 2px;">Malika Karimova</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary);">ID: STU002</div>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <input type="radio" class="btn-check" name="attendance_2" id="present_2">
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;" for="present_2">
                    <i class="fas fa-check"></i> Keldi
                </label>
                
                <input type="radio" class="btn-check" name="attendance_2" id="late_2" checked>
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #ff9800;" for="late_2">
                    <i class="fas fa-clock"></i> Kechikdi
                </label>
                
                <input type="radio" class="btn-check" name="attendance_2" id="absent_2">
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336;" for="absent_2">
                    <i class="fas fa-times"></i> Kelmadi
                </label>
            </div>
            <input type="time" class="gemini-input" value="09:15" style="font-size: 14px;">
            <input type="text" class="gemini-input" value="Transport muammosi" style="font-size: 14px;">
            <button class="gemini-btn" style="padding: 8px; background: var(--gemini-blue);">
                <i class="fas fa-chart-line"></i>
            </button>
        </div>
                    
        <div style="display: grid; grid-template-columns: 200px 1fr 120px 150px 60px; gap: 16px; align-items: center; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="/images/default-user.svg" width="40" height="40" style="border-radius: 50%;" alt="Student">
                <div>
                    <div style="font-weight: 500; margin-bottom: 2px;">Sardor Toshev</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary);">ID: STU003</div>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <input type="radio" class="btn-check" name="attendance_3" id="present_3">
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;" for="present_3">
                    <i class="fas fa-check"></i> Keldi
                </label>
                
                <input type="radio" class="btn-check" name="attendance_3" id="late_3">
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #ff9800;" for="late_3">
                    <i class="fas fa-clock"></i> Kechikdi
                </label>
                
                <input type="radio" class="btn-check" name="attendance_3" id="absent_3" checked>
                <label class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336;" for="absent_3">
                    <i class="fas fa-times"></i> Kelmadi
                </label>
            </div>
            <input type="time" class="gemini-input" disabled style="font-size: 14px; opacity: 0.5;">
            <input type="text" class="gemini-input" value="Kasallik" style="font-size: 14px;">
            <button class="gemini-btn" style="padding: 8px; background: var(--gemini-blue);">
                <i class="fas fa-chart-line"></i>
            </button>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-top: 24px;">
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196f3;">
            <i class="fas fa-users"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number">15</div>
            <div class="gemini-stat-label">Jami O'quvchi</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(76, 175, 80, 0.1); color: #4caf50;">
            <i class="fas fa-check"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #4caf50;">12</div>
            <div class="gemini-stat-label">Kelgan</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(255, 152, 0, 0.1); color: #ff9800;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #ff9800;">2</div>
            <div class="gemini-stat-label">Kechikkan</div>
        </div>
    </div>
    
    <div class="gemini-stat-card">
        <div class="gemini-stat-icon" style="background: rgba(244, 67, 54, 0.1); color: #f44336;">
            <i class="fas fa-times"></i>
        </div>
        <div class="gemini-stat-content">
            <div class="gemini-stat-number" style="color: #f44336;">1</div>
            <div class="gemini-stat-label">Kelmagan</div>
        </div>
    </div>
</div>

<!-- Monthly Attendance -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0">Oylik Davomat Statistikasi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>O'quvchi</th>
                        <th>Jami Dars</th>
                        <th>Kelgan</th>
                        <th>Kechikkan</th>
                        <th>Kelmagan</th>
                        <th>Foiz</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ali Valiyev</td>
                        <td>20</td>
                        <td class="text-success">19</td>
                        <td class="text-warning">1</td>
                        <td class="text-danger">0</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" style="width: 95%">95%</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Malika Karimova</td>
                        <td>20</td>
                        <td class="text-success">17</td>
                        <td class="text-warning">2</td>
                        <td class="text-danger">1</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-warning" style="width: 85%">85%</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Sardor Toshev</td>
                        <td>20</td>
                        <td class="text-success">15</td>
                        <td class="text-warning">1</td>
                        <td class="text-danger">4</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-danger" style="width: 75%">75%</div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function markAll(status) {
    const radios = document.querySelectorAll(`input[id*="${status}"]`);
    radios.forEach(radio => {
        radio.checked = true;
    });
}
</script>
@endsection