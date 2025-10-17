@extends('layouts.admin')

@section('content')
<div class="gemini-form-container">
    <div class="gemini-form-card">
        <div class="gemini-form-header">
            <h1 class="gemini-form-title">Filialni Tahrirlash</h1>
            <p class="gemini-form-subtitle">{{ $branch->name }} filiali ma'lumotlarini yangilang</p>
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

        <form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="gemini-form-grid">
            @csrf
            @method('PUT')
            
            <div class="gemini-form-section">
                <h3 class="gemini-form-section-title">Filial Ma'lumotlari</h3>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Filial nomi *</label>
                    <input type="text" name="name" class="gemini-input" value="{{ old('name', $branch->name) }}" required>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Manzil *</label>
                    <textarea name="address" class="gemini-textarea" required>{{ old('address', $branch->address) }}</textarea>
                </div>
                
                <div class="gemini-form-row">
                    <div class="gemini-form-group">
                        <label class="gemini-label">Telefon *</label>
                        <input type="tel" name="phone" class="gemini-input" value="{{ old('phone', $branch->phone) }}" required>
                    </div>
                    
                    <div class="gemini-form-group">
                        <label class="gemini-label">Email</label>
                        <input type="email" name="email" class="gemini-input" value="{{ old('email', $branch->email) }}">
                    </div>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Menejer</label>
                    <select name="manager_id" class="gemini-select">
                        <option value="">Menejerni tanlang</option>
                        @foreach($managers ?? [] as $manager)
                            <option value="{{ $manager->id }}" {{ old('manager_id', $branch->manager_id) == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">Tavsif</label>
                    <textarea name="description" class="gemini-textarea">{{ old('description', $branch->description) }}</textarea>
                </div>
                
                <div class="gemini-form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $branch->is_active) ? 'checked' : '' }} style="width: 16px; height: 16px;">
                        <span class="gemini-label" style="margin: 0;">Faol filial</span>
                    </label>
                </div>
            </div>
            
            <div class="gemini-form-actions">
                <a href="{{ route('admin.branches.index') }}" class="gemini-btn-secondary">
                    <i class="fas fa-times"></i> Bekor qilish
                </a>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-save"></i> Yangilash
                </button>
            </div>
        </form>
    </div>
</div>
@endsection