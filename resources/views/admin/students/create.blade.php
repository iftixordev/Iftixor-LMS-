@extends('layouts.admin')

@section('content')
<div class="gemini-form-container">
    <div class="gemini-form-card">
        <div class="gemini-form-header">
            <h1 class="gemini-form-title">Yangi O'quvchi Qo'shish</h1>
            <p class="gemini-form-subtitle">Yangi o'quvchining barcha ma'lumotlarini kiriting</p>
        </div>

        <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="gemini-form-grid">
        @csrf
        
            <div class="gemini-form-row">
                <div>
                    <label class="gemini-label">Ism *</label>
                    <input type="text" name="first_name" class="gemini-input" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <div class="gemini-error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="gemini-label">Familiya *</label>
                    <input type="text" name="last_name" class="gemini-input" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="gemini-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="gemini-form-row">
                <div>
                    <label class="gemini-label">Tug'ilgan sana *</label>
                    <input type="date" name="birth_date" class="gemini-input" value="{{ old('birth_date') }}" required>
                    @error('birth_date')
                        <div class="gemini-error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="gemini-label">Jinsi *</label>
                    <select name="gender" class="gemini-input" required>
                        <option value="">Tanlang</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Erkak</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Ayol</option>
                    </select>
                    @error('gender')
                        <div class="gemini-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="gemini-form-row">
                <div>
                    <label class="gemini-label">Telefon</label>
                    <input type="text" name="phone" class="gemini-input" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="gemini-error">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="gemini-label">Profil rasmi</label>
                    <input type="file" name="photo" class="gemini-input" accept="image/*">
                    @error('photo')
                        <div class="gemini-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label class="gemini-label">Manzil</label>
                <textarea name="address" class="gemini-input" rows="2">{{ old('address') }}</textarea>
                @error('address')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="gemini-form-section">
                <h2 class="gemini-form-section-title">Ota-ona Ma'lumotlari</h2>
                <div class="gemini-form-row">
                    <div>
                        <label class="gemini-label">Ota-ona ismi *</label>
                        <input type="text" name="parent_name" class="gemini-input" value="{{ old('parent_name') }}" required>
                        @error('parent_name')
                            <div class="gemini-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="gemini-label">Ota-ona telefoni *</label>
                        <input type="text" name="parent_phone" class="gemini-input" value="{{ old('parent_phone') }}" required>
                        @error('parent_phone')
                            <div class="gemini-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="gemini-label">Ro'yxatga olingan sana *</label>
                <input type="date" name="enrollment_date" class="gemini-input" value="{{ old('enrollment_date', date('Y-m-d')) }}" required>
                @error('enrollment_date')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="gemini-label">Izohlar</label>
                <textarea name="notes" class="gemini-input" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="gemini-form-actions">
                <a href="{{ route('admin.students.index') }}" class="gemini-btn-secondary">
                    <i class="fas fa-arrow-left"></i> Bekor qilish
                </a>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-save"></i> Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
@endsection