@extends('layouts.admin')

@section('content')
<div class="modern-students-page">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-user-graduate"></i> O'quvchilar boshqaruvi</h1>
            <p>Jami {{ $students->total() }} ta o'quvchi</p>
        </div>
        <div class="header-actions">
            <button class="btn-secondary" onclick="toggleFilters()">
                <i class="fas fa-filter"></i> Filtr
            </button>
            <a href="{{ route('admin.students.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Yangi o'quvchi
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div id="filtersPanel" class="filters-panel" style="display: none;">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label>Kurs</label>
                <select name="course_id">
                    <option value="">Barcha kurslar</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Guruh</label>
                <select name="group_id">
                    <option value="">Barcha guruhlar</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Holat</label>
                <select name="status">
                    <option value="">Barcha holatlar</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Faol</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nofaol</option>
                    <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Bitirgan</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn-primary">Qo'llash</button>
                <a href="{{ route('admin.students.index') }}" class="btn-secondary">Tozalash</a>
            </div>
        </form>
    </div>

    <!-- Search -->
    <div class="search-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="O'quvchi qidirish..." value="{{ request('search') }}">
        </div>
        <div class="bulk-actions" style="display: none;">
            <button class="btn-danger" onclick="bulkDelete()">
                <i class="fas fa-trash"></i> O'chirish
            </button>
            <button class="btn-secondary" onclick="bulkExport()">
                <i class="fas fa-download"></i> Eksport
            </button>
        </div>
    </div>

    <!-- Students Grid -->
    <div class="students-grid">
        @forelse($students as $student)
        <div class="student-card" data-student-id="{{ $student->id }}">
            <div class="student-header">
                <div class="student-checkbox">
                    <input type="checkbox" class="student-select" value="{{ $student->id }}">
                </div>
                <div class="student-avatar">
                    <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}">
                    <div class="status-indicator {{ $student->status }}"></div>
                </div>
                <div class="student-actions">
                    <div class="dropdown">
                        <button class="dropdown-toggle">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('admin.students.show', $student) }}">
                                <i class="fas fa-eye"></i> Ko'rish
                            </a>
                            <a href="{{ route('admin.students.edit', $student) }}">
                                <i class="fas fa-edit"></i> Tahrirlash
                            </a>
                            <a href="{{ route('admin.students.progress', $student) }}">
                                <i class="fas fa-chart-line"></i> Progress
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="text-danger" onclick="deleteStudent({{ $student->id }})">
                                <i class="fas fa-trash"></i> O'chirish
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="student-info">
                <h3>{{ $student->full_name }}</h3>
                <p class="student-course">{{ $student->course->name ?? 'Kurs belgilanmagan' }}</p>
                <p class="student-group">{{ $student->group->name ?? 'Guruh belgilanmagan' }}</p>
            </div>

            <div class="student-stats">
                <div class="stat-item">
                    <span class="stat-label">Davomat</span>
                    <span class="stat-value">{{ $student->attendance_percentage ?? 0 }}%</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">O'rtacha ball</span>
                    <span class="stat-value">{{ $student->average_score ?? 0 }}</span>
                </div>
            </div>

            <div class="student-contact">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>{{ $student->phone }}</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $student->created_at->format('d.m.Y') }}</span>
                </div>
            </div>

            <div class="student-footer">
                <div class="payment-status {{ $student->payment_status }}">
                    @if($student->payment_status == 'paid')
                        <i class="fas fa-check-circle"></i> To'langan
                    @elseif($student->payment_status == 'partial')
                        <i class="fas fa-exclamation-circle"></i> Qisman
                    @else
                        <i class="fas fa-times-circle"></i> Qarzdor
                    @endif
                </div>
                <div class="student-debt">
                    @if($student->debt > 0)
                        <span class="debt-amount">{{ number_format($student->debt) }} so'm</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-user-graduate"></i>
            <h3>O'quvchilar topilmadi</h3>
            <p>Hozircha hech qanday o'quvchi yo'q yoki qidiruv natijasida hech narsa topilmadi.</p>
            <a href="{{ route('admin.students.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Birinchi o'quvchini qo'shish
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
    <div class="pagination-wrapper">
        {{ $students->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.modern-students-page {
    padding: 20px;
    background: #f8fafc;
    min-height: 100vh;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.header-content h1 {
    font-size: 24px;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-content p {
    color: #718096;
    margin: 4px 0 0 0;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.btn-primary, .btn-secondary, .btn-danger {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-secondary {
    background: #e2e8f0;
    color: #4a5568;
}

.btn-danger {
    background: #fed7d7;
    color: #e53e3e;
}

.filters-panel {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.filters-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    align-items: end;
}

.filter-group label {
    display: block;
    margin-bottom: 4px;
    font-weight: 500;
    color: #4a5568;
}

.filter-group select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: white;
}

.search-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.search-box {
    position: relative;
    width: 300px;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #718096;
}

.search-box input {
    width: 100%;
    padding: 12px 12px 12px 40px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: white;
}

.students-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.student-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
}

.student-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.student-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.student-avatar {
    position: relative;
}

.student-avatar img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.active { background: #48bb78; }
.status-indicator.inactive { background: #ed8936; }
.status-indicator.graduated { background: #667eea; }

.student-info h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1a202c;
    margin: 0 0 8px 0;
}

.student-course {
    color: #667eea;
    font-weight: 500;
    margin: 0 0 4px 0;
}

.student-group {
    color: #718096;
    font-size: 14px;
    margin: 0;
}

.student-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin: 16px 0;
    padding: 16px;
    background: #f7fafc;
    border-radius: 8px;
}

.stat-item {
    text-align: center;
}

.stat-label {
    display: block;
    font-size: 12px;
    color: #718096;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 18px;
    font-weight: 600;
    color: #1a202c;
}

.student-contact {
    margin: 16px 0;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 14px;
    color: #718096;
}

.student-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
}

.payment-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 6px;
}

.payment-status.paid {
    background: #e6fffa;
    color: #38a169;
}

.payment-status.partial {
    background: #fef5e7;
    color: #d69e2e;
}

.payment-status.unpaid {
    background: #fed7d7;
    color: #e53e3e;
}

.debt-amount {
    font-size: 12px;
    color: #e53e3e;
    font-weight: 600;
}

.dropdown {
    position: relative;
}

.dropdown-toggle {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    color: #718096;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    min-width: 150px;
    z-index: 10;
    display: none;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    text-decoration: none;
    color: #4a5568;
    font-size: 14px;
}

.dropdown-menu a:hover {
    background: #f7fafc;
}

.dropdown-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 4px 0;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 24px;
    margin-bottom: 12px;
    color: #4a5568;
}

@media (max-width: 768px) {
    .students-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }
    
    .search-section {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }
    
    .search-box {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
function toggleFilters() {
    const panel = document.getElementById('filtersPanel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.student-card');
    
    cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const course = card.querySelector('.student-course').textContent.toLowerCase();
        const phone = card.querySelector('.contact-item span').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || course.includes(searchTerm) || phone.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Dropdown functionality
document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = this.nextElementSibling;
        
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) m.style.display = 'none';
        });
        
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', function() {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
    });
});

// Bulk selection
document.querySelectorAll('.student-select').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const selected = document.querySelectorAll('.student-select:checked');
        const bulkActions = document.querySelector('.bulk-actions');
        
        if (selected.length > 0) {
            bulkActions.style.display = 'flex';
        } else {
            bulkActions.style.display = 'none';
        }
    });
});

function deleteStudent(id) {
    if (confirm('Rostdan ham bu o\'quvchini o\'chirmoqchimisiz?')) {
        // Delete logic here
        console.log('Deleting student:', id);
    }
}

function bulkDelete() {
    const selected = document.querySelectorAll('.student-select:checked');
    if (selected.length > 0 && confirm(`${selected.length} ta o'quvchini o'chirmoqchimisiz?`)) {
        // Bulk delete logic here
        console.log('Bulk deleting students');
    }
}

function bulkExport() {
    const selected = document.querySelectorAll('.student-select:checked');
    if (selected.length > 0) {
        // Export logic here
        console.log('Exporting students');
    }
}
</script>
@endpush