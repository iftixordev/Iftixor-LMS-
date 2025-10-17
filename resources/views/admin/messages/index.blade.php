@extends('layouts.admin')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; height: calc(100vh - 120px);">
    <!-- Conversations List -->
    <div class="gemini-card" style="margin: 0; display: flex; flex-direction: column;">
        <div style="padding: 20px; border-bottom: 1px solid var(--gemini-border);">
            <h2 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 500;">Xabarlar</h2>
            <button class="gemini-btn" onclick="showNewMessageModal()" style="width: 100%;">
                <i class="fas fa-plus"></i> Yangi xabar
            </button>
        </div>
        
        <div style="flex: 1; overflow-y: auto;">
            @forelse($conversations as $userId => $messages)
                @php $lastMessage = $messages->first(); @endphp
                @php $otherUser = $lastMessage->sender_id == auth()->id() ? $lastMessage->receiver : $lastMessage->sender; @endphp
                <div class="conversation-item" data-user-id="{{ $userId }}" 
                     style="padding: 16px 20px; border-bottom: 1px solid var(--gemini-border); cursor: pointer; transition: background 0.2s;"
                     onmouseover="this.style.background='var(--gemini-hover)'" 
                     onmouseout="this.style.background='transparent'"
                     onclick="openConversation({{ $userId }})">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--gemini-blue); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            {{ substr($otherUser->name ?? $otherUser->full_name, 0, 1) }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 500; font-size: 14px; color: var(--gemini-text); margin-bottom: 4px;">
                                {{ $otherUser->name ?? $otherUser->full_name }}
                            </div>
                            <div style="font-size: 12px; color: var(--gemini-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ Str::limit($lastMessage->message, 50) }}
                            </div>
                        </div>
                        <div style="font-size: 11px; color: var(--gemini-text-secondary);">
                            {{ $lastMessage->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 40px 20px; text-align: center; color: var(--gemini-text-secondary);">
                    <i class="fas fa-comments" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p>Xabarlar yo'q</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Chat Area -->
    <div class="gemini-card" style="margin: 0; display: flex; flex-direction: column;">
        <div id="chat-header" style="padding: 20px; border-bottom: 1px solid var(--gemini-border); display: none;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="chat-avatar" style="width: 40px; height: 40px; border-radius: 50%; background: var(--gemini-blue); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;"></div>
                <div>
                    <div id="chat-name" style="font-weight: 500; font-size: 16px; color: var(--gemini-text);"></div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary);">Onlayn</div>
                </div>
            </div>
        </div>
        
        <div id="chat-messages" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; align-items: center; justify-content: center; color: var(--gemini-text-secondary);">
            Suhbatni boshlash uchun chap tarafdan foydalanuvchini tanlang
        </div>
        
        <div id="chat-input" style="padding: 20px; border-top: 1px solid var(--gemini-border); display: none;">
            <form onsubmit="sendMessage(event)" style="display: flex; gap: 12px;">
                <input type="hidden" id="receiver-id">
                <input type="text" id="message-input" class="gemini-input" placeholder="Xabar yozing..." style="flex: 1;" required>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- New Message Modal -->
<div id="newMessageModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="gemini-card" style="width: 400px; margin: 0;">
        <h3 style="margin: 0 0 20px 0;">Yangi xabar</h3>
        <form onsubmit="startNewConversation(event)">
            <div style="margin-bottom: 16px;">
                <label class="gemini-label">Qabul qiluvchi</label>
                <select id="new-receiver" class="gemini-input" required>
                    <option value="">Tanlang...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->type) }})</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label class="gemini-label">Xabar</label>
                <textarea id="new-message" class="gemini-input" rows="3" placeholder="Xabaringizni yozing..." required></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeNewMessageModal()" class="gemini-btn" style="background: #6c757d;">
                    Bekor qilish
                </button>
                <button type="submit" class="gemini-btn">
                    <i class="fas fa-paper-plane"></i> Yuborish
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentReceiverId = null;

function showNewMessageModal() {
    document.getElementById('newMessageModal').style.display = 'flex';
}

function closeNewMessageModal() {
    document.getElementById('newMessageModal').style.display = 'none';
    document.getElementById('new-receiver').value = '';
    document.getElementById('new-message').value = '';
}

function startNewConversation(event) {
    event.preventDefault();
    const receiverId = document.getElementById('new-receiver').value;
    const message = document.getElementById('new-message').value;
    
    // Send message
    fetch('{{ route("admin.messages.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            receiver_id: receiverId,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeNewMessageModal();
            openConversation(receiverId);
            location.reload(); // Refresh to show new conversation
        }
    });
}

function openConversation(userId) {
    currentReceiverId = userId;
    
    // Show chat interface
    document.getElementById('chat-header').style.display = 'block';
    document.getElementById('chat-input').style.display = 'block';
    document.getElementById('receiver-id').value = userId;
    
    // Load messages
    fetch(`{{ url('admin/messages') }}/${userId}`)
        .then(response => response.text())
        .then(html => {
            // This would need to be implemented to return JSON and render messages
            loadMessages(userId);
        });
}

function loadMessages(userId) {
    // Mock messages for demo
    const messages = [
        { sender_id: {{ auth()->id() }}, message: 'Salom! Qanday yordam bera olaman?', created_at: '10:30' },
        { sender_id: userId, message: 'Salom! Kurs haqida ma\'lumot olmoqchi edim', created_at: '10:32' },
        { sender_id: {{ auth()->id() }}, message: 'Albatta! Qaysi kurs sizni qiziqtiradi?', created_at: '10:33' }
    ];
    
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.innerHTML = messages.map(msg => `
        <div style="margin-bottom: 16px; display: flex; ${msg.sender_id == {{ auth()->id() }} ? 'justify-content: flex-end' : 'justify-content: flex-start'};">
            <div style="max-width: 70%; padding: 12px 16px; border-radius: 16px; ${msg.sender_id == {{ auth()->id() }} ? 'background: var(--gemini-blue); color: white;' : 'background: var(--gemini-bg); color: var(--gemini-text);'}">
                <div>${msg.message}</div>
                <div style="font-size: 11px; opacity: 0.7; margin-top: 4px;">${msg.created_at}</div>
            </div>
        </div>
    `).join('');
    
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sendMessage(event) {
    event.preventDefault();
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    
    if (!message || !currentReceiverId) return;
    
    fetch('{{ route("admin.messages.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            receiver_id: currentReceiverId,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            loadMessages(currentReceiverId);
        }
    });
}

// Close modal when clicking outside
document.getElementById('newMessageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeNewMessageModal();
    }
});
</script>

@endsection