@extends('layouts.admin')

@section('content')
<div class="gemini-card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Guruh Ma'lumotlarini Tahrirlash</h1>
            <p class="gemini-card-subtitle">{{ $group->name }} guruhini yangilang</p>
        </div>
        <form method="POST" action="{{ route('admin.groups.destroy', $group) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="gemini-btn" style="background: #f44336; color: white;">
                <i class="fas fa-trash"></i> O'chirish
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.groups.update', $group) }}" enctype="multipart/form-data" style="display: grid; gap: 24px;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Guruh nomi</label>
                <input type="text" name="name" class="gemini-input" value="{{ $group->name }}" required>
            </div>
            <div>
                <label class="gemini-label">Kurs</label>
                <select name="course_id" class="gemini-input" required>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $group->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="gemini-label">Guruh rasmi</label>
                <input type="file" name="photo" class="gemini-input" accept="image/*">
                @if($group->photo)
                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                        <img src="{{ $group->photo_url }}" width="30" height="30" style="border-radius: 4px;">
                        <small style="color: var(--gemini-text-secondary);">Joriy rasm</small>
                    </div>
                @endif
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">O'qituvchi</label>
                <select name="teacher_id" class="gemini-input" required>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $group->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="gemini-label">Maksimal o'quvchilar</label>
                <input type="number" name="max_students" class="gemini-input" value="{{ $group->max_students }}" min="1" required>
            </div>
            <div>
                <label class="gemini-label">Holat</label>
                <select name="status" class="gemini-input" required>
                    <option value="active" {{ $group->status == 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ $group->status == 'inactive' ? 'selected' : '' }}>Nofaol</option>
                    <option value="completed" {{ $group->status == 'completed' ? 'selected' : '' }}>Tugallangan</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Boshlanish sanasi</label>
                <input type="date" name="start_date" class="gemini-input" value="{{ $group->start_date->format('Y-m-d') }}" required>
            </div>
            <div>
                <label class="gemini-label">Tugash sanasi</label>
                <input type="date" name="end_date" class="gemini-input" value="{{ $group->end_date->format('Y-m-d') }}" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 12px;">
            <a href="{{ route('admin.groups.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </form>
</div>
@endsection