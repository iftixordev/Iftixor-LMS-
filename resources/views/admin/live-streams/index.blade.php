@extends('layouts.admin')

@section('content')

<div class="gemini-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="gemini-card-title" style="margin-bottom: 4px;">Jonli Efirlar</h1>
            <p class="gemini-card-subtitle">Jonli darslar va efirlarni boshqaring</p>
        </div>
        <a href="{{ route('admin.live-streams.create') }}" class="gemini-btn">
            <i class="fas fa-broadcast-tower"></i> Yangi efir
        </a>
    </div>

    <!-- Stats -->
    <div class="gemini-stats">
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon" style="background: linear-gradient(135deg, #4caf50, #45a049);">
                <i class="fas fa-circle" style="color: #4caf50; animation: pulse 2s infinite;"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ $liveStreams }}</div>
                <div class="gemini-stat-label">Jonli efirlar</div>
                <div class="gemini-stat-change positive">Hozir jonli</div>
            </div>
        </div>
        
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ $scheduledStreams }}</div>
                <div class="gemini-stat-label">Rejalashtirilgan</div>
                <div class="gemini-stat-change neutral">Kutilmoqda</div>
            </div>
        </div>
        
        <div class="gemini-stat-card">
            <div class="gemini-stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="gemini-stat-content">
                <div class="gemini-stat-number">{{ number_format($totalViewers) }}</div>
                <div class="gemini-stat-label">Jami tomoshabinlar</div>
                <div class="gemini-stat-change positive">Barcha efirlar</div>
            </div>
        </div>
    </div>

    <!-- Live Streams -->
    @if($streams->where('status', 'live')->count() > 0)
    <div style="margin-bottom: 32px;">
        <h2 style="font-size: 18px; font-weight: 500; margin-bottom: 16px; color: var(--gemini-text);">
            <i class="fas fa-circle" style="color: #4caf50; font-size: 12px; margin-right: 8px;"></i>
            Jonli efirlar
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
            @foreach($streams->where('status', 'live') as $stream)
            <div class="gemini-card" style="margin: 0; border: 2px solid #4caf50;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div style="width: 12px; height: 12px; background: #4caf50; border-radius: 50%; animation: pulse 2s infinite;"></div>
                    <span style="color: #4caf50; font-weight: 600; font-size: 12px; text-transform: uppercase;">JONLI</span>
                    <span style="color: var(--gemini-text-secondary); font-size: 12px;">{{ $stream->viewers_count }} tomoshabin</span>
                </div>
                
                <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 500;">{{ $stream->title }}</h3>
                <p style="margin: 0 0 12px 0; font-size: 14px; color: var(--gemini-text-secondary);">
                    {{ $stream->teacher->full_name }} • {{ $stream->course->name }}
                </p>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.live-streams.show', $stream) }}" class="gemini-btn" style="flex: 1; text-align: center;">
                        <i class="fas fa-eye"></i> Ko'rish
                    </a>
                    <button onclick="endStream({{ $stream->id }})" class="gemini-btn" style="background: #f44336;">
                        <i class="fas fa-stop"></i> To'xtatish
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Streams -->
    <div>
        <h2 style="font-size: 18px; font-weight: 500; margin-bottom: 16px; color: var(--gemini-text);">Barcha efirlar</h2>
        
        <table class="gemini-table">
            <thead>
                <tr>
                    <th>Efir nomi</th>
                    <th>O'qituvchi</th>
                    <th>Kurs</th>
                    <th>Vaqt</th>
                    <th>Holat</th>
                    <th>Tomoshabinlar</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($streams as $stream)
                <tr>
                    <td>
                        <div>
                            <strong>{{ $stream->title }}</strong>
                            @if($stream->description)
                                <br><small style="color: var(--gemini-text-secondary);">{{ Str::limit($stream->description, 50) }}</small>
                            @endif
                        </div>
                    </td>
                    <td>{{ $stream->teacher->full_name }}</td>
                    <td>{{ $stream->course->name }}</td>
                    <td>
                        @if($stream->status === 'scheduled')
                            {{ $stream->scheduled_at->format('d.m.Y H:i') }}
                        @elseif($stream->status === 'live')
                            <span style="color: #4caf50;">Hozir jonli</span>
                        @else
                            {{ $stream->ended_at?->format('d.m.Y H:i') }}
                        @endif
                    </td>
                    <td>
                        <span style="background: rgba({{ $stream->status === 'live' ? '76, 175, 80' : ($stream->status === 'scheduled' ? '255, 152, 0' : '108, 117, 125') }}, 0.1); 
                                     color: {{ $stream->status === 'live' ? '#4caf50' : ($stream->status === 'scheduled' ? '#ff9800' : '#6c757d') }}; 
                                     padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $stream->status === 'live' ? 'Jonli' : ($stream->status === 'scheduled' ? 'Rejalashtirilgan' : 'Tugagan') }}
                        </span>
                    </td>
                    <td>
                        {{ $stream->viewers_count }}
                        @if($stream->max_viewers > 0)
                            <small style="color: var(--gemini-text-secondary);">(max: {{ $stream->max_viewers }})</small>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.live-streams.show', $stream) }}" class="gemini-btn" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($stream->status === 'scheduled')
                                <button onclick="startStream({{ $stream->id }})" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #4caf50;">
                                    <i class="fas fa-play"></i>
                                </button>
                            @elseif($stream->status === 'live')
                                <button onclick="endStream({{ $stream->id }})" class="gemini-btn" style="padding: 6px 12px; font-size: 12px; background: #f44336;">
                                    <i class="fas fa-stop"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--gemini-text-secondary);">
                        <i class="fas fa-broadcast-tower" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <div>Efirlar yo'q</div>
                        <a href="{{ route('admin.live-streams.create') }}" class="gemini-btn" style="margin-top: 16px;">
                            <i class="fas fa-plus"></i> Birinchi efirni yarating
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>

<script>
function startStream(streamId) {
    if (confirm('Efirni boshlashni xohlaysizmi?')) {
        fetch(`/admin/live-streams/${streamId}/start`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function endStream(streamId) {
    if (confirm('Efirni to\'xtatishni xohlaysizmi?')) {
        fetch(`/admin/live-streams/${streamId}/end`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>

@endsection