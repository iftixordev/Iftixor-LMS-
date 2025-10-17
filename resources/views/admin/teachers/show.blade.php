@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 8px;">{{ $teacher->full_name }}</h1>
            <span style="background: {{ $teacher->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $teacher->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 6px 12px; border-radius: 16px; font-size: 14px; border: 1px solid {{ $teacher->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                {{ $teacher->status == 'active' ? 'Faol' : 'Nofaol' }}
            </span>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="gemini-btn">
                <i class="fas fa-edit"></i> Tahrirlash
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Left Panel -->
        <div>
            <div class="gemini-card" style="margin-bottom: 24px;">
                <div style="display: flex; gap: 24px; align-items: start;">
                    <img src="{{ $teacher->photo_url }}" width="80" height="80" style="border-radius: 50%;" alt="{{ $teacher->full_name }}">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; flex: 1;">
                        <div style="display: grid; gap: 12px;">
                            <div><strong>Ism Familiya:</strong> {{ $teacher->full_name }}</div>
                            <div><strong>Email:</strong> {{ $teacher->email }}</div>
                            <div><strong>Telefon:</strong> {{ $teacher->phone }}</div>
                            <div><strong>Manzil:</strong> {{ $teacher->address }}</div>
                        </div>
                        <div style="display: grid; gap: 12px;">
                            <div><strong>Mutaxassislik:</strong> {{ $teacher->specializations }}</div>
                            <div><strong>Ta'lim:</strong> {{ $teacher->education }}</div>
                            <div><strong>Soatlik maosh:</strong> {{ number_format($teacher->hourly_rate) }} so'm</div>
                            <div><strong>Ishga qabul:</strong> {{ $teacher->hire_date->format('d.m.Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gemini-card">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Tayinlangan Guruhlar</h2>
                @forelse($teacher->groups as $group)
                <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 12px;">
                    <h3 style="font-size: 16px; margin-bottom: 8px; color: var(--gemini-blue);">{{ $group->name }}</h3>
                    <div style="display: grid; gap: 4px; font-size: 14px;">
                        <div><strong>Kurs:</strong> {{ $group->course->name }}</div>
                        <div><strong>O'quvchilar:</strong> {{ $group->students_count ?? 0 }}/{{ $group->max_students }}</div>
                        <div><strong>Muddat:</strong> {{ $group->start_date->format('d.m.Y') }} - {{ $group->end_date->format('d.m.Y') }}</div>
                    </div>
                </div>
                @empty
                <p style="color: var(--gemini-text-secondary); text-align: center; padding: 40px;">Hech qaysi guruhga tayinlanmagan</p>
                @endforelse
            </div>
        </div>

        <!-- Right Panel -->
        <div>
            <div class="gemini-card" style="margin-bottom: 24px;">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Tezkor Amallar</h2>
                <div style="display: grid; gap: 12px;">
                    <a href="{{ route('admin.teachers.workload', $teacher) }}" class="gemini-btn" style="background: #4caf50; color: white;">
                        <i class="fas fa-tasks"></i> Ish Yuklama
                    </a>
                    <a href="{{ route('admin.teachers.salary', $teacher) }}" class="gemini-btn">
                        <i class="fas fa-money-bill"></i> Maosh Boshqaruvi
                    </a>
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="gemini-btn" style="background: #ff9800; color: white;">
                        <i class="fas fa-edit"></i> Ma'lumotlarni Tahrirlash
                    </a>
                </div>
            </div>

            <div class="gemini-card" style="margin-bottom: 24px;">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Faol Yuklamalar</h2>
                @forelse($teacher->workloads()->where('is_active', true)->with('group.course')->get() as $workload)
                <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 6px; padding: 12px; margin-bottom: 8px;">
                    <div style="font-weight: 600; margin-bottom: 4px;">{{ $workload->group->name }}</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); margin-bottom: 4px;">{{ $workload->group->course->name }}</div>
                    <span style="background: rgba(26, 115, 232, 0.1); color: var(--gemini-blue); padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $workload->weekly_hours }} soat/hafta</span>
                </div>
                @empty
                <p style="color: var(--gemini-text-secondary); text-align: center; padding: 20px;">Faol yuklamalar yo'q</p>
                @endforelse
            </div>

            <div class="gemini-card">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Maosh Statistikasi</h2>
                @php
                    $totalWorkload = $teacher->workloads()->where('is_active', true)->sum('weekly_hours') ?? 0;
                    $monthlyHours = $totalWorkload * 4;
                    $monthlyPay = $monthlyHours * $teacher->hourly_rate;
                @endphp
                
                <div style="text-align: center; margin-bottom: 16px;">
                    <div style="font-size: 24px; font-weight: 500; color: #4caf50; margin-bottom: 4px;">{{ number_format($monthlyPay) }} so'm</div>
                    <div style="color: var(--gemini-text-secondary); font-size: 14px;">Taxminiy oylik maosh</div>
                </div>
                
                <div style="border-top: 1px solid var(--gemini-border); padding-top: 16px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; text-align: center;">
                        <div>
                            <div style="font-size: 18px; font-weight: 500; color: var(--gemini-blue);">{{ $totalWorkload }}</div>
                            <div style="font-size: 12px; color: var(--gemini-text-secondary);">Haftalik soatlar</div>
                        </div>
                        <div>
                            <div style="font-size: 18px; font-weight: 500; color: var(--gemini-blue);">{{ $monthlyHours }}</div>
                            <div style="font-size: 12px; color: var(--gemini-text-secondary);">Oylik soatlar</div>
                        </div>
                        <div>
                            <div style="font-size: 18px; font-weight: 500; color: var(--gemini-blue);">{{ $teacher->groups_count }}</div>
                            <div style="font-size: 12px; color: var(--gemini-text-secondary);">Guruhlar</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection