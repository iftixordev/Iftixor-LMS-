@extends('layouts.admin')

@section('content')
<div class="gemini-stats">
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ $stats['total_students'] }}</div>
        <div class="gemini-stat-label">O'quvchilar</div>
    </div>
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ $stats['total_teachers'] }}</div>
        <div class="gemini-stat-label">O'qituvchilar</div>
    </div>
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ $stats['total_courses'] }}</div>
        <div class="gemini-stat-label">Kurslar</div>
    </div>
    <div class="gemini-stat-card">
        <div class="gemini-stat-number">{{ number_format($stats['monthly_revenue']) }}</div>
        <div class="gemini-stat-label">Oylik Daromad</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    <div class="gemini-card">
        <h2 class="gemini-card-title">Eng Mashhur Kurslar</h2>
        <table class="gemini-table">
            <thead>
                <tr>
                    <th>Kurs</th>
                    <th>Guruhlar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($popularCourses as $course)
                <tr>
                    <td>{{ $course->name }}</td>
                    <td><span style="background: rgba(26, 115, 232, 0.1); color: var(--gemini-blue); padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $course->groups_count }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="gemini-card">
        <h2 class="gemini-card-title">Lead Konversiya</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; text-align: center;">
            <div>
                <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $leadStats['total_leads'] }}</div>
                <div style="font-size: 12px; color: var(--gemini-text-secondary);">Jami Leadlar</div>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 500; color: #4caf50;">{{ $leadStats['enrolled_leads'] }}</div>
                <div style="font-size: 12px; color: var(--gemini-text-secondary);">Ro'yxatdan o'tgan</div>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue);">{{ $leadStats['conversion_rate'] }}%</div>
                <div style="font-size: 12px; color: var(--gemini-text-secondary);">Konversiya</div>
            </div>
        </div>
    </div>
</div>

<div class="gemini-card">
    <h2 class="gemini-card-title">O'qituvchilar Yuklama</h2>
    <table class="gemini-table">
        <thead>
            <tr>
                <th>O'qituvchi</th>
                <th>Guruhlar</th>
                <th>O'quvchilar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teacherWorkload->take(5) as $item)
            <tr>
                <td>{{ $item['teacher']->full_name }}</td>
                <td><span style="background: rgba(26, 115, 232, 0.1); color: var(--gemini-blue); padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $item['groups_count'] }}</span></td>
                <td><span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $item['students_count'] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="gemini-card">
    <h2 class="gemini-card-title">Hisobot Turlari</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <a href="{{ route('admin.reports.performance') }}" class="gemini-btn" style="text-align: center; padding: 20px;">
            <i class="fas fa-chart-line" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
            Samaradorlik
        </a>
        <a href="{{ route('admin.reports.teachers') }}" class="gemini-btn" style="text-align: center; padding: 20px;">
            <i class="fas fa-chalkboard-teacher" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
            O'qituvchilar
        </a>
        <a href="{{ route('admin.reports.students') }}" class="gemini-btn" style="text-align: center; padding: 20px;">
            <i class="fas fa-user-graduate" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
            O'quvchilar
        </a>
        <a href="{{ route('admin.reports.finance') }}" class="gemini-btn" style="text-align: center; padding: 20px;">
            <i class="fas fa-dollar-sign" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
            Moliya
        </a>
    </div>
</div>
@endsection