@extends('layouts.admin')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Profile Card -->
    <div class="gemini-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <img src="{{ $user->photo_url }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 16px; border: 4px solid var(--gemini-border);">
            <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 500; color: var(--gemini-text);">{{ $user->full_name }}</h2>
            <p style="margin: 0 0 16px 0; color: var(--gemini-text-secondary);">{{ ucfirst($user->role) }}</p>
            
            <span style="background: {{ $user->is_active ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)' }}; 
                         color: {{ $user->is_active ? '#4caf50' : '#f44336' }}; 
                         padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                {{ $user->is_active ? 'Faol' : 'Nofaol' }}
            </span>
        </div>
        
        <a href="{{ route('admin.profile.edit') }}" class="gemini-btn" style="width: 100%; text-align: center;">
            <i class="fas fa-edit"></i> Profilni tahrirlash
        </a>
    </div>
    
    <!-- Profile Details -->
    <div>
        <!-- Personal Information -->
        <div class="gemini-card" style="margin-bottom: 24px;">
            <h2 class="gemini-card-title">Shaxsiy ma'lumotlar</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="gemini-label">Ism</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->first_name }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Familiya</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->last_name }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Telefon raqam</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->phone }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Tug'ilgan sana</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Kiritilmagan' }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Rol</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px;">
                        <span style="background: var(--gemini-blue); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Ro'yxatdan o'tgan</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

        @if($user->role == 'teacher' && $user->teacher)
        <!-- Teacher Information -->
        <div class="gemini-card">
            <h2 class="gemini-card-title">O'qituvchi ma'lumotlari</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="gemini-label">Guruhlar soni</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->teacher->groups->count() }} ta
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Jami o'quvchilar</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->teacher->groups->sum(function($group) { return $group->students->count(); }) }} kishi
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($user->role == 'student' && $user->student)
        <!-- Student Information -->
        <div class="gemini-card">
            <h2 class="gemini-card-title">O'quvchi ma'lumotlari</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="gemini-label">O'quvchi ID</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->student->student_id }}
                    </div>
                </div>
                
                <div>
                    <label class="gemini-label">Guruhlar soni</label>
                    <div style="padding: 12px; background: var(--gemini-bg); border-radius: 8px; color: var(--gemini-text);">
                        {{ $user->student->groups->count() }} ta
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Active Sessions -->
        <div class="gemini-card" style="margin-top: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="gemini-card-title">Faol seanslar</h2>
                @php
                    $currentSession = $user->sessions->where('session_id', session()->getId())->first();
                    $canTerminate = $currentSession && $currentSession->canTerminateOthers();
                    $isOldest = $currentSession && $user->sessions->sortBy('created_at')->first()->id === $currentSession->id;
                @endphp
                <button onclick="terminateAllSessions()" 
                        class="gemini-btn {{ !$canTerminate ? 'disabled' : '' }}" 
                        style="background: {{ $canTerminate ? '#f44336' : '#ccc' }}; color: white; font-size: 12px;"
                        {{ !$canTerminate ? 'disabled title="Faqat eng eski seans boshqalarini tugatishi mumkin"' : '' }}>
                    <i class="fas fa-sign-out-alt"></i> 
                    {{ $canTerminate ? 'Barchasini tugatish' : ($isOldest ? 'Eng eski seans' : 'Ruxsat yo\'q') }}
                </button>
            </div>
            
            <div class="sessions-list">
                @forelse($user->sessions as $session)
                <div class="session-item {{ $session->is_current ? 'current-session' : '' }}">
                    <div class="session-info">
                        <div class="session-device">
                            <i class="{{ $session->device_icon }}"></i>
                            <div>
                                <div class="session-name">
                                    {{ $session->device_name }} - {{ $session->browser }}
                                    @if($session->is_current)
                                        <span class="current-badge">Joriy seans</span>
                                    @endif
                                </div>
                                <div class="session-details">
                                    {{ $session->platform }} • {{ $session->ip_address }} • {{ $session->location }}
                                </div>
                                <div class="session-time">
                                    Yaratilgan: {{ $session->created_at->diffForHumans() }} • 
                                    Oxirgi faollik: {{ $session->last_activity->diffForHumans() }}
                                    @if($user->sessions->sortBy('created_at')->first()->id === $session->id)
                                        <span style="color: var(--gemini-blue); font-weight: 500;"> • Eng eski</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!$session->is_current)
                    <button onclick="terminateSession({{ $session->id }})" 
                            class="terminate-btn {{ !$canTerminate ? 'disabled' : '' }}"
                            {{ !$canTerminate ? 'disabled title="Faqat eng eski seans boshqalarini tugatishi mumkin"' : '' }}>
                        <i class="fas fa-times"></i>
                    </button>
                    @endif
                </div>
                @empty
                <div style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                    <i class="fas fa-desktop" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p>Faol seanslar yo'q</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.sessions-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.session-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border: 1px solid var(--gemini-border);
    border-radius: 8px;
    background: var(--gemini-bg);
    transition: all 0.2s;
}

.session-item:hover {
    background: var(--gemini-hover);
}

.current-session {
    border-color: var(--gemini-blue);
    background: rgba(66, 165, 245, 0.05);
}

.session-device {
    display: flex;
    align-items: center;
    gap: 12px;
}

.session-device i {
    font-size: 24px;
    color: var(--gemini-blue);
    width: 32px;
    text-align: center;
}

.session-name {
    font-weight: 500;
    color: var(--gemini-text);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.current-badge {
    background: var(--gemini-blue);
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 500;
}

.session-details {
    font-size: 13px;
    color: var(--gemini-text-secondary);
    margin-bottom: 2px;
}

.session-time {
    font-size: 12px;
    color: var(--gemini-text-secondary);
}

.terminate-btn {
    background: #f44336;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.terminate-btn:hover:not(.disabled) {
    background: #d32f2f;
    transform: scale(1.1);
}

.terminate-btn.disabled {
    background: #ccc !important;
    cursor: not-allowed;
    opacity: 0.6;
}

.gemini-btn.disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>

<script>
function terminateSession(sessionId) {
    console.log('Terminating session:', sessionId);
    
    if (!confirm('Bu seansni tugatishni xohlaysizmi?')) return;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        notifications.show('CSRF token topilmadi', 'error');
        return;
    }
    
    console.log('CSRF Token:', csrfToken.getAttribute('content'));
    
    fetch('/admin/profile/terminate-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        },
        body: JSON.stringify({ session_id: sessionId })
    })
    .then(response => {
        if (response.status === 401) {
            // Session terminated, redirect to login
            window.location.href = '/login';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            notifications.show(data.message || 'Seans tugatildi', 'success');
            location.reload();
        } else if (data) {
            notifications.show(data.message || 'Xatolik yuz berdi', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notifications.show('Xatolik yuz berdi', 'error');
    });
}

function terminateAllSessions() {
    if (!confirm('Barcha boshqa seanslarni tugatishni xohlaysizmi?')) return;
    
    fetch('/admin/profile/terminate-all-sessions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            notifications.show(data.message || 'Seanslar tugatildi', 'success');
            location.reload();
        } else {
            notifications.show(data.message || 'Xatolik yuz berdi', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notifications.show('Xatolik yuz berdi', 'error');
    });
}
</script>
@endsection