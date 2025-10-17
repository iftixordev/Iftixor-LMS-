@extends('layouts.admin')

@section('content')
<div class="gemini-card">
    <div style="margin-bottom: 24px;">
        <h1 class="gemini-card-title" style="margin-bottom: 4px;">O'quvchi Ma'lumotlarini Tahrirlash</h1>
        <p class="gemini-card-subtitle">{{ $student->full_name }} ning ma'lumotlarini yangilang</p>
    </div>

    <form method="POST" action="{{ route('admin.students.update', $student) }}" enctype="multipart/form-data" style="display: grid; gap: 24px;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Ism</label>
                <input type="text" name="first_name" class="gemini-input" value="{{ $student->first_name }}" required>
            </div>
            <div>
                <label class="gemini-label">Familiya</label>
                <input type="text" name="last_name" class="gemini-input" value="{{ $student->last_name }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Tug'ilgan sana</label>
                <input type="date" name="birth_date" class="gemini-input" value="{{ $student->birth_date->format('Y-m-d') }}" required>
            </div>
            <div>
                <label class="gemini-label">Jinsi</label>
                <select name="gender" class="gemini-input" required>
                    <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Erkak</option>
                    <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Ayol</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Telefon</label>
                <input type="text" name="phone" class="gemini-input" value="{{ $student->phone }}" required>
            </div>
            <div>
                <label class="gemini-label">Profil rasmi</label>
                <input type="file" name="photo" class="gemini-input" accept="image/*">
                @if($student->photo)
                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                        <img src="{{ $student->photo_url }}" width="30" height="30" style="border-radius: 50%;">
                        <small style="color: var(--gemini-text-secondary);">Joriy rasm</small>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <label class="gemini-label">Manzil</label>
            <textarea name="address" class="gemini-input" rows="2">{{ $student->address }}</textarea>
        </div>

        <div>
            <h2 style="font-size: 18px; font-weight: 500; margin-bottom: 16px; color: var(--gemini-text);">Ota-ona Ma'lumotlari</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label class="gemini-label">Ota-ona ismi</label>
                    <input type="text" name="parent_name" class="gemini-input" value="{{ $student->parent_name }}">
                </div>
                <div>
                    <label class="gemini-label">Ota-ona telefoni</label>
                    <input type="text" name="parent_phone" class="gemini-input" value="{{ $student->parent_phone }}">
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Holat</label>
                <select name="status" class="gemini-input" required>
                    <option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ $student->status == 'inactive' ? 'selected' : '' }}>Nofaol</option>
                    <option value="graduated" {{ $student->status == 'graduated' ? 'selected' : '' }}>Bitirgan</option>
                </select>
            </div>
            <div></div>
        </div>

        <div>
            <label class="gemini-label">Izohlar</label>
            <textarea name="notes" class="gemini-input" rows="3">{{ $student->notes }}</textarea>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 12px;">
            <a href="{{ route('admin.students.show', $student) }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </form>
</div>
@endsection