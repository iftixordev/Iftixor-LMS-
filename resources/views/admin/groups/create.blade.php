@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <h2 class="gemini-card-title">Yangi Guruh Yaratish</h2>
    
    <form method="POST" action="{{ route('admin.groups.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Guruh nomi</label>
                <input type="text" name="name" class="gemini-input" required value="{{ old('name') }}">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Kurs</label>
                <select name="course_id" class="gemini-select" required>
                    <option value="">Kursni tanlang</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">O'qituvchi</label>
                <select name="teacher_id" class="gemini-select" required>
                    <option value="">O'qituvchini tanlang</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Maksimal o'quvchilar</label>
                <input type="number" name="max_students" class="gemini-input" min="1" value="{{ old('max_students', 15) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Boshlanish sanasi</label>
                <input type="date" name="start_date" class="gemini-input" required value="{{ old('start_date') }}">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 500;">Tugash sanasi</label>
                <input type="date" name="end_date" class="gemini-input" required value="{{ old('end_date') }}">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500;">Guruh rasmi</label>
            <input type="file" name="photo" class="gemini-input" accept="image/*">
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.groups.index') }}" class="gemini-btn" style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary);">
                <i class="fas fa-times"></i>
                Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-plus"></i>
                Guruhni Yaratish
            </button>
        </div>
    </form>
</div>
@endsection