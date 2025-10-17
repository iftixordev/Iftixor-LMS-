@extends('layouts.admin')

@section('content')

<div class="gemini-card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
        <a href="{{ route('admin.profile') }}" class="gemini-btn-icon">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="gemini-card-title" style="margin: 0;">Profilni tahrirlash</h1>
            <p class="gemini-card-subtitle" style="margin: 4px 0 0 0;">Shaxsiy ma'lumotlaringizni yangilang</p>
        </div>
    </div>

    @if ($errors->any())
        <div style="background: #ffebee; color: #c62828; padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #f44336;">
            <h4 style="margin: 0 0 8px 0;">Xatoliklar:</h4>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Current Photo -->
        <div style="text-align: center; margin-bottom: 32px;">
            <img src="{{ $user->photo_url }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 16px; border: 4px solid var(--gemini-border);">
            <div>
                <label class="gemini-label">Yangi rasm yuklash</label>
                <input type="file" name="photo" class="gemini-input" accept="image/*">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">
            <div>
                <label class="gemini-label">Ism *</label>
                <input type="text" name="first_name" class="gemini-input" value="{{ old('first_name', $user->first_name) }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Familiya *</label>
                <input type="text" name="last_name" class="gemini-input" value="{{ old('last_name', $user->last_name) }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Telefon *</label>
                <input type="text" name="phone" class="gemini-input" value="{{ old('phone', $user->phone) }}" required>
            </div>
            
            <div>
                <label class="gemini-label">Tug'ilgan sana *</label>
                <input type="date" name="birth_date" class="gemini-input" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" required>
            </div>
        </div>

        <div style="border-top: 1px solid var(--gemini-border); padding-top: 24px; margin-bottom: 24px;">
            <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 500; color: var(--gemini-text);">Parolni o'zgartirish</h3>
            <p style="margin: 0 0 20px 0; color: var(--gemini-text-secondary); font-size: 14px;">Parolni o'zgartirish ixtiyoriy. Agar o'zgartirmoqchi bo'lmasangiz, bo'sh qoldiring.</p>

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
                    <label class="gemini-label">Yangi parolni tasdiqlang</label>
                    <input type="password" name="password_confirmation" class="gemini-input">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 12px;">
            <a href="{{ route('admin.profile') }}" class="gemini-btn" style="background: #6c757d;">
                <i class="fas fa-times"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </form>
</div>
@endsection