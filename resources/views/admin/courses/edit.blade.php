@extends('layouts.admin')

@section('content')
<div class="gemini-card" style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Kurs Ma'lumotlarini Tahrirlash</h1>
            <p class="gemini-card-subtitle">{{ $course->name }} kursini yangilang</p>
        </div>
        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" style="display: inline;" onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="gemini-btn" style="background: #f44336; color: white;">
                <i class="fas fa-trash"></i> O'chirish
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data" style="display: grid; gap: 24px;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Kurs nomi</label>
                <input type="text" name="name" class="gemini-input" value="{{ $course->name }}" required>
            </div>
            <div>
                <label class="gemini-label">Davomiylik (oy)</label>
                <input type="number" name="duration_months" class="gemini-input" value="{{ $course->duration_months }}" min="1" required>
            </div>
            <div>
                <label class="gemini-label">Kurs rasmi</label>
                <input type="file" name="photo" class="gemini-input" accept="image/*">
                @if($course->photo)
                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                        <img src="{{ $course->photo_url }}" width="30" height="30" style="border-radius: 4px;">
                        <small style="color: var(--gemini-text-secondary);">Joriy rasm</small>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <label class="gemini-label">Tavsif</label>
            <textarea name="description" class="gemini-input" rows="3">{{ $course->description }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 16px;">
            <div>
                <label class="gemini-label">Narx (so'm)</label>
                <input type="number" name="price" class="gemini-input" value="{{ $course->price }}" min="0" required>
            </div>
            <div>
                <label class="gemini-label">Min o'quvchilar</label>
                <input type="number" name="min_students" class="gemini-input" value="{{ $course->min_students }}" min="1" required>
            </div>
            <div>
                <label class="gemini-label">Max o'quvchilar</label>
                <input type="number" name="max_students" class="gemini-input" value="{{ $course->max_students }}" min="1" required>
            </div>
            <div>
                <label class="gemini-label">Holat</label>
                <select name="status" class="gemini-input" required>
                    <option value="active" {{ $course->status == 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ $course->status == 'inactive' ? 'selected' : '' }}>Nofaol</option>
                    <option value="completed" {{ $course->status == 'completed' ? 'selected' : '' }}>Tugallangan</option>
                </select>
            </div>
        </div>

        <div>
            <label class="gemini-label">O'quv dasturi</label>
            <textarea name="curriculum" class="gemini-input" rows="4">{{ $course->curriculum }}</textarea>
        </div>

        <div style="display: flex; justify-content: space-between; gap: 12px;">
            <a href="{{ route('admin.courses.index') }}" class="gemini-btn" style="background: var(--gemini-hover); color: var(--gemini-text);">
                <i class="fas fa-arrow-left"></i> Bekor qilish
            </a>
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
        </div>
    </form>
</div>
@endsection