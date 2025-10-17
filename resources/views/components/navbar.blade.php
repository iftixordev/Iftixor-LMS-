@props(['type' => 'admin', 'user' => null])

@php
$user = $user ?? Auth::user();
$navConfig = [
    'admin' => [
        'title' => 'Admin Panel',
        'gradient' => 'linear-gradient(135deg, #ff7c2e 0%, #ff5722 100%)',
        'routes' => [
            ['route' => 'admin.dashboard', 'icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard'],
            ['route' => 'admin.leads.index', 'icon' => 'fas fa-user-plus', 'label' => 'Potensial Mijozlar'],
            ['route' => 'admin.students.index', 'icon' => 'fas fa-user-graduate', 'label' => 'O\'quvchilar'],
            ['route' => 'admin.courses.index', 'icon' => 'fas fa-book', 'label' => 'Kurslar'],
            ['route' => 'admin.courses.applications', 'icon' => 'fas fa-file-alt', 'label' => 'Kurs Arizalari'],
            ['route' => 'admin.teachers.index', 'icon' => 'fas fa-chalkboard-teacher', 'label' => 'O\'qituvchilar'],
            ['route' => 'admin.groups.index', 'icon' => 'fas fa-users', 'label' => 'Guruhlar'],
            ['route' => 'admin.schedules.index', 'icon' => 'fas fa-calendar-alt', 'label' => 'Dars Jadvali'],
            ['route' => 'admin.attendance.index', 'icon' => 'fas fa-calendar-check', 'label' => 'Davomat'],
            ['route' => 'admin.finance.index', 'icon' => 'fas fa-dollar-sign', 'label' => 'Moliya'],
            ['route' => 'admin.expenses.index', 'icon' => 'fas fa-credit-card', 'label' => 'Xarajatlar'],
            ['route' => 'admin.certificates.index', 'icon' => 'fas fa-certificate', 'label' => 'Sertifikatlar'],
            ['route' => 'admin.gamification.dashboard', 'icon' => 'fas fa-coins', 'label' => 'Gamification'],
            ['route' => 'admin.reports.index', 'icon' => 'fas fa-chart-bar', 'label' => 'Hisobotlar'],
        ]
    ],
    'student' => [
        'title' => 'O\'quvchi Panel',
        'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'routes' => [
            ['route' => 'student.dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
            ['route' => 'student.profile', 'icon' => 'fas fa-user', 'label' => 'Profil'],
            ['route' => 'student.courses', 'icon' => 'fas fa-book', 'label' => 'Mening Kurslarim'],
            ['route' => 'student.schedule', 'icon' => 'fas fa-calendar', 'label' => 'Dars Jadvali'],
            ['route' => 'student.materials', 'icon' => 'fas fa-folder', 'label' => 'Materiallar'],
            ['route' => 'student.assignments', 'icon' => 'fas fa-tasks', 'label' => 'Vazifalar'],
            ['route' => 'student.grades', 'icon' => 'fas fa-chart-line', 'label' => 'Baholar'],
            ['route' => 'student.messages', 'icon' => 'fas fa-comments', 'label' => 'Xabarlar'],
            ['route' => 'student.payments', 'icon' => 'fas fa-credit-card', 'label' => 'To\'lovlar'],
            ['route' => 'student.calendar', 'icon' => 'fas fa-calendar-alt', 'label' => 'Kalendar'],
        ]
    ],
    'teacher' => [
        'title' => 'O\'qituvchi Panel',
        'gradient' => 'linear-gradient(135deg, #2c3e50 0%, #34495e 100%)',
        'routes' => [
            ['route' => 'teacher.dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
            ['route' => 'teacher.profile', 'icon' => 'fas fa-user', 'label' => 'Profil'],
            ['route' => 'teacher.groups', 'icon' => 'fas fa-users', 'label' => 'Guruhlar'],
            ['route' => 'teacher.schedule', 'icon' => 'fas fa-calendar', 'label' => 'Dars Jadvali'],
            ['route' => 'teacher.materials', 'icon' => 'fas fa-folder', 'label' => 'Materiallar'],
            ['route' => 'teacher.assignments', 'icon' => 'fas fa-tasks', 'label' => 'Vazifalar'],
            ['route' => 'teacher.grades', 'icon' => 'fas fa-chart-line', 'label' => 'Baholar'],
            ['route' => 'teacher.attendance', 'icon' => 'fas fa-calendar-check', 'label' => 'Davomat'],
            ['route' => 'teacher.messages', 'icon' => 'fas fa-comments', 'label' => 'Xabarlar'],
            ['route' => 'teacher.reports', 'icon' => 'fas fa-chart-bar', 'label' => 'Hisobotlar'],
        ]
    ]
];

$config = $navConfig[$type];
@endphp

<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background: {{ $config['gradient'] }};">
    <div class="position-sticky pt-3 d-flex flex-column" style="height: 100vh;">
        <!-- Logo/Title -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3">
            <div class="d-flex align-items-center justify-content-center w-100">
                @if($type === 'admin')
                    <img src="{{ asset('images/iftixor-logo.svg') }}" alt="Iftixor LMS" width="140" height="42" class="logo-img">
                @else
                    <h5 class="text-white mb-0">{{ $config['title'] }}</h5>
                @endif
            </div>
            <button class="btn btn-link p-0 d-md-none position-absolute text-white" style="right: 15px;" onclick="toggleSidebar()">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>

        <!-- Yangi tugmasi -->
        @if($type === 'admin')
        <div class="mb-3 px-3">
            <button class="btn btn-light w-100 d-flex align-items-center justify-content-center" 
                    onclick="showCreateModal()" style="border-radius: 12px; font-weight: 600;">
                <i class="fas fa-plus me-2"></i> Yangi
            </button>
        </div>
        @endif

        <!-- Navigation Links -->
        <ul class="nav flex-column">
            @foreach($config['routes'] as $navItem)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($navItem['route'] . '*') ? 'active' : '' }}" 
                       href="{{ route($navItem['route']) }}">
                        <i class="{{ $navItem['icon'] }} me-2"></i> {{ $navItem['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- User Profile Section -->
        <div class="mt-auto pt-3" style="margin-bottom: 20px;">
            <div class="border-top border-opacity-25 pt-3 mb-3"></div>
            
            @if($type === 'admin')
                <!-- Notifications for Admin -->
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}" 
                       href="{{ route('admin.notifications.index') }}">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-bell me-2"></i>
                                <span>Bildirishnomalar</span>
                            </div>
                            @php $unreadCount = \App\Models\Notification::where('target', 'admins')->where('is_read', false)->count(); @endphp
                            @if($unreadCount > 0)
                                <span class="badge bg-danger rounded-pill animate-pulse">{{ $unreadCount }}</span>
                            @endif
                        </div>
                    </a>
                </li>
            @endif
            
            <!-- User Profile -->
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs($type . '.profile*') ? 'active' : '' }}" 
                   href="{{ route($type . '.profile') }}">
                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3">
                            <img src="{{ $user->photo_url }}" width="32" height="32" 
                                 class="rounded-circle border border-2 border-white" 
                                 style="object-fit: cover;" alt="{{ $user->full_name }}">
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" 
                                  style="width: 10px; height: 10px; border: 2px solid var(--claude-card);"></span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-white">{{ substr($user->full_name, 0, 15) }}{{ strlen($user->full_name) > 15 ? '...' : '' }}</div>
                            <small class="text-white-50">{{ ucfirst($type) }}</small>
                        </div>
                    </div>
                </a>
            </li>
            
            <!-- Logout -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-start w-100 border-0 p-2 text-danger" 
                            onclick="return confirm('Rostdan ham chiqmoqchimisiz?')" 
                            style="background: rgba(220, 53, 69, 0.1); border-radius: 8px;">
                        <i class="fas fa-sign-out-alt me-2"></i> 
                        <span>Chiqish</span>
                    </button>
                </form>
            </li>
        </div>
    </div>
</nav>

<style>
.sidebar .nav-link {
    color: rgba(255,255,255,0.8);
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin: 2px 8px;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    color: #fff;
    background: rgba(255,255,255,0.2);
    transform: translateX(5px);
}

.sidebar .nav-link i {
    width: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 280px;
        z-index: 1050;
        transition: left 0.3s ease;
    }
    
    .sidebar.show {
        left: 0;
    }
}
</style>