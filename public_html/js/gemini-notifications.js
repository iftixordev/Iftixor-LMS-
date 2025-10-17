// Gemini Notifications System
class GeminiNotifications {
    constructor() {
        this.init();
        this.startPolling();
    }

    init() {
        this.createNotificationWidget();
        this.bindEvents();
    }

    createNotificationWidget() {
        const widget = document.createElement('div');
        widget.id = 'notification-widget';
        widget.innerHTML = `
            <button class="gemini-btn-icon" id="notification-btn" title="Bildirishnomalar">
                <i class="fas fa-bell"></i>
                <span id="notification-badge" class="notification-badge" style="display: none;">0</span>
            </button>
            <div id="notification-dropdown" class="notification-dropdown" style="display: none;">
                <div class="notification-header">
                    <h3>Bildirishnomalar</h3>
                    <button id="mark-all-read" class="mark-all-btn">Barchasini o'qilgan deb belgilash</button>
                </div>
                <div id="notification-list" class="notification-list">
                    <div class="notification-loading">Yuklanmoqda...</div>
                </div>
            </div>
        `;

        // Add to header
        const userSection = document.querySelector('.gemini-user');
        if (userSection) {
            userSection.insertBefore(widget, userSection.firstChild);
        }

        // Add CSS
        this.addStyles();
    }

    addStyles() {
        const style = document.createElement('style');
        style.textContent = `
            #notification-widget {
                position: relative;
            }

            .notification-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #ea4335;
                color: white;
                border-radius: 50%;
                width: 18px;
                height: 18px;
                font-size: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
            }

            .notification-dropdown {
                position: absolute;
                top: 100%;
                right: 0;
                width: 350px;
                max-height: 400px;
                background: var(--gemini-surface);
                border: 1px solid var(--gemini-border);
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                margin-top: 8px;
            }

            .notification-header {
                padding: 16px;
                border-bottom: 1px solid var(--gemini-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .notification-header h3 {
                margin: 0;
                font-size: 16px;
                font-weight: 500;
                color: var(--gemini-text);
            }

            .mark-all-btn {
                background: none;
                border: none;
                color: var(--gemini-blue);
                font-size: 12px;
                cursor: pointer;
                padding: 4px 8px;
                border-radius: 4px;
                transition: background 0.2s;
            }

            .mark-all-btn:hover {
                background: var(--gemini-hover);
            }

            .notification-list {
                max-height: 300px;
                overflow-y: auto;
            }

            .notification-item {
                padding: 12px 16px;
                border-bottom: 1px solid var(--gemini-border);
                cursor: pointer;
                transition: background 0.2s;
            }

            .notification-item:hover {
                background: var(--gemini-hover);
            }

            .notification-item.unread {
                background: rgba(66, 133, 244, 0.05);
                border-left: 3px solid var(--gemini-blue);
            }

            .notification-item:last-child {
                border-bottom: none;
            }

            .notification-title {
                font-weight: 500;
                font-size: 14px;
                color: var(--gemini-text);
                margin-bottom: 4px;
            }

            .notification-message {
                font-size: 12px;
                color: var(--gemini-text-secondary);
                line-height: 1.4;
                margin-bottom: 4px;
            }

            .notification-time {
                font-size: 11px;
                color: var(--gemini-text-secondary);
            }

            .notification-loading {
                padding: 20px;
                text-align: center;
                color: var(--gemini-text-secondary);
            }

            .notification-empty {
                padding: 40px 20px;
                text-align: center;
                color: var(--gemini-text-secondary);
            }
        `;
        document.head.appendChild(style);
    }

    bindEvents() {
        const btn = document.getElementById('notification-btn');
        const dropdown = document.getElementById('notification-dropdown');
        const markAllBtn = document.getElementById('mark-all-read');

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });

        markAllBtn.addEventListener('click', () => {
            this.markAllAsRead();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('notification-widget').contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }

    toggleDropdown() {
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown.style.display === 'none') {
            dropdown.style.display = 'block';
            this.loadNotifications();
        } else {
            dropdown.style.display = 'none';
        }
    }

    async loadNotifications() {
        const list = document.getElementById('notification-list');
        list.innerHTML = '<div class="notification-loading">Yuklanmoqda...</div>';

        try {
            // Mock data for now - replace with actual API call
            const notifications = [
                {
                    id: 1,
                    title: 'Yangi o\'quvchi qo\'shildi',
                    message: 'Alisher Karimov Frontend kursiga yozildi',
                    time: '5 daqiqa oldin',
                    is_read: false
                },
                {
                    id: 2,
                    title: 'To\'lov qabul qilindi',
                    message: 'Malika Toshmatova 500,000 so\'m to\'lov qildi',
                    time: '1 soat oldin',
                    is_read: true
                },
                {
                    id: 3,
                    title: 'Dars bekor qilindi',
                    message: 'Frontend guruh 1 - bugungi dars bekor qilindi',
                    time: '2 soat oldin',
                    is_read: false
                }
            ];

            this.renderNotifications(notifications);
        } catch (error) {
            list.innerHTML = '<div class="notification-empty">Xatolik yuz berdi</div>';
        }
    }

    renderNotifications(notifications) {
        const list = document.getElementById('notification-list');
        
        if (notifications.length === 0) {
            list.innerHTML = '<div class="notification-empty">Bildirishnomalar yo\'q</div>';
            return;
        }

        list.innerHTML = notifications.map(notification => `
            <div class="notification-item ${!notification.is_read ? 'unread' : ''}" data-id="${notification.id}">
                <div class="notification-title">${notification.title}</div>
                <div class="notification-message">${notification.message}</div>
                <div class="notification-time">${notification.time}</div>
            </div>
        `).join('');

        // Add click handlers
        list.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', () => {
                this.markAsRead(item.dataset.id);
                item.classList.remove('unread');
            });
        });
    }

    async markAsRead(notificationId) {
        // Mock API call - replace with actual endpoint
        console.log('Marking notification as read:', notificationId);
        this.updateBadge();
    }

    async markAllAsRead() {
        // Mock API call - replace with actual endpoint
        console.log('Marking all notifications as read');
        
        // Remove unread class from all items
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        
        this.updateBadge();
    }

    updateBadge() {
        const badge = document.getElementById('notification-badge');
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        
        if (unreadCount > 0) {
            badge.textContent = unreadCount;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    startPolling() {
        // Poll for new notifications every 30 seconds
        setInterval(() => {
            this.checkForNewNotifications();
        }, 30000);
    }

    async checkForNewNotifications() {
        // Mock check - replace with actual API call
        const hasNew = Math.random() > 0.8; // 20% chance of new notification
        
        if (hasNew) {
            this.showNewNotificationToast();
            this.updateBadge();
        }
    }

    showNewNotificationToast() {
        // Create toast notification
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--gemini-surface);
            border: 1px solid var(--gemini-border);
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            max-width: 300px;
            animation: slideIn 0.3s ease;
        `;
        
        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-bell" style="color: var(--gemini-blue);"></i>
                <div>
                    <div style="font-weight: 500; font-size: 14px; color: var(--gemini-text);">Yangi bildirishnoma</div>
                    <div style="font-size: 12px; color: var(--gemini-text-secondary);">Yangi faoliyat mavjud</div>
                </div>
            </div>
        `;

        document.body.appendChild(toast);

        // Remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);

        // Add animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new GeminiNotifications();
});