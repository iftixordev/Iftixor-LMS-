@extends('layouts.admin')

@section('content')
<div class="gemini-card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">O'qituvchi Ma'lumotlarini Tahrirlash</h1>
            <p class="gemini-card-subtitle">{{ $teacher->full_name }} ning ma'lumotlarini yangilang</p>
        </div>
        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="gemini-btn" style="background: #f44336; color: white;">
                <i class="fas fa-trash"></i> O'chirish
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" enctype="multipart/form-data" style="display: grid; gap: 24px;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Ism</label>
                <input type="text" name="first_name" class="gemini-input" value="{{ $teacher->first_name }}" required>
            </div>
            <div>
                <label class="gemini-label">Familiya</label>
                <input type="text" name="last_name" class="gemini-input" value="{{ $teacher->last_name }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Telefon</label>
                <input type="text" name="phone" class="gemini-input" value="{{ $teacher->phone }}" required>
            </div>
            <div>
                <label class="gemini-label">Profil rasmi</label>
                <input type="file" name="photo" class="gemini-input" accept="image/*">
                @if($teacher->photo)
                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                        <img src="{{ $teacher->photo_url }}" width="30" height="30" style="border-radius: 50%;">
                        <small style="color: var(--gemini-text-secondary);">Joriy rasm</small>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <label class="gemini-label">Manzil</label>
            <textarea name="address" class="gemini-input" rows="2">{{ $teacher->address }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Mutaxassislik</label>
                <input type="text" name="specializations" class="gemini-input" value="{{ $teacher->specializations }}" required>
            </div>
            <div>
                <label class="gemini-label">Ta'lim</label>
                <input type="text" name="education" class="gemini-input" value="{{ $teacher->education }}">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Soatlik maosh (so'm)</label>
                <input type="number" name="hourly_rate" class="gemini-input" value="{{ $teacher->hourly_rate }}" min="0" required>
            </div>
            <div>
                <label class="gemini-label">Holat</label>
                <select name="status" class="gemini-input" required>
                    <option value="active" {{ $teacher->status == 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ $teacher->status == 'inactive' ? 'selected' : '' }}>Nofaol</option>
                </select>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 12px;">
            <a href="{{ route('admin.teachers.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </form>
</div>
@endsection