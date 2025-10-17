@extends('layouts.student')

@section('page-title', 'Kalendar')

@section('content')
<div class="row">
    <!-- Calendar -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Dekabr 2024</h6>
                <div class="btn-group">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm">Bugun</button>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered calendar-table">
                        <thead>
                            <tr class="text-center">
                                <th>Du</th>
                                <th>Se</th>
                                <th>Ch</th>
                                <th>Pa</th>
                                <th>Ju</th>
                                <th>Sh</th>
                                <th>Ya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-muted">25</td>
                                <td class="text-muted">26</td>
                                <td class="text-muted">27</td>
                                <td class="text-muted">28</td>
                                <td class="text-muted">29</td>
                                <td class="text-muted">30</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>3
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>4</td>
                                <td>5
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>6
                                    <div class="event bg-success">React</div>
                                </td>
                                <td>7</td>
                                <td>8</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>10
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>11</td>
                                <td>12
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>13
                                    <div class="event bg-success">React</div>
                                </td>
                                <td>14</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>17
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>18</td>
                                <td>19
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>20
                                    <div class="event bg-success">React</div>
                                    <div class="event bg-warning">Vazifa</div>
                                </td>
                                <td>21</td>
                                <td>22</td>
                            </tr>
                            <tr>
                                <td>23</td>
                                <td class="bg-light">24
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td class="bg-warning bg-opacity-25">25
                                    <div class="event bg-danger">To'lov</div>
                                </td>
                                <td>26
                                    <div class="event bg-primary">JS Dars</div>
                                </td>
                                <td>27
                                    <div class="event bg-success">React</div>
                                </td>
                                <td>28</td>
                                <td>29</td>
                            </tr>
                            <tr>
                                <td>30</td>
                                <td>31</td>
                                <td class="text-muted">1</td>
                                <td class="text-muted">2</td>
                                <td class="text-muted">3</td>
                                <td class="text-muted">4</td>
                                <td class="text-muted">5</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Sidebar -->
    <div class="col-md-4">
        <!-- Today's Events -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Bugungi Tadbirlar</h6>
            </div>
            <div class="card-body">
                <div class="event-item mb-3 p-3 bg-primary bg-opacity-10 rounded">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-primary me-3"></i>
                        <div>
                            <h6 class="mb-1">JavaScript Dars</h6>
                            <small class="text-muted">14:00 - 15:30</small>
                        </div>
                    </div>
                </div>
                
                <div class="event-item mb-3 p-3 bg-success bg-opacity-10 rounded">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-success me-3"></i>
                        <div>
                            <h6 class="mb-1">React Loyiha</h6>
                            <small class="text-muted">16:00 - 17:30</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Yaqin Tadbirlar</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                        <div>
                            <h6 class="mb-1">To'lov Muddati</h6>
                            <small class="text-danger">25.12.2024</small>
                        </div>
                        <span class="badge bg-danger">Muhim</span>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                        <div>
                            <h6 class="mb-1">Vazifa Topshirish</h6>
                            <small class="text-warning">22.12.2024</small>
                        </div>
                        <span class="badge bg-warning">Vazifa</span>
                    </div>
                    
                    <div class="list-group-item d-flex justify-content-between align-items-start px-0">
                        <div>
                            <h6 class="mb-1">Imtihon</h6>
                            <small class="text-info">28.12.2024</small>
                        </div>
                        <span class="badge bg-info">Test</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Event -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Eslatma Qo'shish</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Sarlavha</label>
                        <input type="text" class="form-control" placeholder="Eslatma nomi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sana</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vaqt</label>
                        <input type="time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Turi</label>
                        <select class="form-select">
                            <option>Shaxsiy eslatma</option>
                            <option>Vazifa</option>
                            <option>Uchrashuv</option>
                            <option>Boshqa</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Qo'shish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.calendar-table td {
    height: 100px;
    vertical-align: top;
    position: relative;
    padding: 5px;
}

.event {
    font-size: 10px;
    padding: 2px 4px;
    margin: 1px 0;
    border-radius: 3px;
    color: white;
    text-align: center;
}

.calendar-table td:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}
</style>
@endsection