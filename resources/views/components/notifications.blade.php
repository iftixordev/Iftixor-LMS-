<!-- Notifications Component -->
<div id="notifications-container" style="position: fixed; top: 80px; right: 20px; z-index: 10000; max-width: 350px;"></div>

<script>
// Notification system
window.notifications = {
    show: function(message, type = 'info', duration = 5000) {
        const container = document.getElementById('notifications-container');
        const notification = document.createElement('div');
        
        const colors = {
            success: { bg: '#d4edda', border: '#c3e6cb', text: '#155724', icon: 'check-circle' },
            error: { bg: '#f8d7da', border: '#f5c6cb', text: '#721c24', icon: 'exclamation-circle' },
            warning: { bg: '#fff3cd', border: '#ffeaa7', text: '#856404', icon: 'exclamation-triangle' },
            info: { bg: '#d1ecf1', border: '#bee5eb', text: '#0c5460', icon: 'info-circle' }
        };
        
        const color = colors[type] || colors.info;
        
        notification.style.cssText = `
            background: ${color.bg};
            border: 1px solid ${color.border};
            border-left: 4px solid ${color.border};
            color: ${color.text};
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: slideInRight 0.3s ease;
            position: relative;
            font-size: 14px;
            line-height: 1.4;
        `;
        
        notification.innerHTML = `
            <div style="display: flex; align-items: flex-start; gap: 10px;">
                <i class="fas fa-${color.icon}" style="margin-top: 2px; flex-shrink: 0;"></i>
                <div style="flex: 1;">${message}</div>
                <button onclick="this.parentElement.parentElement.remove()" 
                        style="background: none; border: none; color: ${color.text}; cursor: pointer; padding: 0; margin-left: 10px; font-size: 16px; line-height: 1;">
                    ×
                </button>
            </div>
        `;
        
        container.appendChild(notification);
        
        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => notification.remove(), 300);
                }
            }, duration);
        }
    }
};

// Add CSS animations if not exists
if (!document.getElementById('notification-styles')) {
    const style = document.createElement('style');
    style.id = 'notification-styles';
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
}
</script>