@extends('layouts.student')

@section('page-title', 'Baholar va Statistika')

@section('content')
<!-- Overall Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary">4.2</h3>
                <small class="text-muted">Umumiy GPA</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">85%</h3>
                <small class="text-muted">O'zlashtirish</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">92%</h3>
                <small class="text-muted">Davomat</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">12</h3>
                <small class="text-muted">Topshirilgan vazifa</small>
            </div>
        </div>
    </div>
</div>

<!-- Course Grades -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Kurslar bo'yicha Baholar</h6>
            </div>
            <div class="card-body">
                <!-- JavaScript Course -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">JavaScript Asoslari</h6>
                        <span class="badge bg-success fs-6">A (4.5)</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 90%"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">Testlar</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Variables Test</small>
                                        <small class="text-success">95/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Functions Test</small>
                                        <small class="text-success">88/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>Objects Test</small>
                                        <small class="text-warning">75/100</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">Loyihalar</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Calculator</small>
                                        <small class="text-success">92/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Todo App</small>
                                        <small class="text-success">85/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>Weather App</small>
                                        <small class="text-muted">Kutilayotgan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- React Course -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">React Development</h6>
                        <span class="badge bg-warning fs-6">B+ (3.8)</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 76%"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">Testlar</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Components Test</small>
                                        <small class="text-success">82/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>Hooks Test</small>
                                        <small class="text-warning">78/100</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">Loyihalar</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Blog App</small>
                                        <small class="text-warning">80/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>E-commerce</small>
                                        <small class="text-muted">Jarayonda</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HTML/CSS Course -->
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">HTML/CSS Dizayn</h6>
                        <span class="badge bg-success fs-6">A- (4.2)</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 84%"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">Testlar</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>HTML Test</small>
                                        <small class="text-success">90/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>CSS Test</small>
                                        <small class="text-success">87/100</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title">Loyihalar</h6>
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Portfolio</small>
                                        <small class="text-success">88/100</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>Landing Page</small>
                                        <small class="text-success">85/100</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Progress Chart -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Taraqqiyot Grafigi</h6>
            </div>
            <div class="card-body text-center">
                <canvas id="progressChart" width="200" height="200"></canvas>
                <p class="mt-3 mb-0">Umumiy o'zlashtirish: <strong>85%</strong></p>
            </div>
        </div>

        <!-- Recent Grades -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">So'nggi Baholar</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Variables Test</h6>
                            <small class="text-muted">JavaScript</small>
                        </div>
                        <span class="badge bg-success">95/100</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">Calculator Project</h6>
                            <small class="text-muted">JavaScript</small>
                        </div>
                        <span class="badge bg-success">92/100</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <h6 class="mb-1">CSS Layout</h6>
                            <small class="text-muted">HTML/CSS</small>
                        </div>
                        <span class="badge bg-success">88/100</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('progressChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [85, 15],
            backgroundColor: ['#28a745', '#e9ecef'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endsection