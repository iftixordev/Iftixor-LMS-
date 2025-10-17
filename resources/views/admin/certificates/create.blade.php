@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Yangi Sertifikat</h1>
            <p class="gemini-card-subtitle">O'quvchiga sertifikat berish</p>
        </div>
        <a href="{{ route('admin.certificates.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
            <i class="fas fa-arrow-left"></i> Orqaga
        </a>
    </div>

    <form method="POST" action="{{ route('admin.certificates.store') }}">
        @csrf
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label class="form-label">O'quvchi *</label>
                <select name="student_id" class="gemini-input" required>
                    <option value="">O'quvchini tanlang</option>
                    @foreach($students ?? [] as $student)
                    <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->full_name }} ({{ $student->student_id }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Kurs *</label>
                <select name="course_id" class="gemini-input" required>
                    <option value="">Kursni tanlang</option>
                    @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label class="form-label">Shablon</label>
                <select name="template_id" class="gemini-input">
                    <option value="">Standart shablon</option>
                    @foreach($templates ?? [] as $template)
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Baho</label>
                <select name="grade" class="gemini-input">
                    <option value="">Bahoni tanlang</option>
                    <option value="A+">A+ (90-100)</option>
                    <option value="A">A (80-89)</option>
                    <option value="B">B (70-79)</option>
                    <option value="C">C (60-69)</option>
                    <option value="Muvaffaqiyatli">Muvaffaqiyatli</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label">Kursni tugallagan sana *</label>
            <input type="date" name="completion_date" class="gemini-input" value="{{ today()->format('Y-m-d') }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label">Qo'shimcha ma'lumot</label>
            <textarea name="additional_info" class="gemini-input" rows="3" placeholder="Maxsus eslatmalar yoki qo'shimcha ma'lumotlar..."></textarea>
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.certificates.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-times"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-certificate"></i> Sertifikat Yaratish
            </button>
        </div>
    </form>
</div>

<style>
.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--gemini-text);
    font-size: 14px;
}

.gemini-input {
    padding: 12px 16px;
    border: 2px solid var(--gemini-border);
    border-radius: 8px;
    background: var(--gemini-surface);
    color: var(--gemini-text);
    font-size: 14px;
    transition: all 0.2s ease;
}

.gemini-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}
</style>
@endsection