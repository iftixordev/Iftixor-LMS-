@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title">Dars Jadvali</h1>
            <p class="gemini-card-subtitle">Guruhlar uchun dars jadvalini boshqaring</p>
        </div>
        <button class="gemini-btn" onclick="openScheduleModal()" id="addScheduleBtn">
            <i class="fas fa-plus"></i> Yangi jadval
        </button>
    </div>

    <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 16px;">
        @php
            $days = [
                'monday' => 'Dushanba',
                'tuesday' => 'Seshanba', 
                'wednesday' => 'Chorshanba',
                'thursday' => 'Payshanba',
                'friday' => 'Juma',
                'saturday' => 'Shanba',
                'sunday' => 'Yakshanba'
            ];
        @endphp
        
        @foreach($days as $dayKey => $dayName)
        <div class="day-column">
            <h3 style="text-align: center; margin-bottom: 16px; padding: 12px; background: var(--gemini-blue); color: white; border-radius: 8px; font-size: 14px;">
                {{ $dayName }}
            </h3>
            
            @php
                $daySchedules = $schedules->where('day_of_week', $dayKey)->sortBy('start_time');
            @endphp
            
            @forelse($daySchedules as $schedule)
            <div class="schedule-item" style="margin-bottom: 12px; padding: 12px; background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px;">
                <div style="font-weight: 500; font-size: 12px; color: var(--gemini-text); margin-bottom: 4px;">
                    {{ $schedule->group->course->name ?? 'N/A' }}
                </div>
                <div style="font-size: 11px; color: var(--gemini-text-secondary); margin-bottom: 4px;">
                    {{ $schedule->teacher->first_name ?? 'N/A' }} {{ $schedule->teacher->last_name ?? '' }}
                </div>
                <div style="font-size: 11px; color: var(--gemini-blue); margin-bottom: 4px;">
                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                </div>
                @if($schedule->room)
                <div style="font-size: 10px; color: var(--gemini-text-secondary);">
                    {{ $schedule->room }}
                </div>
                @endif
                <div style="display: flex; gap: 4px; margin-top: 8px;">
                    <button class="gemini-btn" style="padding: 4px 8px; font-size: 10px;" onclick="editSchedule({{ $schedule->id }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" style="display: inline;" onsubmit="return confirm('O\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="gemini-btn" style="padding: 4px 8px; font-size: 10px; background: #f44336;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 20px; color: var(--gemini-text-secondary); font-size: 12px;">
                Dars yo'q
            </div>
            @endforelse
        </div>
        @endforeach
    </div>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3 id="modalTitle">Yangi Jadval</h3>
            <button onclick="closeScheduleModal()" class="modal-close">&times;</button>
        </div>
        
        <form id="scheduleForm" method="POST" action="{{ route('admin.schedules.store') }}">
            @csrf
            <div class="modal-body">
                <div class="gemini-form-group">
                    <label class="gemini-label">Guruh</label>
                    <select name="group_id" class="gemini-select" required>
                        <option value="">Guruhni tanlang</option>
                        @forelse($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }} @if($group->course) - {{ $group->course->name }}@endif</option>
                        @empty
                        <option disabled>Guruhlar topilmadi</option>
                        @endforelse
                    </select>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">O'qituvchi</label>
                    <select name="teacher_id" class="gemini-select" required>
                        <option value="">O'qituvchini tanlang</option>
                        @forelse($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @empty
                        <option disabled>O'qituvchilar topilmadi</option>
                        @endforelse
                    </select>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Kun</label>
                    <select name="day_of_week" class="gemini-select" required>
                        <option value="">Kunni tanlang</option>
                        @foreach($days as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="gemini-form-group">
                        <label class="gemini-label">Boshlanish vaqti</label>
                        <input type="time" name="start_time" class="gemini-input" required>
                    </div>
                    
                    <div class="gemini-form-group">
                        <label class="gemini-label">Tugash vaqti</label>
                        <input type="time" name="end_time" class="gemini-input" required>
                    </div>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Xona</label>
                    <input type="text" name="room" class="gemini-input" placeholder="Xona raqami">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeScheduleModal()" class="gemini-btn-secondary">Bekor qilish</button>
                <button type="submit" class="gemini-btn">Saqlash</button>
            </div>
        </form>
    </div>
</div>

<style>
.day-column {
    min-height: 400px;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
}

.modal-content {
    background: var(--gemini-surface);
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    border: 1px solid var(--gemini-border);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid var(--gemini-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid var(--gemini-border);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--gemini-text-secondary);
}

@media (max-width: 768px) {
    .day-column {
        grid-column: span 7;
    }
}
</style>

<script>
function openScheduleModal() {
    const modal = document.getElementById('scheduleModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeScheduleModal() {
    const modal = document.getElementById('scheduleModal');
    const form = document.getElementById('scheduleForm');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    if (form) {
        form.reset();
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('scheduleModal');
    if (e.target === modal) {
        closeScheduleModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeScheduleModal();
    }
});

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('addScheduleBtn');
    const modal = document.getElementById('scheduleModal');
    
    if (!btn || !modal) {
        console.error('Modal elements not found');
        return;
    }
    
    // Ensure modal is hidden initially
    modal.style.display = 'none';
});

function editSchedule(id) {
    alert('Edit funksiyasi keyinroq qo\'shiladi');
}
</script>
@endsection