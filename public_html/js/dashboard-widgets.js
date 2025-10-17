// Dashboard Widgets and Interactive Components

class DashboardWidgets {
    constructor() {
        this.init();
    }

    init() {
        this.setupLiveUpdates();
        this.setupInteractiveCharts();
        this.setupRealTimeNotifications();
        this.setupKeyboardNavigation();
        this.setupTooltips();
    }

    // Live Updates
    setupLiveUpdates() {
        // Update stats every 5 minutes
        setInterval(() => {
            this.updateStats();
        }, 300000);

        // Update time every second
        setInterval(() => {
            this.updateTime();
        }, 1000);
    }

    updateStats() {
        // Fetch updated stats via AJAX
        fetch('/admin/api/stats')
            .then(response => response.json())
            .then(data => {
                this.animateStatsUpdate(data);
            })
            .catch(error => {
                console.log('Stats update failed:', error);
            });
    }

    animateStatsUpdate(data) {
        const statsElements = {
            'total_students': document.querySelector('.stats-card:nth-child(1) h2'),
            'active_courses': document.querySelector('.stats-card:nth-child(2) h2'),
            'today_classes': document.querySelector('.stats-card:nth-child(3) h2'),
            'monthly_revenue': document.querySelector('.stats-card:nth-child(4) h2')
        };

        Object.keys(statsElements).forEach(key => {
            const element = statsElements[key];
            if (element && data[key] !== undefined) {
                const currentValue = parseInt(element.textContent.replace(/,/g, ''));
                const newValue = data[key];
                
                if (currentValue !== newValue) {
                    this.animateCounter(element, currentValue, newValue, 1000);
                    element.closest('.stats-card').classList.add('updated');
                    setTimeout(() => {
                        element.closest('.stats-card').classList.remove('updated');
                    }, 2000);
                }
            }
        });
    }

