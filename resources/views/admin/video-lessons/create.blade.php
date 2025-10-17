@extends('layouts.admin')

@section('content')

<div class="gemini-card">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('admin.video-lessons.index') }}" class="gemini-btn-icon">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="gemini-card-title" style="margin: 0;">Yangi Video Dars</h1>
            <p class="gemini-card-subtitle" style="margin: 4px 0 0 0;">Video dars qo'shish</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.video-lessons.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            <div>
                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Dars nomi *</label>
                    <input type="text" name="title" class="gemini-input" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Tavsif</label>
                    <textarea name="description" class="gemini-input" rows="4"></textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Kurs *</label>
                    <select name="course_id" class="gemini-input" required>
                        <option value="">Kursni tanlang</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Video fayl *</label>
                    <input type="file" name="video_file" class="gemini-input" accept="video/*" required>
                    <small style="color: var(--gemini-text-secondary);">MP4, AVI, MOV formatlar. Maksimal 500MB</small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Davomiyligi (soniya) *</label>
                    <input type="number" name="duration" class="gemini-input" min="1" required>
                </div>
            </div>

            <div>
                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Thumbnail rasm</label>
                    <input type="file" name="thumbnail" class="gemini-input" accept="image/*">
                    <div id="thumbnail-preview" style="margin-top: 12px; display: none;">
                        <img id="preview-img" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                    </div>
                </div>

                <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 14px;">Maslahatlar</h3>
                    <ul style="margin: 0; padding-left: 16px; font-size: 12px; color: var(--gemini-text-secondary);">
                        <li>HD sifatda video yuklang</li>
                        <li>Thumbnail 16:9 nisbatda bo'lsin</li>
                        <li>Video nomi aniq va tushunarli bo'lsin</li>
                        <li>Tavsifda asosiy mavzularni yozing</li>
                    </ul>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="gemini-btn">
                <i class="fas fa-save"></i> Saqlash
            </button>
            <a href="{{ route('admin.video-lessons.index') }}" class="gemini-btn" style="background: #6c757d;">
                Bekor qilish
            </a>
        </div>
    </form>
</div>

<script>
document.querySelector('input[name="thumbnail"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('thumbnail-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>

@endsection