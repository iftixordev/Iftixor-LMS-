@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 8px;">{{ $group->name }}</h1>
            <span style="background: {{ $group->status == 'active' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(158, 158, 158, 0.1)' }}; color: {{ $group->status == 'active' ? '#4caf50' : '#9e9e9e' }}; padding: 6px 12px; border-radius: 16px; font-size: 14px; border: 1px solid {{ $group->status == 'active' ? '#4caf50' : '#9e9e9e' }};">
                {{ $group->status == 'active' ? 'Faol' : 'Nofaol' }}
            </span>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.groups.edit', $group) }}" class="gemini-btn" style="background: #ff9800; color: white;">
                <i class="fas fa-edit"></i> Tahrirlash
            </a>
            <a href="{{ route('admin.groups.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Left Panel -->
        <div>
            <div class="gemini-card" style="margin-bottom: 24px;">
                <div style="display: flex; gap: 24px; align-items: start;">
                    <img src="{{ $group->photo_url }}" width="80" height="80" style="border-radius: 8px;" alt="{{ $group->name }}">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; flex: 1;">
                        <div style="display: grid; gap: 12px;">
                            <div><strong>Guruh nomi:</strong> {{ $group->name }}</div>
                            <div><strong>Kurs:</strong> {{ $group->course->name }}</div>
                            <div><strong>O'qituvchi:</strong> {{ $group->teacher->full_name }}</div>
                        </div>
                        <div style="display: grid; gap: 12px;">
                            <div><strong>Boshlanish:</strong> {{ $group->start_date->format('d.m.Y') }}</div>
                            <div><strong>Tugash:</strong> {{ $group->end_date->format('d.m.Y') }}</div>
                            <div><strong>Maksimal o'quvchilar:</strong> {{ $group->max_students }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gemini-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h2 class="gemini-card-title">Guruh o'quvchilari ({{ $group->students->count() }})</h2>
                    <button class="gemini-btn" onclick="showAddStudentModal()">
                        <i class="fas fa-plus"></i> O'quvchi qo'shish
                    </button>
                </div>
                <table class="gemini-table">
                    <thead>
                        <tr>
                            <th>Ism Familiya</th>
                            <th>Telefon</th>
                            <th>Qo'shilgan sana</th>
                            <th>Holat</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($group->students as $student)
                        <tr>
                            <td><strong>{{ $student->full_name }}</strong></td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->pivot->enrolled_date }}</td>
                            <td>
                                <span style="background: rgba(76, 175, 80, 0.1); color: #4caf50; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid #4caf50;">{{ $student->pivot->status }}</span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.groups.remove-student', [$group, $student]) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham chiqarmoqchimisiz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Guruhda o'quvchilar yo'q</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Panel -->
        <div>
            <div class="gemini-card">
                <h2 class="gemini-card-title" style="margin-bottom: 16px;">Dars Jadvali</h2>
                @forelse($group->schedules as $schedule)
                <div style="background: var(--gemini-bg); border: 1px solid var(--gemini-border); border-radius: 6px; padding: 12px; margin-bottom: 8px;">
                    <div style="font-weight: 600; margin-bottom: 4px;">{{ ucfirst($schedule->day_of_week) }}</div>
                    <div style="margin-bottom: 4px;">{{ $schedule->start_time }} - {{ $schedule->end_time }}</div>
                    <small style="color: var(--gemini-text-secondary);">Xona: {{ $schedule->room->name }}</small>
                </div>
                @empty
                <p style="color: var(--gemini-text-secondary); text-align: center; padding: 20px;">Jadval belgilanmagan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--gemini-surface); border: 1px solid var(--gemini-border);">
            <div class="modal-header" style="border-bottom: 1px solid var(--gemini-border);">
                <h5 class="modal-title" style="color: var(--gemini-text-primary);">O'quvchi qo'shish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: var(--gemini-text-primary) == #ffffff ? invert(1) : invert(0);"></button>
            </div>
            <form method="POST" action="{{ route('admin.groups.add-student', $group) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--gemini-text-secondary);">O'quvchini tanlang</label>
                        <select name="student_id" id="studentSelect" class="gemini-input" required>
                            <option value="">O'quvchini qidiring...</option>
                            @foreach(\App\Models\Student::whereDoesntHave('groups', function($q) use ($group) { $q->where('group_id', $group->id); })->limit(50)->get() as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->phone }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--gemini-border);">
                    <button type="button" class="gemini-btn" style="background: var(--gemini-bg);" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="gemini-btn" style="background: var(--gemini-blue);">Qo'shish</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.select2-container--default .select2-dropdown {
    background-color: var(--gemini-surface) !important;
    border: 1px solid var(--gemini-border) !important;
    color: var(--gemini-text-primary) !important;
}
.select2-container--default .select2-results__option {
    background-color: var(--gemini-surface) !important;
    color: var(--gemini-text-primary) !important;
}
.select2-container--default .select2-results__option--highlighted {
    background-color: var(--gemini-hover) !important;
}
.select2-container--default .select2-selection--single {
    background-color: var(--gemini-surface) !important;
    border: 1px solid var(--gemini-border) !important;
    color: var(--gemini-text-primary) !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script>
function showAddStudentModal() {
    $('#addStudentModal').modal('show');
}

$(document).ready(function() {
    $('#studentSelect').select2({
        placeholder: 'O\'quvchini tanlang...',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection