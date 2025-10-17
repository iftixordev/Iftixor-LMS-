<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gemini Admin')</title>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/gemini-admin.css') }}" rel="stylesheet">
</head>
<body>
    <header class="gemini-header">
        <a href="{{ route('admin.dashboard') }}" class="gemini-logo">
            <div class="gemini-logo-icon">G</div>
            Admin Panel
        </a>
        
        <div class="gemini-search">
            <input type="text" class="gemini-search-input" placeholder="Qidirish...">
        </div>
        
        <div class="gemini-user">
            <button class="gemini-btn-icon" onclick="toggleTheme()" title="Mavzu">
                <i class="fas fa-palette" id="theme-icon"></i>
            </button>
            <a href="{{ route('admin.students.create') }}" class="gemini-btn">
                <i class="fas fa-plus"></i>
                Yangi
            </a>
        </div>
    </header>

    <aside class="gemini-sidebar">
        <div class="gemini-nav-section">
            <a href="{{ route('admin.dashboard') }}" class="gemini-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Bosh sahifa
            </a>
        </div>

        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Ta'lim</div>
            <a href="{{ route('admin.students.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i>
                O'quvchilar
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i>
                O'qituvchilar
            </a>
            <a href="{{ route('admin.courses.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                Kurslar
            </a>
            <a href="{{ route('admin.groups.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Guruhlar
            </a>
        </div>

        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Boshqaruv</div>
            <a href="{{ route('admin.schedules.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                <i class="fas fa-calendar"></i>
                Jadval
            </a>
            <a href="{{ route('admin.finance.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                Moliya
            </a>
            <a href="{{ route('admin.reports.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                Hisobotlar
            </a>
        </div>
    </aside>

    <main class="gemini-main">
        @if(session('success'))
            <div style="background: #e8f5e8; color: #2e7d32; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #4caf50;">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #ffebee; color: #c62828; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #f44336;">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
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

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</body>
</html>