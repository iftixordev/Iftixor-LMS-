@extends('layouts.admin')

@section('page-title', 'O\'qituvchilar Tahlili')

@section('content')
<div class="card">
    <div class="card-header">
        <h6>O'qituvchilar Samaradorlik Tahlili</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>O'qituvchi</th>
                        <th>Guruhlar</th>
                        <th>O'quvchilar</th>
                        <th>Daromad</th>
                        <th>O'rtacha Guruh</th>
                        <th>Yuklanish</th>
                        <th>Samaradorlik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $item['teacher']->photo_url }}" width="40" height="40" class="rounded me-2" alt="{{ $item['teacher']->full_name }}">
                                <div>
                                    <strong>{{ $item['teacher']->full_name }}</strong>
                                    <br><small class="text-muted">{{ $item['teacher']->phone }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary fs-6">{{ $item['groups_count'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info fs-6">{{ $item['students_count'] }}</span>
                        </td>
                        <td class="text-success">
                            <strong>{{ number_format($item['total_revenue']) }}</strong> so'm
                        </td>
                        <td>
                            {{ $item['avg_students_per_group'] }} kishi
                        </td>
                        <td>
                            @php 
                                $workloadPercentage = min(($item['students_count'] / 50) * 100, 100);
                                $workloadColor = $workloadPercentage > 80 ? 'danger' : ($workloadPercentage > 60 ? 'warning' : 'success');
                            @endphp
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-{{ $workloadColor }}" style="width: {{ $workloadPercentage }}%">
                                    {{ round($workloadPercentage) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            @php 
                                $efficiency = $item['students_count'] > 0 ? ($item['total_revenue'] / $item['students_count']) : 0;
                                $efficiencyRating = $efficiency > 500000 ? 'success' : ($efficiency > 300000 ? 'warning' : 'danger');
                            @endphp
                            <span class="badge bg-{{ $efficiencyRating }} fs-6">
                                {{ number_format($efficiency) }} so'm/o'quvchi
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- O'qituvchilar Statistikasi -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-primary">{{ $teachers->count() }}</h4>
                <small>Jami O'qituvchilar</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-success">{{ $teachers->sum('students_count') }}</h4>
                <small>Jami O'quvchilar</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-info">{{ number_format($teachers->avg('avg_students_per_group'), 1) }}</h4>
                <small>O'rtacha Guruh Hajmi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="text-warning">{{ number_format($teachers->sum('total_revenue')) }}</h4>
                <small>Jami Daromad (so'm)</small>
            </div>
        </div>
    </div>
</div>

<!-- Top Performerlar -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Eng Ko'p Daromad Keltirgan</h6>
            </div>
            <div class="card-body">
                @foreach($teachers->sortByDesc('total_revenue')->take(3) as $index => $item)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span class="badge bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'dark') }}">
                            {{ $index + 1 }}
                        </span>
                        {{ $item['teacher']->full_name }}
                    </div>
                    <strong class="text-success">{{ number_format($item['total_revenue']) }} so'm</strong>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Eng Ko'p O'quvchiga Ega</h6>
            </div>
            <div class="card-body">
                @foreach($teachers->sortByDesc('students_count')->take(3) as $index => $item)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span class="badge bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'dark') }}">
                            {{ $index + 1 }}
                        </span>
                        {{ $item['teacher']->full_name }}
                    </div>
                    <strong class="text-info">{{ $item['students_count'] }} o'quvchi</strong>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Tavsiyalar -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6>O'qituvchilar uchun Tavsiyalar</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="text-success">Yuqori Samaradorlik:</h6>
                        <ul>
                            @foreach($teachers->where('students_count', '>', 20)->take(3) as $item)
                                <li>{{ $item['teacher']->full_name }} - {{ $item['students_count'] }} o'quvchi</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-warning">O'rtacha Yuklanish:</h6>
                        <ul>
                            @foreach($teachers->whereBetween('students_count', [10, 20])->take(3) as $item)
                                <li>{{ $item['teacher']->full_name }} - qo'shimcha guruh berish mumkin</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-danger">Kam Yuklanish:</h6>
                        <ul>
                            @foreach($teachers->where('students_count', '<', 10)->take(3) as $item)
                                <li>{{ $item['teacher']->full_name }} - yangi guruhlar kerak</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection