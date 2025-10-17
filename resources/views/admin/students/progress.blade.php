@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">{{ $student->full_name }} - Progress</h1>
            <p class="gemini-card-subtitle">O'quvchi rivojlanish ko'rsatkichlari</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="gemini-btn">
            <i class="fas fa-arrow-left"></i> Orqaga
        </a>
    </div>

    <!-- Student Info Card -->
    <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <img src="{{ $student->photo_url }}" width="120" height="120" style="border-radius: 50%; border: 3px solid var(--gemini-border);" alt="{{ $student->full_name }}">
            <div style="flex: 1;">
                <h2 style="margin: 0 0 8px 0; color: var(--gemini-text);">{{ $student->full_name }}</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div>
                        <strong>ID:</strong> {{ $student->student_id }}
                    </div>
                    <div>
                        <strong>Telefon:</strong> {{ $student->phone ?? 'N/A' }}
                    </div>
                    <div>
                        <strong>Ro'yxatga olingan:</strong> {{ $student->enrollment_date?->format('d.m.Y') ?? 'N/A' }}
                    </div>
                    <div>
                        <strong>Holat:</strong> 
                        <span style="background: {{ $student->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $student->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $student->status == 'active' ? 'Faol' : 'Nofaol' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 24px;">
        <!-- Attendance Card -->
        <div style="background: linear-gradient(135deg, #2196f3, #21cbf3); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-calendar-check" style="font-size: 24px;"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 600; margin-bottom: 4px;">{{ $attendanceRate }}%</div>
                    <div style="opacity: 0.9;">Davomat ko'rsatkichi</div>
                </div>
            </div>
        </div>

        <!-- Payments Card -->
        <div style="background: linear-gradient(135deg, #4caf50, #8bc34a); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-money-bill-wave" style="font-size: 24px;"></i>
                </div>
                <div>
                    <div style="font-size: 24px; font-weight: 600; margin-bottom: 4px;">{{ number_format($totalPayments) }} so'm</div>
                    <div style="opacity: 0.9;">Jami to'lovlar</div>
                </div>
            </div>
        </div>

        <!-- Coins Card -->
        <div style="background: linear-gradient(135deg, #ff9800, #ffc107); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-coins" style="font-size: 24px;"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 600; margin-bottom: 4px;">{{ $coinBalance }}</div>
                    <div style="opacity: 0.9;">Coin balansi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Groups and Courses -->
    <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
        <h3 style="margin: 0 0 20px 0; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-users" style="color: var(--gemini-blue);"></i>
            Guruhlar va Kurslar
        </h3>
        
        @if($student->groups && $student->groups->count() > 0)
            <div style="display: grid; gap: 16px;">
                @foreach($student->groups as $group)
                <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h4 style="margin: 0 0 8px 0; color: var(--gemini-text);">{{ $group->course->name ?? 'N/A' }}</h4>
                            <p style="margin: 0 0 8px 0; color: var(--gemini-text-secondary);">Guruh: {{ $group->name ?? 'N/A' }}</p>
                            <div style="display: flex; gap: 16px; font-size: 14px;">
                                <span><strong>Boshlanish:</strong> {{ $group->start_date?->format('d.m.Y') ?? 'N/A' }}</span>
                                <span><strong>Tugash:</strong> {{ $group->end_date?->format('d.m.Y') ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <span style="background: rgba(33, 150, 243, 0.1); color: #2196f3; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                            {{ $group->status ?? 'active' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                <i class="fas fa-users" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p>Hech qanday guruhga biriktirilmagan</p>
            </div>
        @endif
    </div>

    <!-- Recent Payments -->
    <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
        <h3 style="margin: 0 0 20px 0; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-credit-card" style="color: var(--gemini-blue);"></i>
            So'nggi To'lovlar
        </h3>
        
        @if($student->payments && $student->payments->count() > 0)
            <div style="overflow-x: auto;">
                <table class="gemini-table">
                    <thead>
                        <tr>
                            <th>Sana</th>
                            <th>Miqdor</th>
                            <th>Turi</th>
                            <th>Holat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->payments->take(10) as $payment)
                        <tr>
                            <td>{{ $payment->created_at?->format('d.m.Y H:i') ?? 'N/A' }}</td>
                            <td><strong>{{ number_format($payment->amount ?? 0) }} so'm</strong></td>
                            <td>{{ $payment->type ?? 'N/A' }}</td>
                            <td>
                                <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                    {{ $payment->status ?? 'completed' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                <i class="fas fa-credit-card" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p>Hech qanday to'lov amalga oshirilmagan</p>
            </div>
        @endif
    </div>

    <!-- Recent Attendance -->
    <div style="background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 12px; padding: 24px;">
        <h3 style="margin: 0 0 20px 0; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-calendar-alt" style="color: var(--gemini-blue);"></i>
            So'nggi Davomat
        </h3>
        
        @if($student->attendances && $student->attendances->count() > 0)
            <div style="overflow-x: auto;">
                <table class="gemini-table">
                    <thead>
                        <tr>
                            <th>Sana</th>
                            <th>Dars</th>
                            <th>Holat</th>
                            <th>Izoh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->attendances->sortByDesc('created_at')->take(10) as $attendance)
                        <tr>
                            <td>{{ $attendance->date?->format('d.m.Y') ?? 'N/A' }}</td>
                            <td>{{ $attendance->subject ?? 'Dars' }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'present' => ['bg' => 'rgba(76, 175, 80, 0.1)', 'color' => '#4caf50', 'text' => 'Keldi'],
                                        'absent' => ['bg' => 'rgba(244, 67, 54, 0.1)', 'color' => '#f44336', 'text' => 'Kelmadi'],
                                        'late' => ['bg' => 'rgba(255, 152, 0, 0.1)', 'color' => '#ff9800', 'text' => 'Kech keldi']
                                    ];
                                    $status = $statusColors[$attendance->status ?? 'absent'] ?? $statusColors['absent'];
                                @endphp
                                <span style="background: {{ $status['bg'] }}; color: {{ $status['color'] }}; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                    {{ $status['text'] }}
                                </span>
                            </td>
                            <td>{{ $attendance->notes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                <i class="fas fa-calendar-alt" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p>Hech qanday davomat ma'lumoti yo'q</p>
            </div>
        @endif
    </div>
</div>
@endsection