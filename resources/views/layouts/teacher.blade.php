<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'O\'qituvchi Paneli - Iftixor LMS')</title>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/gemini-admin.css') }}" rel="stylesheet">
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body>
    <!-- Teacher Header -->
    <header class="gemini-header">
        <a href="{{ route('teacher.dashboard') }}" class="gemini-logo">
            <div class="gemini-logo-icon">I</div>
            Iftixor Teacher
        </a>

        <div class="gemini-search" style="position: relative;">
            <input type="text" class="gemini-search-input" placeholder="O'quvchilar, guruhlar qidirish..." autocomplete="off">
        </div>

        <div class="gemini-user">
            <button class="gemini-btn-icon" onclick="toggleTheme()" title="Mavzu">
                <i class="fas fa-palette"></i>
            </button>
            <div style="position: relative;">
                <button class="gemini-btn-icon" onclick="toggleProfileMenu()" title="Profil">
                    <img src="{{ auth()->user()->teacher->photo_url ?? asset('images/default-avatar.svg') }}" 
                         style="width: 32px; height: 32px; border-radius: 50%;" alt="Profile">
                </button>
                <div id="profileMenu" class="profile-dropdown" style="display: none;">
                    <div class="profile-header">
                        <div class="profile-name">{{ auth()->user()->teacher->full_name }}</div>
                        <div class="profile-role">O'qituvchi</div>
                    </div>
                    <div class="profile-menu">
                        <a href="{{ route('teacher.profile') }}" class="profile-menu-item">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="{{ route('teacher.profile.edit') }}" class="profile-menu-item">
                            <i class="fas fa-cog"></i>
                            <span>Sozlamalar</span>
                        </a>
                        <div class="profile-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="profile-menu-item profile-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Chiqish</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Teacher Sidebar -->
    <nav class="gemini-sidebar">
        <div class="gemini-nav-section">
            <a href="{{ route('teacher.dashboard') }}" class="gemini-nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Bosh sahifa
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Darslar</div>
            <a href="{{ route('teacher.groups') }}" class="gemini-nav-item {{ request()->routeIs('teacher.groups*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Mening guruhlarim
            </a>
            <a href="{{ route('teacher.schedule') }}" class="gemini-nav-item {{ request()->routeIs('teacher.schedule') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                Dars jadvali
            </a>
            <a href="{{ route('teacher.attendance') }}" class="gemini-nav-item {{ request()->routeIs('teacher.attendance') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                Davomat
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Materiallar</div>
            <a href="{{ route('teacher.materials') }}" class="gemini-nav-item {{ request()->routeIs('teacher.materials') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                Dars materiallari
            </a>
            <a href="{{ route('teacher.assignments') }}" class="gemini-nav-item {{ request()->routeIs('teacher.assignments') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                Vazifalar
            </a>
            <a href="{{ route('teacher.grades') }}" class="gemini-nav-item {{ request()->routeIs('teacher.grades') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                Baholar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Aloqa</div>
            <a href="{{ route('teacher.messages') }}" class="gemini-nav-item {{ request()->routeIs('teacher.messages') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                Xabarlar
            </a>
            <a href="#" class="gemini-nav-item">
                <i class="fas fa-broadcast-tower"></i>
                Jonli darslar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Boshqa</div>
            <a href="{{ route('teacher.reports') }}" class="gemini-nav-item {{ request()->routeIs('teacher.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Hisobotlar
            </a>
            <a href="{{ route('teacher.profile') }}" class="gemini-nav-item {{ request()->routeIs('teacher.profile*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                Profil
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="gemini-main">
        @if(session('success'))
            <div style="background: var(--gemini-bg); color: var(--gemini-text); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #4caf50; border-left: 4px solid #4caf50;">
                <i class="fas fa-check-circle" style="color: #4caf50;"></i>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                html.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        // Profile menu functions
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Close profile menu when clicking outside
        document.addEventListener('click', function(e) {
            const profileMenu = document.getElementById('profileMenu');
            const profileButton = e.target.closest('[onclick="toggleProfileMenu()"]');
            
            if (!profileButton && profileMenu && !profileMenu.contains(e.target)) {
                profileMenu.style.display = 'none';
            }
        });
    </script>

    @yield('scripts')
</body>
</html>