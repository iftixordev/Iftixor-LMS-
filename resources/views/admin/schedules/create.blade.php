@extends('layouts.admin')

@section('content')
<div class="gemini-form-container">
    <div class="gemini-form-card">
        <div class="gemini-form-header">
            <h1 class="gemini-form-title">Yangi Jadval</h1>
            <p class="gemini-form-subtitle">Guruh uchun dars jadvalini yarating</p>
        </div>

        <form action="{{ route('admin.schedules.store') }}" method="POST" class="gemini-form-grid">
            @csrf
            
            <div class="gemini-form-section">
                <div class="gemini-form-group">
                    <label class="gemini-label">Guruh *</label>
                    <select name="group_id" class="gemini-select" required>
                        <option value="">Guruhni tanlang</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }} - {{ $group->course->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">O'qituvchi *</label>
                    <select name="teacher_id" class="gemini-select" required>
                        <option value="">O'qituvchini tanlang</option>
                        @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Kun *</label>
                    <select name="day_of_week" class="gemini-select" required>
                        <option value="">Kunni tanlang</option>
                        <option value="monday">Dushanba</option>
                        <option value="tuesday">Seshanba</option>
                        <option value="wednesday">Chorshanba</option>
                        <option value="thursday">Payshanba</option>
                        <option value="friday">Juma</option>
                        <option value="saturday">Shanba</option>
                        <option value="sunday">Yakshanba</option>
                    </select>
                </div>
                
                <div class="gemini-form-row">
                    <div class="gemini-form-group">
                        <label class="gemini-label">Boshlanish vaqti *</label>
                        <input type="time" name="start_time" class="gemini-input" required>
                    </div>
                    
                    <div class="gemini-form-group">
                        <label class="gemini-label">Tugash vaqti *</label>
                        <input type="time" name="end_time" class="gemini-input" required>
                    </div>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Xona</label>
                    <input type="text" name="room" class="gemini-input" placeholder="Xona raqami yoki nomi">
                </div>
            </div>
            
            <div class="gemini-form-actions">
                <a href="{{ route('admin.schedules.index') }}" class="gemini-btn-secondary">
                    <i class="fas fa-times"></i> Bekor qilish
                </a>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-save"></i> Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
@endsection