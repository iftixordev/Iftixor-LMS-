@extends('layouts.student')

@section('content')

<div class="gemini-card" style="margin-bottom: 24px;">
    <h1 class="gemini-card-title">Kurslar</h1>
    <p class="gemini-card-subtitle">Mavjud kurslarni ko'ring va ariza bering</p>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Available Courses -->
    <div>
        <div class="gemini-card">
            <h2 class="gemini-card-title">Mavjud Kurslar</h2>
            
            <div style="display: grid; gap: 20px;">
                @foreach($availableCourses as $course)
                <div style="display: flex; gap: 20px; padding: 20px; background: var(--gemini-bg); border-radius: 12px; border: 1px solid var(--gemini-border);">
                    <img src="{{ $course->photo_url }}" style="width: 120px; height: 80px; border-radius: 8px; object-fit: cover;">
                    
                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 500;">{{ $course->name }}</h3>
                        <p style="margin: 0 0 12px 0; color: var(--gemini-text-secondary); line-height: 1.4;">{{ $course->description }}</p>
                        
                        <div style="display: flex; gap: 20px; font-size: 14px; color: var(--gemini-text-secondary);">
                            <span><i class="fas fa-clock"></i> {{ $course->duration_months }} oy</span>
                            <span><i class="fas fa-money-bill"></i> {{ number_format($course->price) }} so'm</span>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center;">
                        @if($course->applications->where('student_id', auth()->user()->student->id)->first())
                            @php $app = $course->applications->where('student_id', auth()->user()->student->id)->first() @endphp
                            <span style="background: {{ $app->status == 'pending' ? 'rgba(255, 152, 0, 0.1)' : ($app->status == 'approved' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)') }}; 
                                         color: {{ $app->status == 'pending' ? '#ff9800' : ($app->status == 'approved' ? '#4caf50' : '#f44336') }}; 
                                         padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500;">
                                {{ $app->status == 'pending' ? 'Kutilmoqda' : ($app->status == 'approved' ? 'Tasdiqlangan' : 'Rad etilgan') }}
                            </span>
                        @else
                            <button onclick="showApplyModal({{ $course->id }}, '{{ $course->name }}')" class="gemini-btn">
                                <i class="fas fa-paper-plane"></i> Ariza berish
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

                @endforeach
            </div>
        </div>
    </div>

    <!-- My Applications -->
    <div>
        <div class="gemini-card">
            <h2 class="gemini-card-title">Mening Arizalarim</h2>
            
            <div style="display: grid; gap: 12px;">
                @forelse($myApplications as $application)
                <div style="padding: 16px; background: var(--gemini-bg); border-radius: 8px; border: 1px solid var(--gemini-border);">
                    <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 500;">{{ $application->course->name }}</h3>
                    <p style="margin: 0 0 8px 0; font-size: 12px; color: var(--gemini-text-secondary);">{{ $application->applied_at->format('d.m.Y H:i') }}</p>
                    
                    <span style="background: {{ $application->status == 'pending' ? 'rgba(255, 152, 0, 0.1)' : ($application->status == 'approved' ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)') }}; 
                                 color: {{ $application->status == 'pending' ? '#ff9800' : ($application->status == 'approved' ? '#4caf50' : '#f44336') }}; 
                                 padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                        {{ $application->status == 'pending' ? 'Kutilmoqda' : ($application->status == 'approved' ? 'Tasdiqlangan' : 'Rad etilgan') }}
                    </span>
                    
                    @if($application->rejection_reason)
                    <p style="margin: 8px 0 0 0; color: #f44336; font-size: 12px;">{{ $application->rejection_reason }}</p>
                    @endif
                </div>
                @empty
                <div style="text-align: center; padding: 40px 20px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-file-alt" style="font-size: 32px; margin-bottom: 12px; opacity: 0.5;"></i>
                    <p style="margin: 0;">Hali ariza bermagansiz</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Apply Modal -->
<div id="applyModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="gemini-card" style="width: 400px; margin: 0;">
        <h3 id="modalTitle" style="margin: 0 0 20px 0;">Kursga ariza berish</h3>
        <form method="POST" action="{{ route('student.courses.apply') }}">
            @csrf
            <input type="hidden" id="courseId" name="course_id">
            
            <div style="margin-bottom: 16px;">
                <label class="gemini-label">Xabar (ixtiyoriy)</label>
                <textarea name="message" class="gemini-input" rows="3" placeholder="Nima uchun bu kursni tanlayapsiz?"></textarea>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeApplyModal()" class="gemini-btn" style="background: #6c757d;">
                    Bekor qilish
                </button>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-paper-plane"></i> Ariza yuborish
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showApplyModal(courseId, courseName) {
    document.getElementById('courseId').value = courseId;
    document.getElementById('modalTitle').textContent = courseName + ' - Ariza';
    document.getElementById('applyModal').style.display = 'flex';
}

function closeApplyModal() {
    document.getElementById('applyModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('applyModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeApplyModal();
    }
});
</script>
@endsection