@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 24px;">
        <h1 class="gemini-card-title">Kurs Arizalari</h1>
        <select class="gemini-input" style="width: auto;" onchange="filterApplications(this.value)">
            <option value="">Barcha holatlar</option>
            <option value="pending">Kutilmoqda</option>
            <option value="approved">Tasdiqlangan</option>
            <option value="rejected">Rad etilgan</option>
        </select>
    </div>

    <table class="gemini-table">
        <thead>
            <tr>
                <th>O'quvchi</th>
                <th>Kurs</th>
                <th>Sana</th>
                <th>Holat</th>
                <th>Amallar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
            <tr data-status="{{ $application->status }}">
                <td>
                    <div>
                        <strong>{{ $application->student->full_name }}</strong><br>
                        <small style="color: var(--gemini-text-secondary);">{{ $application->student->phone }}</small>
                    </div>
                </td>
                <td>{{ $application->course->name }}</td>
                <td>{{ $application->applied_at->format('d.m.Y') }}</td>
                <td>
                    <span style="background: {{ $application->status == 'pending' ? 'rgba(255, 193, 7, 0.1)' : ($application->status == 'approved' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)') }}; color: {{ $application->status == 'pending' ? '#ff9800' : ($application->status == 'approved' ? '#4caf50' : '#f44336') }}; padding: 4px 8px; border-radius: 4px; font-size: 12px; border: 1px solid {{ $application->status == 'pending' ? '#ff9800' : ($application->status == 'approved' ? '#4caf50' : '#f44336') }};">
                        {{ $application->status == 'pending' ? 'Kutilmoqda' : ($application->status == 'approved' ? 'Tasdiqlangan' : 'Rad etilgan') }}
                    </span>
                </td>
                <td>
                    @if($application->status == 'pending')
                    <div style="display: flex; gap: 8px;">
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50; color: white;" onclick="approveApplication({{ $application->id }})">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336; color: white;" onclick="rejectApplication({{ $application->id }})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @else
                    <small style="color: var(--gemini-text-secondary);">{{ $application->processed_at->format('d.m.Y') }}</small>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">Arizalar topilmadi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function approveApplication(id) {
    if(confirm('Arizani tasdiqlamoqchimisiz?')) {
        fetch(`/admin/courses/applications/${id}/approve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => location.reload());
    }
}

function rejectApplication(id) {
    if(confirm('Arizani rad etmoqchimisiz?')) {
        fetch(`/admin/courses/applications/${id}/reject`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => location.reload());
    }
}

function filterApplications(status) {
    const rows = document.querySelectorAll('tbody tr[data-status]');
    rows.forEach(row => {
        row.style.display = (!status || row.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endsection