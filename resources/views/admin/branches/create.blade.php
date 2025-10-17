@extends('layouts.admin')

@section('content')
<div class="gemini-form-container">
    <div class="gemini-form-card">
        <div class="gemini-form-header">
            <h1 class="gemini-form-title">Yangi Filial</h1>
            <p class="gemini-form-subtitle">Yangi filial yaratish uchun ma'lumotlarni kiriting</p>
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

        <form action="{{ route('admin.branches.store') }}" method="POST" class="gemini-form-grid">
            @csrf
            
            <div class="gemini-form-section">
                <h3 class="gemini-form-section-title">Filial Ma'lumotlari</h3>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Filial nomi *</label>
                    <input type="text" name="name" class="gemini-input" value="{{ old('name') }}" required placeholder="Masalan: Markaziy filial">
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Manzil *</label>
                    <textarea name="address" class="gemini-textarea" required placeholder="To'liq manzil...">{{ old('address') }}</textarea>
                </div>
                
                <div class="gemini-form-row">
                    <div class="gemini-form-group">
                        <label class="gemini-label">Telefon *</label>
                        <input type="tel" name="phone" class="gemini-input" value="{{ old('phone') }}" required placeholder="+998901234567">
                    </div>
                    
                    <div class="gemini-form-group">
                        <label class="gemini-label">Email</label>
                        <input type="email" name="email" class="gemini-input" value="{{ old('email') }}" placeholder="filial@example.com">
                    </div>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Tavsif</label>
                    <textarea name="description" class="gemini-textarea" placeholder="Filial haqida qo'shimcha ma'lumot...">{{ old('description') }}</textarea>
                </div>
                
                <div class="gemini-form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 16px; height: 16px;">
                        <span class="gemini-label" style="margin: 0;">Faol filial</span>
                    </label>
                </div>
            </div>
            
            <div class="gemini-form-actions">
                <a href="{{ route('admin.branches.index') }}" class="gemini-btn-secondary">
                    <i class="fas fa-times"></i> Bekor qilish
                </a>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-save"></i> Saqlash
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Phone number formatting
document.querySelector('input[name="phone"]').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value.startsWith('998')) {
        value = '+' + value;
    } else if (value.length > 0 && !value.startsWith('998')) {
        value = '+998' + value;
    }
    this.value = value;
});
</script>
@endsection