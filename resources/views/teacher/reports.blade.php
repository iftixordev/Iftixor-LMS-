@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Hisobotlar va Analitika</h1>
    <p class="gemini-card-subtitle">Guruhlar va o'quvchilar faoliyatini tahlil qiling</p>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Guruh</label>
            <select class="gemini-input">
                <option>Barcha guruhlar</option>
                <option>JS-01 - JavaScript</option>
                <option>RC-01 - React</option>
                <option>WD-02 - Web Design</option>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Davr</label>
            <select class="gemini-input">
                <option>Joriy oy</option>
                <option>O'tgan oy</option>
                <option>Joriy yil</option>
                <option>Boshqa davr</option>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Hisobot turi</label>
            <select class="gemini-input">
                <option>Umumiy hisobot</option>
                <option>Baholar</option>
                <option>Davomat</option>
                <option>Faoliyat</option>
            </select>
        </div>
        <div>
            <button class="gemini-btn" style="background: var(--gemini-blue); width: 100%;">
                <i class="fas fa-chart-bar"></i> Hisobot Olish
            </button>
        </div>
    </div>
</div>

<!-- Overview Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h4>45</h4>
                <small class="text-muted">Jami O'quvchi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-chart-line fa-2x text-success mb-2"></i>
                <h4>82%</h4>
                <small class="text-muted">O'rtacha Baho</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                <h4>89%</h4>
                <small class="text-muted">Davomat</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-tasks fa-2x text-warning mb-2"></i>
                <h4>156</h4>
                <small class="text-muted">Tekshirilgan Vazifa</small>
            </div>
        </div>
    </div>
</div>

<!-- Course Performance -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Guruhlar bo'yicha Taraqqiyot</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Guruh</th>
                                <th>O'quvchilar</th>
                                <th>O'rtacha Baho</th>
                                <th>Davomat</th>
                                <th>Taraqqiyot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>JS-01</strong>
                                    <br><small class="text-muted">JavaScript Asoslari</small>
                                </td>
                                <td>15 kishi</td>
                                <td>
                                    <span class="badge bg-success">85%</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">92%</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: 85%">85%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>RC-01</strong>
                                    <br><small class="text-muted">React Development</small>
                                </td>
                                <td>12 kishi</td>
                                <td>
                                    <span class="badge bg-warning">78%</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">85%</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-warning" style="width: 78%">78%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>WD-02</strong>
                                    <br><small class="text-muted">Web Design</small>
                                </td>
                                <td>18 kishi</td>
                                <td>
                                    <span class="badge bg-success">88%</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">90%</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: 88%">88%</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Problem Students -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">E'tibor Talab Qiluvchi O'quvchilar</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                        <div>
                            <h6 class="mb-1">Sardor Toshev</h6>
                            <small class="text-danger">Davomat: 65%</small>
                        </div>
                        <span class="badge bg-danger">Kam</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                        <div>
                            <h6 class="mb-1">Aziza Rahimova</h6>
                            <small class="text-warning">Baho: 68%</small>
                        </div>
                        <span class="badge bg-warning">O'rtacha</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                        <div>
                            <h6 class="mb-1">Bobur Karimov</h6>
                            <small class="text-info">Vazifa: 2 ta qolgan</small>
                        </div>
                        <span class="badge bg-info">Kechikish</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Activity -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Mening Faoliyatim</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>O'tkazilgan darslar</span>
                        <strong>48</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Tekshirilgan vazifalar</span>
                        <strong>156</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Yuklangan materiallar</span>
                        <strong>23</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Yuborilgan xabarlar</span>
                        <strong>89</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Batafsil Hisobotlar</h6>
                <div class="btn-group">
                    <button class="btn btn-outline-success btn-sm">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-print"></i> Chop etish
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-pie fa-3x text-primary mb-3"></i>
                                <h6>Baholar Tahlili</h6>
                                <p class="text-muted small">Guruhlar bo'yicha baho statistikasi</p>
                                <button class="btn btn-primary btn-sm">Ko'rish</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                                <h6>Davomat Hisoboti</h6>
                                <p class="text-muted small">Oylik davomat statistikasi</p>
                                <button class="btn btn-success btn-sm">Ko'rish</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-user-graduate fa-3x text-info mb-3"></i>
                                <h6>O'quvchilar Taraqqiyoti</h6>
                                <p class="text-muted small">Shaxsiy taraqqiyot hisoboti</p>
                                <button class="btn btn-info btn-sm">Ko'rish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Comparison -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Oylik Taqqoslash</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr'],
        datasets: [{
            label: 'O\'rtacha Baho',
            data: [78, 82, 85, 87],
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }, {
            label: 'Davomat',
            data: [85, 88, 90, 89],
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
</script>
@endsection