@extends('layouts.admin')

@section('page-title', 'Samaradorlik Hisoboti')

@section('content')
<!-- Samaradorlik Ko'rsatkichlari -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>O'quvchilar O'sishi</h6>
            </div>
            <div class="card-body text-center">
                <h3 class="text-primary">{{ $performance['student_growth']['current'] }}</h3>
                <small>Joriy oy</small>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>O'tgan oy: {{ $performance['student_growth']['previous'] }}</span>
                    @php 
                        $growth = $performance['student_growth']['previous'] > 0 
                            ? (($performance['student_growth']['current'] - $performance['student_growth']['previous']) / $performance['student_growth']['previous']) * 100 
                            : 0;
                    @endphp
                    <span class="badge bg-{{ $growth >= 0 ? 'success' : 'danger' }}">
                        {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Daromad O'sishi</h6>
            </div>
            <div class="card-body text-center">
                <h3 class="text-success">{{ number_format($performance['revenue_growth']['current']) }}</h3>
                <small>Joriy oy (so'm)</small>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>O'tgan oy: {{ number_format($performance['revenue_growth']['previous']) }}</span>
                    @php 
                        $revenueGrowth = $performance['revenue_growth']['previous'] > 0 
                            ? (($performance['revenue_growth']['current'] - $performance['revenue_growth']['previous']) / $performance['revenue_growth']['previous']) * 100 
                            : 0;
                    @endphp
                    <span class="badge bg-{{ $revenueGrowth >= 0 ? 'success' : 'danger' }}">
                        {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Kurs Tugallash</h6>
            </div>
            <div class="card-body text-center">
                <h3 class="text-info">{{ $performance['course_completion']['completed'] }}</h3>
                <small>Tugallangan guruhlar</small>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Faol: {{ $performance['course_completion']['active'] }}</span>
                    @php 
                        $total = $performance['course_completion']['completed'] + $performance['course_completion']['active'];
                        $completionRate = $total > 0 ? ($performance['course_completion']['completed'] / $total) * 100 : 0;
                    @endphp
                    <span class="badge bg-info">{{ number_format($completionRate, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kurslar bo'yicha Tahlil -->
<div class="card">
    <div class="card-header">
        <h6>Kurslar bo'yicha Tahlil</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kurs</th>
                        <th>Guruhlar</th>
                        <th>O'quvchilar</th>
                        <th>Daromad</th>
                        <th>O'rtacha Guruh</th>
                        <th>Samaradorlik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseAnalytics as $item)
                    <tr>
                        <td>
                            <strong>{{ $item['course']->name }}</strong>
                            <br><small class="text-muted">{{ number_format($item['course']->price) }} so'm</small>
                        </td>
                        <td><span class="badge bg-primary">{{ $item['course']->groups_count }}</span></td>
                        <td><span class="badge bg-info">{{ $item['total_students'] }}</span></td>
                        <td class="text-success">{{ number_format($item['total_revenue']) }} so'm</td>
                        <td>{{ $item['avg_group_size'] }} kishi</td>
                        <td>
                            @php 
                                $efficiency = $item['total_revenue'] > 0 ? ($item['total_revenue'] / ($item['course']->price * $item['total_students'])) * 100 : 0;
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $efficiency >= 80 ? 'success' : ($efficiency >= 60 ? 'warning' : 'danger') }}" 
                                     style="width: {{ min($efficiency, 100) }}%">
                                    {{ number_format($efficiency, 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Xulosalar -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6>Tavsiyalar va Xulosalar</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">Ijobiy Tendensiyalar:</h6>
                        <ul>
                            @if($performance['student_growth']['current'] > $performance['student_growth']['previous'])
                                <li>O'quvchilar soni o'sib bormoqda</li>
                            @endif
                            @if($performance['revenue_growth']['current'] > $performance['revenue_growth']['previous'])
                                <li>Daromad o'sib bormoqda</li>
                            @endif
                            @if($courseAnalytics->where('total_students', '>', 0)->count() > 0)
                                <li>Kurslar faol ishlamoqda</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-warning">Yaxshilash Kerak:</h6>
                        <ul>
                            @if($performance['student_growth']['current'] <= $performance['student_growth']['previous'])
                                <li>O'quvchilar jalb qilishni kuchaytirish</li>
                            @endif
                            @if($performance['revenue_growth']['current'] <= $performance['revenue_growth']['previous'])
                                <li>Moliyaviy samaradorlikni oshirish</li>
                            @endif
                            @if($courseAnalytics->where('avg_group_size', '<', 10)->count() > 0)
                                <li>Guruh to'ldirishni yaxshilash</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection