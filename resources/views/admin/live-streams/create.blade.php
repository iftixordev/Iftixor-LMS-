@extends('layouts.admin')

@section('content')

<div class="gemini-card">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('admin.live-streams.index') }}" class="gemini-btn-icon">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="gemini-card-title" style="margin: 0;">Yangi Jonli Efir</h1>
            <p class="gemini-card-subtitle" style="margin: 4px 0 0 0;">Jonli dars rejalashtirish</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.live-streams.store') }}">
        @csrf
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            <div>
                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Efir nomi *</label>
                    <input type="text" name="title" class="gemini-input" placeholder="Masalan: Frontend asoslari - 1-dars" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Tavsif</label>
                    <textarea name="description" class="gemini-input" rows="4" placeholder="Efir haqida qisqacha ma'lumot..."></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                    <div>
                        <label class="gemini-label">O'qituvchi *</label>
                        <select name="teacher_id" class="gemini-input" required>
                            <option value="">O'qituvchini tanlang</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="gemini-label">Kurs *</label>
                        <select name="course_id" class="gemini-input" required>
                            <option value="">Kursni tanlang</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="gemini-label">Rejalashtirilgan vaqt *</label>
                    <input type="datetime-local" name="scheduled_at" class="gemini-input" 
                           min="{{ now()->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>

            <div>
                <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 16px;">
                        <i class="fas fa-broadcast-tower"></i> Jonli Efir
                    </h3>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">
                        O'quvchilar real vaqtda darsni kuzatib, savollar bera oladilar
                    </p>
                </div>

                <div style="background: var(--gemini-bg); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 14px;">Efir sozlamalari</h3>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary); line-height: 1.5;">
                        • Efir avtomatik ravishda yozib olinadi<br>
                        • Tomoshabinlar soni real vaqtda ko'rsatiladi<br>
                        • Chat funksiyasi mavjud<br>
                        • Efir tugagandan keyin video saqlanadi
                    </div>
                </div>

                <div style="background: rgba(255, 193, 7, 0.1); border: 1px solid #ffc107; padding: 16px; border-radius: 8px;">
                    <h4 style="margin: 0 0 8px 0; font-size: 14px; color: #f57c00;">
                        <i class="fas fa-exclamation-triangle"></i> Eslatma
                    </h4>
                    <p style="margin: 0; font-size: 12px; color: var(--gemini-text-secondary);">
                        Efir boshlanishidan 15 daqiqa oldin o'quvchilarga bildirishnoma yuboriladi
                    </p>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="gemini-btn">
                <i class="fas fa-calendar-plus"></i> Rejalashtirish
            </button>
            <a href="{{ route('admin.live-streams.index') }}" class="gemini-btn" style="background: #6c757d;">
                Bekor qilish
            </a>
        </div>
    </form>
</div>

@endsection