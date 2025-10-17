@extends('layouts.admin')

@section('page-title', 'Ish Yuklama - ' . $teacher->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>{{ $teacher->full_name }} - Ish Yuklama Boshqaruvi</h4>
    <div>
        <a href="{{ route('admin.teachers.salary', $teacher) }}" class="btn btn-info">
            <i class="fas fa-money-bill"></i> Maosh
        </a>
        <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Orqaga
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3>{{ $workloads->where('is_active', true)->sum('weekly_hours') }}</h3>
                <p class="mb-0">Haftalik Soatlar</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3>{{ $workloads->where('is_active', true)->count() }}</h3>
                <p class="mb-0">Faol Guruhlar</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3>{{ number_format($workloads->where('is_active', true)->sum('weekly_hours') * 4 * $teacher->hourly_rate) }}</h3>
                <p class="mb-0">Oylik Maosh (so'm)</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3>{{ $availableGroups->count() }}</h3>
                <p class="mb-0">Mavjud Guruhlar</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Yangi Yuklama Qo'shish</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.teachers.store-workload', $teacher) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Guruh</label>
                        <select name="group_id" class="form-control" required>
                            <option value="">Guruhni tanlang</option>
                            @foreach($availableGroups as $group)
                            <option value="{{ $group->id }}">
                                {{ $group->name }} ({{ $group->course->name }})
                                <small>- {{ $group->students_count }}/{{ $group->max_students }} o'quvchi</small>
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Haftalik Soatlar</label>
                        <input type="number" name="weekly_hours" class="form-control" min="1" max="40" required>
                        <small class="text-muted">Maksimal 40 soat</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Boshlanish Sanasi</label>
                        <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Qo'shimcha ma'lumot"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i> Yuklama Qo'shish
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Yuklama Statistikasi</h5>
            </div>
            <div class="card-body">
                @php
                    $totalActive = $workloads->where('is_active', true)->sum('weekly_hours');
                    $maxCapacity = 40; // Maximum weekly hours
                    $percentage = $maxCapacity > 0 ? ($totalActive / $maxCapacity) * 100 : 0;
                @endphp
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Yuklama darajasi</span>
                        <span>{{ $totalActive }}/{{ $maxCapacity }}h</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-{{ $percentage > 80 ? 'danger' : ($percentage > 60 ? 'warning' : 'success') }}" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                    <small class="text-muted">{{ number_format($percentage, 1) }}% band</small>
                </div>
                
                <hr>
                <p><strong>Soatlik tarif:</strong> {{ number_format($teacher->hourly_rate) }} so'm</p>
                <p><strong>Kunlik o'rtacha:</strong> {{ number_format($totalActive / 7, 1) }} soat</p>
                <p><strong>Oylik daromad:</strong> {{ number_format($totalActive * 4 * $teacher->hourly_rate) }} so'm</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Joriy Yuklamalar</h5>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="toggleHistory()">
                        <i class="fas fa-history"></i> Tarix
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Guruh</th>
                                <th>Kurs</th>
                                <th>Haftalik Soatlar</th>
                                <th>Boshlanish</th>
                                <th>Tugash</th>
                                <th>Holat</th>
                                <th>Amallar</th>
                            </tr>
                        </thead>
                        <tbody id="activeWorkloads">
                            @forelse($workloads->where('is_active', true) as $workload)
                            <tr>
                                <td>
                                    <strong>{{ $workload->group->name }}</strong>
                                    <br><small class="text-muted">{{ $workload->group->students_count ?? 0 }} o'quvchi</small>
                                </td>
                                <td>{{ $workload->group->course->name }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $workload->weekly_hours }}h</span>
                                </td>
                                <td>{{ $workload->start_date->format('d.m.Y') }}</td>
                                <td>{{ $workload->end_date ? $workload->end_date->format('d.m.Y') : 'Davom etmoqda' }}</td>
                                <td>
                                    <span class="badge bg-success">Faol</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#workloadModal{{ $workload->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.teachers.end-workload', [$teacher, $workload]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Yuklamani tugatishni xohlaysizmi?')">
                                            <i class="fas fa-stop"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Workload Details Modal -->
                            <div class="modal fade" id="workloadModal{{ $workload->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yuklama Tafsilotlari</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p><strong>Guruh:</strong></p>
                                                    <p><strong>Kurs:</strong></p>
                                                    <p><strong>Haftalik soatlar:</strong></p>
                                                    <p><strong>Boshlanish:</strong></p>
                                                    <p><strong>Oylik maosh:</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <p>{{ $workload->group->name }}</p>
                                                    <p>{{ $workload->group->course->name }}</p>
                                                    <p>{{ $workload->weekly_hours }} soat</p>
                                                    <p>{{ $workload->start_date->format('d.m.Y') }}</p>
                                                    <p class="text-success">{{ number_format($workload->weekly_hours * 4 * $teacher->hourly_rate) }} so'm</p>
                                                </div>
                                            </div>
                                            @if($workload->notes)
                                            <div class="mt-3">
                                                <strong>Izoh:</strong>
                                                <p>{{ $workload->notes }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Faol yuklamalar topilmadi</td>
                            </tr>
                            @endforelse
                        </tbody>
                        
                        <tbody id="historyWorkloads" style="display: none;">
                            @foreach($workloads->where('is_active', false) as $workload)
                            <tr class="table-secondary">
                                <td>{{ $workload->group->name }}</td>
                                <td>{{ $workload->group->course->name }}</td>
                                <td>{{ $workload->weekly_hours }}h</td>
                                <td>{{ $workload->start_date->format('d.m.Y') }}</td>
                                <td>{{ $workload->end_date ? $workload->end_date->format('d.m.Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-secondary">Tugagan</span>
                                </td>
                                <td>-</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleHistory() {
    const active = document.getElementById('activeWorkloads');
    const history = document.getElementById('historyWorkloads');
    
    if (history.style.display === 'none') {
        active.style.display = 'none';
        history.style.display = 'table-row-group';
    } else {
        active.style.display = 'table-row-group';
        history.style.display = 'none';
    }
}
</script>
@endsection