    updateTime() {
        const now = new Date();
        const timeElements = document.querySelectorAll('#current-time, #header-time');
        const timeString = now.toLocaleTimeString('uz-UZ', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        timeElements.forEach(element => {
            if (element) {
                element.textContent = timeString;
            }
        });
    }

    // Interactive Charts
    setupInteractiveCharts() {
        this.createMiniCharts();
        this.setupProgressAnimations();
    }

    createMiniCharts() {
        // Create mini sparkline charts for stats cards
        const chartContainers = document.querySelectorAll('.stats-card .progress-bar');
        
        chartContainers.forEach((container, index) => {
            const canvas = document.createElement('canvas');
            canvas.width = 100;
            canvas.height = 20;
            canvas.style.position = 'absolute';
            canvas.style.bottom = '0';
            canvas.style.right = '0';
            canvas.style.opacity = '0.3';
            
            const ctx = canvas.getContext('2d');
            this.drawSparkline(ctx, this.generateSampleData(), index);
            
            container.parentElement.style.position = 'relative';
            container.parentElement.appendChild(canvas);
        });
    }

    drawSparkline(ctx, data, colorIndex) {
        const colors = ['#667eea', '#f093fb', '#4facfe', '#fa709a'];
        const color = colors[colorIndex % colors.length];
        
        ctx.strokeStyle = color;
        ctx.lineWidth = 2;
        ctx.beginPath();
        
        data.forEach((point, index) => {
            const x = (index / (data.length - 1)) * 100;
            const y = 20 - (point / 100) * 20;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
    }

    generateSampleData() {
        return Array.from({length: 10}, () => Math.random() * 100);
    }

    setupProgressAnimations() {
        const progressBars = document.querySelectorAll('.progress-bar');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    
                    setTimeout(() => {
                        bar.style.transition = 'width 2s cubic-bezier(0.4, 0, 0.2, 1)';
                        bar.style.width = width;
                    }, 200);
                }
            });
        });
        
        progressBars.forEach(bar => observer.observe(bar));
    }

    // Real-time Notifications
    setupRealTimeNotifications() {
        // Simulate real-time notifications
        setTimeout(() => {
            this.showFloatingNotification('Yangi o\'quvchi ro\'yxatdan o\'tdi!', 'success');
        }, 10000);

        setTimeout(() => {
            this.showFloatingNotification('Dars vaqti yaqinlashmoqda', 'warning');
        }, 20000);
    }

    showFloatingNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `floating-notification ${type}`;
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${this.getNotificationIcon(type)} me-2"></i>
                <span>${message}</span>
                <button class="btn btn-sm btn-link text-white ms-auto" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            background: ${this.getNotificationColor(type)};
            color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 300px;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            warning: 'exclamation-triangle',
            error: 'times-circle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    getNotificationColor(type) {
        const colors = {
            success: '#10b981',
            warning: '#f59e0b',
            error: '#ef4444',
            info: '#3b82f6'
        };
        return colors[type] || '#3b82f6';
    }

    // Keyboard Navigation
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            // Alt + 1-9 for quick navigation
            if (e.altKey && e.key >= '1' && e.key <= '9') {
                e.preventDefault();
                const navLinks = document.querySelectorAll('.sidebar .nav-link');
                const index = parseInt(e.key) - 1;
                if (navLinks[index]) {
                    navLinks[index].click();
                }
            }
            
            // Ctrl + Shift + N for new student
            if (e.ctrlKey && e.shiftKey && e.key === 'N') {
                e.preventDefault();
                const newStudentBtn = document.querySelector('a[href*="students.create"]');
                if (newStudentBtn) newStudentBtn.click();
            }
            
            // Ctrl + Shift + C for new course
            if (e.ctrlKey && e.shiftKey && e.key === 'C') {
                e.preventDefault();
                const newCourseBtn = document.querySelector('a[href*="courses.create"]');
                if (newCourseBtn) newCourseBtn.click();
            }
        });
    }

    // Enhanced Tooltips
    setupTooltips() {
        // Add tooltips to stats cards
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach((card, index) => {
            const tooltips = [
                'Jami ro\'yxatdan o\'tgan o\'quvchilar soni',
                'Hozirda faol bo\'lgan kurslar soni',
                'Bugun rejalashtirilgan darslar soni',
                'Joriy oyda olingan daromad miqdori'
            ];
            
            card.setAttribute('title', tooltips[index]);
            card.setAttribute('data-bs-toggle', 'tooltip');
        });
        
        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    // Utility Methods
    animateCounter(element, start, end, duration) {
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            const current = Math.floor(start + (end - start) * easeOutCubic(progress));
            element.textContent = new Intl.NumberFormat('uz-UZ').format(current);
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            }
        }
        
        requestAnimationFrame(updateCounter);
    }
}

// Easing function
function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
}

// CSS for floating notifications and updates
const style = document.createElement('style');
style.textContent = `
    .floating-notification {
        animation: slideInRight 0.3s ease;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }
    
    .stats-card.updated {
        animation: pulse 0.6s ease-in-out;
        border: 2px solid var(--claude-orange);
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .keyboard-shortcut-hint {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: var(--claude-card);
        border: 1px solid var(--claude-border);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        color: var(--claude-text-light);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .keyboard-shortcut-hint.show {
        opacity: 1;
    }
`;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.dashboardWidgets = new DashboardWidgets();
    
    // Show keyboard shortcuts hint
    setTimeout(() => {
        const hint = document.createElement('div');
        hint.className = 'keyboard-shortcut-hint';
        hint.innerHTML = 'Alt + 1-9: Tezkor navigatsiya | Ctrl+Shift+N: Yangi o\'quvchi | Ctrl+Shift+C: Yangi kurs';
        document.body.appendChild(hint);
        
        setTimeout(() => hint.classList.add('show'), 100);
        setTimeout(() => {
            hint.classList.remove('show');
            setTimeout(() => hint.remove(), 300);
        }, 5000);
    }, 3000);
});