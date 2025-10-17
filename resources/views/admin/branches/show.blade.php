@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">{{ $branch->name }}</h1>
            <p class="gemini-card-subtitle">{{ $branch->address }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="gemini-btn" onclick="editBranch({{ $branch->id }})">
                <i class="fas fa-edit"></i> Tahrirlash
            </button>
            <a href="{{ route('admin.branches.index') }}" class="gemini-btn-secondary">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
        </div>
    </div>

    <div class="gemini-stats">
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #1a73e8, #42a5f5);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ $stats['students_count'] ?? 0 }}</div>
                <div class="gemini-stat-label">O'quvchilar</div>
            </div>
        </div>
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #34a853, #66bb6a);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ $stats['teachers_count'] ?? 0 }}</div>
                <div class="gemini-stat-label">O'qituvchilar</div>
            </div>
        </div>
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #ff9800, #ffb74d);">
                <i class="fas fa-users"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ $stats['groups_count'] ?? 0 }}</div>
                <div class="gemini-stat-label">Guruhlar</div>
            </div>
        </div>
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #9c27b0, #ba68c8);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ number_format($stats['monthly_revenue'] ?? 0) }}</div>
                <div class="gemini-stat-label">Oylik daromad</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-top: 24px;">
        <div class="gemini-card">
            <h2 class="gemini-card-title">Filial ma'lumotlari</h2>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label class="gemini-label">Telefon</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px;">{{ $branch->phone ?? '-' }}</div>
                </div>
                <div>
                    <label class="gemini-label">Menejer</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px;">{{ $branch->manager->name ?? 'Tayinlanmagan' }}</div>
                </div>
                <div>
                    <label class="gemini-label">Holat</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                        <span style="background: {{ $branch->is_active ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)' }}; color: {{ $branch->is_active ? '#4caf50' : '#f44336' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $branch->is_active ? 'Faol' : 'Nofaol' }}
                        </span>
                    </div>
                </div>
                @if($branch->is_main)
                <div>
                    <label class="gemini-label">Tur</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                        <span style="background: var(--gemini-blue); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Asosiy filial</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="gemini-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h2 class="gemini-card-title">So'nggi o'quvchilar</h2>
                <a href="{{ route('admin.students.index') }}" class="gemini-btn" style="font-size: 12px; padding: 6px 12px;">
                    Barchasini ko'rish
                </a>
            </div>
            @if(isset($recent_students) && $recent_students->count() > 0)
                <table class="gemini-table">
                    <thead>
                        <tr>
                            <th>Ism</th>
                            <th>Telefon</th>
                            <th>Holat</th>
                            <th>Qo'shilgan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_students as $student)
                        <tr>
                            <td>{{ $student->full_name ?? $student->first_name . ' ' . $student->last_name }}</td>
                            <td>{{ $student->phone ?? '-' }}</td>
                            <td>
                                <span style="background: {{ ($student->status ?? 'active') == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ ($student->status ?? 'active') == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                    {{ ($student->status ?? 'active') == 'active' ? 'Faol' : 'Nofaol' }}
                                </span>
                            </td>
                            <td>{{ $student->created_at ? $student->created_at->format('d.m.Y') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-user-graduate" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p>O'quvchilar yo'q</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function editBranch(branchId) {
    window.location.href = `/admin/branches/${branchId}/edit`;
}
</script>
@endsection