@extends('layouts.admin')

@section('content')
<div class="gemini-card animate-on-scroll">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Bildirishnomalar</h1>
            <p class="gemini-card-subtitle">Barcha bildirishnomalarni ko'ring va boshqaring</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="gemini-btn btn-animate" onclick="markAllAsRead()" style="background: #4caf50; color: white;">
                <i class="fas fa-check-double"></i> Barchasini o'qilgan
            </button>
            <button class="gemini-btn" style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary);" onclick="clearAll()">
                <i class="fas fa-trash"></i> Tozalash
            </button>
        </div>
    </div>
    
    <div style="display: grid; gap: 12px;">
        @forelse($notifications ?? [] as $notification)
        <div class="notification-item hover-lift" onclick="markAsRead({{ $notification->id ?? 0 }})" style="display: flex; align-items: start; padding: 20px; border: 1px solid var(--yt-spec-10-percent-layer); cursor: pointer; background: {{ !($notification->is_read ?? true) ? 'var(--yt-spec-brand-background-solid)' : 'var(--yt-spec-base-background)' }}; border-radius: 12px; transition: all 0.2s ease;">
            <div style="margin-right: 16px; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: {{ ($notification->type ?? 'info') == 'success' ? '#e8f5e8' : '#e3f2fd' }};">
                <i class="fas fa-{{ ($notification->type ?? 'info') == 'success' ? 'check-circle' : 'info-circle' }}" style="font-size: 18px; color: {{ ($notification->type ?? 'info') == 'success' ? '#4caf50' : '#2196f3' }};"></i>
            </div>
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                    <h3 style="margin: 0; font-size: 16px; font-weight: {{ !($notification->is_read ?? true) ? '600' : '500' }}; color: var(--yt-spec-text-primary);">{{ $notification->title ?? 'Bildirishnoma' }}</h3>
                    @if(!($notification->is_read ?? true))
                    <span style="background: #2196f3; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 500;">YANGI</span>
                    @endif
                </div>
                <p style="margin: 0 0 8px 0; color: var(--yt-text-secondary); font-size: 14px; line-height: 1.4;">{{ $notification->message ?? 'Ma\'lumot yo\'q' }}</p>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <small style="color: var(--yt-text-secondary); font-size: 12px; display: flex; align-items: center; gap: 4px;">
                        <i class="fas fa-clock"></i>
                        {{ $notification->created_at ? $notification->created_at->diffForHumans() : 'N/A' }}
                    </small>
                    @if($notification->type ?? false)
                    <span style="background: var(--yt-spec-button-chip-background-hover); color: var(--yt-spec-text-primary); padding: 2px 6px; border-radius: 4px; font-size: 10px; text-transform: uppercase;">
                        {{ $notification->type }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 80px 20px;">
            <div style="width: 80px; height: 80px; background: var(--yt-spec-button-chip-background-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i class="fas fa-bell-slash" style="font-size: 32px; color: var(--yt-text-secondary);"></i>
            </div>
            <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 500; color: var(--yt-spec-text-primary);">Bildirishnomalar yo'q</h3>
            <p style="margin: 0; color: var(--yt-text-secondary); font-size: 14px;">Yangi bildirishnomalar paydo bo'lganda bu yerda ko'rinadi</p>
        </div>
        @endforelse
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/admin/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => location.reload());
}

function markAllAsRead() {
    if (confirm('Barcha bildirishnomalarni o\'qilgan deb belgilaysizmi?')) {
        fetch('/admin/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    }
}

function clearAll() {
    if (confirm('Barcha bildirishnomalarni o\'chirmoqchimisiz?')) {
        alert('Tozalash funksiyasi tez orada qo\'shiladi');
    }
}

// Hover effects
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.notification-item');
    items.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.1)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>
@endsection