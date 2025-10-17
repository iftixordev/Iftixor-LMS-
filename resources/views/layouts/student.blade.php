<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'O\'quvchi Paneli - Iftixor LMS')</title>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/gemini-admin.css') }}" rel="stylesheet">
    @yield('styles')
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body>
    <!-- Student Header -->
    <header class="gemini-header">
        <a href="{{ route('student.dashboard') }}" class="gemini-logo">
            <div class="gemini-logo-icon">I</div>
            Iftixor Student
        </a>

        <div class="gemini-search" style="position: relative;">
            <input type="text" class="gemini-search-input" placeholder="Darslar, materiallar qidirish..." autocomplete="off">
        </div>

        <div class="gemini-user">
            <button class="gemini-btn-icon" onclick="toggleTheme()" title="Mavzu">
                <i class="fas fa-palette"></i>
            </button>
            <div style="position: relative;">
                <button class="gemini-btn-icon" onclick="toggleProfileMenu()" title="Profil">
                    <img src="{{ auth()->user()->photo_url ?? asset('images/default-avatar.svg') }}" 
                         style="width: 32px; height: 32px; border-radius: 50%;" alt="Profile">
                </button>
                <div id="profileMenu" class="profile-dropdown" style="display: none;">
                    <div class="profile-header">
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-role">O'quvchi</div>
                    </div>
                    <div class="profile-menu">
                        <a href="{{ route('student.profile') }}" class="profile-menu-item">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="{{ route('student.profile.edit') }}" class="profile-menu-item">
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
    
    <!-- Student Sidebar -->
    <nav class="gemini-sidebar">
        <div class="gemini-nav-section">
            <a href="{{ route('student.dashboard') }}" class="gemini-nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Bosh sahifa
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Ta'lim</div>
            <a href="{{ route('student.courses') }}" class="gemini-nav-item {{ request()->routeIs('student.courses*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                Mening kurslarim
            </a>
            <a href="{{ route('student.schedule') }}" class="gemini-nav-item {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                Dars jadvali
            </a>
            <a href="{{ route('student.materials') }}" class="gemini-nav-item {{ request()->routeIs('student.materials') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                Materiallar
            </a>
            <a href="{{ route('student.assignments') }}" class="gemini-nav-item {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                Vazifalar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Natijalar</div>
            <a href="{{ route('student.grades') }}" class="gemini-nav-item {{ request()->routeIs('student.grades') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Baholar
            </a>
            <a href="#" class="gemini-nav-item">
                <i class="fas fa-trophy"></i>
                Yutuqlar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Aloqa</div>
            <a href="{{ route('student.messages') }}" class="gemini-nav-item {{ request()->routeIs('student.messages') ? 'active' : '' }}">
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
            <a href="{{ route('student.payments') }}" class="gemini-nav-item {{ request()->routeIs('student.payments') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                To'lovlar
            </a>
            <a href="{{ route('student.profile') }}" class="gemini-nav-item {{ request()->routeIs('student.profile*') ? 'active' : '' }}">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>