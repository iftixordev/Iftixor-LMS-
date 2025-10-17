@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 8px;">{{ $course->name }}</h1>
            <div style="display: flex; gap: 12px; align-items: center;">
                <span style="background: {{ $course->isOnline() ? 'rgba(33, 150, 243, 0.1)' : 'rgba(76, 175, 80, 0.1)' }}; color: {{ $course->isOnline() ? '#2196f3' : '#4caf50' }}; padding: 6px 12px; border-radius: 16px; font-size: 14px; border: 1px solid {{ $course->isOnline() ? '#2196f3' : '#4caf50' }};">
                    <i class="fas {{ $course->isOnline() ? 'fa-wifi' : 'fa-chalkboard-teacher' }}"></i>
                    {{ $course->type_display }}
                </span>
                <span style="background: {{ $course->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $course->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 6px 12px; border-radius: 16px; font-size: 14px; border: 1px solid {{ $course->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                    {{ $course->status == 'active' ? 'Faol' : 'Nofaol' }}
                </span>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.courses.edit', $course) }}" class="gemini-btn">
                <i class="fas fa-edit"></i> Tahrirlash
            </a>
            <a href="{{ route('admin.courses.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Main Content -->
        <div>
            <div class="gemini-card" style="margin-bottom: 24px;">
                <div style="display: flex; gap: 24px; align-items: start;">
                    <img src="{{ $course->photo_url }}" width="120" height="120" style="border-radius: 12px;" alt="{{ $course->name }}">
                    <div style="flex: 1;">
                        <h2 style="margin-bottom: 12px;">Kurs haqida</h2>
                        <p style="color: var(--gemini-text-secondary); line-height: 1.6; margin-bottom: 16px;">{{ $course->description }}</p>
                        
                        @if($course->isOnline() && $course->meeting_link)
                        <div style="background: rgba(33, 150, 243, 0.1); padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                            <strong style="color: #2196f3;">
                                <i class="fas fa-video"></i> Online dars havolasi:
                            </strong>
                            <br>
                            <a href="{{ $course->meeting_link }}" target="_blank" style="color: #2196f3; text-decoration: none;">
                                {{ $course->meeting_link }}
                            </a>
                        </div>
                        @endif

                        @if($course->requirements)
                        <div style="background: var(--gemini-bg); padding: 12px; border-radius: 8px;">
                            <strong>Talablar:</strong>
                            <p style="margin: 8px 0 0 0; color: var(--gemini-text-secondary);">{{ $course->requirements }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Course Groups -->
            <div class="gemini-card" style="margin-bottom: 24px;">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Guruhlar</h2>
                @forelse($course->groups as $group)
                <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 8px; padding: 16px; margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="font-size: 16px; margin-bottom: 8px; color: var(--gemini-blue);">{{ $group->name }}</h3>
                            <div style="display: grid; gap: 4px; font-size: 14px;">
                                <div><strong>O'qituvchi:</strong> {{ $group->teacher->full_name ?? 'Tayinlanmagan' }}</div>
                                <div><strong>O'quvchilar:</strong> {{ $group->students_count ?? 0 }}/{{ $group->max_students }}</div>
                                <div><strong>Muddat:</strong> {{ $group->start_date->format('d.m.Y') }} - {{ $group->end_date->format('d.m.Y') }}</div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.groups.show', $group) }}" class="gemini-btn" style="padding: 8px 16px; font-size: 14px;">
                                <i class="fas fa-eye"></i> Ko'rish
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <p style="color: var(--gemini-text-secondary); text-align: center; padding: 40px;">Hech qaysi guruh yaratilmagan</p>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="gemini-card" style="margin-bottom: 24px;">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Kurs ma'lumotlari</h2>
                <div style="display: grid; gap: 12px; font-size: 14px;">
                    <div><strong>Narxi:</strong> {{ number_format($course->price) }} so'm</div>
                    <div><strong>Davomiyligi:</strong> {{ $course->duration_months }} oy</div>
                    <div><strong>Max o'quvchilar:</strong> {{ $course->max_students }} kishi</div>
                    <div><strong>Turi:</strong> {{ $course->type_display }}</div>
                    @if($course->isOnline())
                    <div><strong>Format:</strong> <span style="color: #2196f3;">Masofaviy ta'lim</span></div>
                    @else
                    <div><strong>Format:</strong> <span style="color: #4caf50;">Yuzma-yuz darslar</span></div>
                    @endif
                </div>
            </div>

            <div class="gemini-card" style="margin-bottom: 24px;">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Tezkor amallar</h2>
                <div style="display: grid; gap: 12px;">
                    <a href="{{ route('admin.groups.create') }}?course_id={{ $course->id }}" class="gemini-btn" style="background: #4caf50; color: white;">
                        <i class="fas fa-plus"></i> Yangi guruh
                    </a>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="gemini-btn" style="background: #ff9800; color: white;">
                        <i class="fas fa-edit"></i> Kursni tahrirlash
                    </a>
                    @if($course->isOnline())
                    <a href="{{ $course->meeting_link }}" target="_blank" class="gemini-btn" style="background: #2196f3; color: white;">
                        <i class="fas fa-video"></i> Darsga qo'shilish
                    </a>
                    @endif
                </div>
            </div>

            <div class="gemini-card">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Statistika</h2>
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: 500; color: var(--gemini-blue); margin-bottom: 4px;">{{ $course->groups->count() }}</div>
                    <div style="color: var(--gemini-text-secondary); font-size: 14px; margin-bottom: 16px;">Faol guruhlar</div>
                    
                    <div style="font-size: 24px; font-weight: 500; color: #4caf50; margin-bottom: 4px;">{{ $course->groups->sum('students_count') ?? 0 }}</div>
                    <div style="color: var(--gemini-text-secondary); font-size: 14px;">Jami o'quvchilar</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection