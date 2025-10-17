// Gemini Dashboard Charts
class GeminiCharts {
    constructor() {
        this.isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        this.colors = this.getColors();
        this.initCharts();
    }

    getColors() {
        return {
            primary: this.isDark ? '#4285f4' : '#1a73e8',
            success: this.isDark ? '#34a853' : '#137333',
            warning: this.isDark ? '#fbbc04' : '#f9ab00',
            danger: this.isDark ? '#ea4335' : '#d93025',
            info: this.isDark ? '#4285f4' : '#1967d2',
            background: this.isDark ? '#1f1f1f' : '#ffffff',
            text: this.isDark ? '#e8eaed' : '#202124',
            grid: this.isDark ? '#3c4043' : '#dadce0'
        };
    }

    initCharts() {
        this.initRevenueChart();
        this.initStudentChart();
        this.initCourseChart();
        this.initAttendanceChart();
    }

    initRevenueChart() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyun'],
                datasets: [{
                    label: 'Daromad',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: this.colors.primary,
                    backgroundColor: this.colors.primary + '20',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: this.colors.grid },
                        ticks: { color: this.colors.text }
                    },
                    x: {
                        grid: { color: this.colors.grid },
                        ticks: { color: this.colors.text }
                    }
                }
            }
        });
    }

    initStudentChart() {
        const ctx = document.getElementById('studentChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Faol', 'Yangi', 'Tugatgan'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        this.colors.success,
                        this.colors.warning,
                        this.colors.info
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: this.colors.text }
                    }
                }
            }
        });
    }

    initCourseChart() {
        const ctx = document.getElementById('courseChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Frontend', 'Backend', 'Mobile', 'Design'],
                datasets: [{
                    label: 'O\'quvchilar soni',
                    data: [45, 32, 28, 15],
                    backgroundColor: this.colors.primary + '80'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: this.colors.grid },
                        ticks: { color: this.colors.text }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: this.colors.text }
                    }
                }
            }
        });
    }

    initAttendanceChart() {
        const ctx = document.getElementById('attendanceChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Dush', 'Sesh', 'Chor', 'Pay', 'Juma', 'Shan'],
                datasets: [{
                    label: 'Davomat %',
                    data: [85, 92, 78, 88, 95, 82],
                    borderColor: this.colors.success,
                    backgroundColor: this.colors.success + '20',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        min: 70,
                        max: 100,
                        grid: { color: this.colors.grid },
                        ticks: { color: this.colors.text }
                    },
                    x: {
                        grid: { color: this.colors.grid },
                        ticks: { color: this.colors.text }
                    }
                }
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new GeminiCharts();
});

// Reinitialize on theme change
document.addEventListener('themeChanged', () => {
    // Clear existing charts
    Chart.helpers.each(Chart.instances, (instance) => {
        instance.destroy();
    });
    // Reinitialize with new theme
    new GeminiCharts();
});