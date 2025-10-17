@extends('layouts.admin')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Davomat Boshqaruvi</h1>
    <p class="gemini-card-subtitle">Guruh va sana bo'yicha o'quvchilar davomatini oling</p>
</div>

<div class="gemini-card" style="margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.attendance.index') }}" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 16px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Guruh</label>
            <select name="group_id" class="gemini-input" required>
                <option value="">Guruhni tanlang</option>
                @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                    {{ $group->name }} - {{ $group->course->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 500; color: var(--gemini-text-secondary);">Sana</label>
            <input type="date" name="date" class="gemini-input" value="{{ $selectedDate }}">
        </div>
        <button type="submit" class="gemini-btn" style="background: var(--gemini-blue);">
            <i class="fas fa-search"></i> Ko'rish
        </button>
    </form>
</div>

@if($selectedGroup)
<div class="gemini-card">
    <form method="POST" action="{{ route('admin.attendance.store') }}">
        @csrf
        <input type="hidden" name="group_id" value="{{ $selectedGroup->id }}">
        <input type="hidden" name="date" value="{{ $selectedDate }}">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h2 style="margin: 0; font-size: 20px; font-weight: 500;">{{ $selectedGroup->name }}</h2>
                <p style="margin: 4px 0 0 0; color: var(--gemini-text-secondary);">{{ \Carbon\Carbon::parse(request('date', today()))->format('d.m.Y') }} - {{ $selectedGroup->students->count() }} o'quvchi</p>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="gemini-btn" style="background: #4caf50;" onclick="markAll('present')">
                    <i class="fas fa-check"></i> Barchasi Keldi
                </button>
                <button type="button" class="gemini-btn" style="background: #f44336;" onclick="markAll('absent')">
                    <i class="fas fa-times"></i> Barchasi Kelmadi
                </button>
                <button type="submit" class="gemini-btn" style="background: var(--gemini-blue);">
                    <i class="fas fa-save"></i> Saqlash
                </button>
            </div>
        </div>

        <div style="display: grid; gap: 12px;">
            @foreach($selectedGroup->students as $student)
            @php
                $currentAttendance = $attendances->get($student->id);
                $status = $currentAttendance ? $currentAttendance->status : 'present';
            @endphp
            <div style="display: grid; grid-template-columns: 200px 1fr; gap: 16px; align-items: center; padding: 16px; background: var(--gemini-bg); border-radius: 8px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ $student->photo_url }}" width="40" height="40" style="border-radius: 50%;" alt="{{ $student->full_name }}">
                    <div>
                        <div style="font-weight: 500;">{{ $student->full_name }}</div>
                        <div style="font-size: 12px; color: var(--gemini-text-secondary);">{{ $student->student_id }}</div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="attendances[{{ $loop->index }}][status]" value="present" 
                               {{ $status == 'present' ? 'checked' : '' }} style="transform: scale(1.3);">
                        <span style="color: #4caf50; font-weight: 500;">Keldi</span>
                        <input type="hidden" name="attendances[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                    </label>
                    
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="attendances[{{ $loop->index }}][status]" value="late" 
                               {{ $status == 'late' ? 'checked' : '' }} style="transform: scale(1.3);">
                        <span style="color: #ff9800; font-weight: 500;">Kech keldi</span>
                    </label>
                    
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="attendances[{{ $loop->index }}][status]" value="absent" 
                               {{ $status == 'absent' ? 'checked' : '' }} style="transform: scale(1.3);">
                        <span style="color: #f44336; font-weight: 500;">Kelmadi</span>
                    </label>
                    
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="attendances[{{ $loop->index }}][status]" value="excused" 
                               {{ $status == 'excused' ? 'checked' : '' }} style="transform: scale(1.3);">
                        <span style="color: #2196f3; font-weight: 500;">Uzrli</span>
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </form>
</div>

<script>
function markAll(status) {
    const radios = document.querySelectorAll(`input[value="${status}"]`);
    radios.forEach(radio => {
        if (radio.type === 'radio') {
            radio.checked = true;
        }
    });
}
}

// Auto-select current weekday if none selected
if (document.querySelectorAll('input[name="days[]"]:checked').length === 0) {
    const today = new Date();
    const dayNames = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const todayName = dayNames[today.getDay()];
    
    const todayCheckbox = document.querySelector(`input[value="${todayName}"]`);
    if (todayCheckbox) {
        todayCheckbox.checked = true;
    }
}
</script>
@endif
@endsection