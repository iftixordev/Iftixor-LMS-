@extends('layouts.teacher')

@section('content')

<div class="gemini-card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
        <a href="{{ route('teacher.profile') }}" class="gemini-btn-icon">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="gemini-card-title" style="margin: 0;">Profilni tahrirlash</h1>
            <p class="gemini-card-subtitle" style="margin: 4px 0 0 0;">Shaxsiy ma'lumotlaringizni yangilang</p>
        </div>
    </div>

    <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="text-align: center; margin-bottom: 32px;">
            <img src="{{ Auth::user()->photo_url }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 16px; border: 4px solid var(--gemini-border);">
            <div>
                <label class="gemini-label">Yangi rasm yuklash</label>
                <input type="file" name="photo" class="gemini-input" accept="image/*">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">
            <div>
                <label class="gemini-label">Ism *</label>
                <input type="text" name="first_name" class="gemini-input" value="{{ Auth::user()->first_name }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Familiya *</label>
                <input type="text" name="last_name" class="gemini-input" value="{{ Auth::user()->last_name }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Telefon *</label>
                <input type="text" name="phone" class="gemini-input" value="{{ Auth::user()->phone }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Tug'ilgan sana *</label>
                <input type="date" name="birth_date" class="gemini-input" value="{{ Auth::user()->birth_date?->format('Y-m-d') }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Mutaxassislik</label>
                <input type="text" name="specialization" class="gemini-input" value="{{ Auth::user()->teacher->specialization ?? '' }}" placeholder="Frontend Developer">
            </div>
            
            <div>
                <label class="gemini-label">Tajriba</label>
                <input type="text" name="experience" class="gemini-input" value="{{ Auth::user()->teacher->experience ?? '' }}" placeholder="5 yil">
            </div>
        </div>

        <div style="border-top: 1px solid var(--gemini-border); padding-top: 24px; margin-bottom: 24px;">
            <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 500; color: var(--gemini-text);">Parolni o'zgartirish</h3>
            <p style="margin: 0 0 20px 0; color: var(--gemini-text-secondary); font-size: 14px;">Parolni o'zgartirish ixtiyoriy.</p>

            <div style="margin-bottom: 20px;">
                <label class="gemini-label">Joriy parol</label>
                <input type="password" name="current_password" class="gemini-input">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="gemini-label">Yangi parol</label>
                    <input type="password" name="password" class="gemini-input">
                </div>
                
                <div>
                    <label class="gemini-label">Parolni tasdiqlang</label>
                    <input type="password" name="password_confirmation" class="gemini-input">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 12px;">
            <a href="{{ route('teacher.profile') }}" class="gemini-btn" style="background: #6c757d;">
                <i class="fas fa-times"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </form>
</div>
@endsection