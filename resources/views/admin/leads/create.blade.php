@extends('layouts.admin')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div class="gemini-card" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border: none;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--gemini-border);">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4285f4, #34a853); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(66, 133, 244, 0.3);">
                <i class="fas fa-user-plus" style="color: white; font-size: 20px;"></i>
            </div>
            <div>
                <h1 style="margin: 0; font-size: 28px; font-weight: 400; color: var(--gemini-text); font-family: 'Google Sans', sans-serif;">Yangi Potensial Mijoz</h1>
                <p style="margin: 4px 0 0 0; color: var(--gemini-text-secondary); font-size: 14px;">Yangi mijoz ma'lumotlarini kiriting</p>
            </div>
        </div>

    <form method="POST" action="{{ route('admin.leads.store') }}" style="max-width: 800px;">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="gemini-form-group">
                <label class="gemini-label" style="font-weight: 500; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user" style="color: var(--gemini-blue); font-size: 14px;"></i>
                    Ism *
                </label>
                <input type="text" name="first_name" class="gemini-input @error('first_name') error @enderror" value="{{ old('first_name') }}" required placeholder="Ismingizni kiriting" style="padding: 16px; border-radius: 12px; font-size: 16px;">
                @error('first_name')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="gemini-form-group">
                <label class="gemini-label" style="font-weight: 500; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user" style="color: var(--gemini-blue); font-size: 14px;"></i>
                    Familiya *
                </label>
                <input type="text" name="last_name" class="gemini-input @error('last_name') error @enderror" value="{{ old('last_name') }}" required placeholder="Familiyangizni kiriting" style="padding: 16px; border-radius: 12px; font-size: 16px;">
                @error('last_name')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="gemini-form-group">
                <label class="gemini-label" style="font-weight: 500; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-phone" style="color: var(--gemini-blue); font-size: 14px;"></i>
                    Telefon *
                </label>
                <input type="text" name="phone" class="gemini-input @error('phone') error @enderror" value="{{ old('phone') }}" required placeholder="+998 90 123 45 67" style="padding: 16px; border-radius: 12px; font-size: 16px;">
                @error('phone')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="gemini-form-group">
                <label class="gemini-label" style="font-weight: 500; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-book" style="color: var(--gemini-blue); font-size: 14px;"></i>
                    Qiziqish bildirgan kurs
                </label>
                <select name="course_id" class="gemini-select @error('course_id') error @enderror" style="padding: 16px; border-radius: 12px; font-size: 16px;">
                    <option value="">Kurs tanlang</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="gemini-form-group">
                <label class="gemini-label">Manba *</label>
                <select name="source" class="gemini-select @error('source') error @enderror" required>
                    <option value="">Manba tanlang</option>
                    <option value="website" {{ old('source') == 'website' ? 'selected' : '' }}>Veb-sayt</option>
                    <option value="phone" {{ old('source') == 'phone' ? 'selected' : '' }}>Telefon qo'ng'irog'i</option>
                    <option value="social_media" {{ old('source') == 'social_media' ? 'selected' : '' }}>Ijtimoiy tarmoq</option>
                    <option value="referral" {{ old('source') == 'referral' ? 'selected' : '' }}>Tavsiya</option>
                    <option value="walk_in" {{ old('source') == 'walk_in' ? 'selected' : '' }}>Tashrif</option>
                    <option value="other" {{ old('source') == 'other' ? 'selected' : '' }}>Boshqa</option>
                </select>
                @error('source')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="gemini-form-group">
                <label class="gemini-label">Kuzatuv sanasi</label>
                <input type="date" name="follow_up_date" class="gemini-input @error('follow_up_date') error @enderror" value="{{ old('follow_up_date') }}">
                @error('follow_up_date')
                    <div class="gemini-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="gemini-form-group" style="margin-bottom: 24px;">
            <label class="gemini-label">Izohlar</label>
            <textarea name="notes" class="gemini-textarea @error('notes') error @enderror" rows="3" placeholder="Qo'shimcha ma'lumotlar...">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="gemini-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 16px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--gemini-border);">
            <a href="{{ route('admin.leads.index') }}" class="gemini-btn-secondary" style="padding: 12px 24px; border-radius: 24px; font-size: 16px; font-weight: 500;">
                <i class="fas fa-arrow-left"></i>
                Orqaga
            </a>
            <button type="submit" class="gemini-btn" style="padding: 12px 32px; border-radius: 24px; font-size: 16px; font-weight: 500; background: linear-gradient(135deg, #4285f4, #34a853); box-shadow: 0 2px 8px rgba(66, 133, 244, 0.3);">
                <i class="fas fa-check"></i>
                Saqlash
            </button>
        </div>
    </form>
</div>
@endsection