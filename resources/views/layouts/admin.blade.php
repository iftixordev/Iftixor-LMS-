<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'O\'quv Markazi Boshqaruv Tizimi')</title>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/gemini-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/enhanced-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/quick-actions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar-toggle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modal-fix.css') }}" rel="stylesheet">
    <link href="{{ asset('css/centered-form.css') }}" rel="stylesheet">
    <style>
    :root{--gemini-bg:#f8f9fa;--gemini-surface:#ffffff;--gemini-border:#dadce0;--gemini-text:#202124;--gemini-text-secondary:#5f6368;--gemini-blue:#1a73e8;--gemini-blue-hover:#1557b0;--gemini-sidebar:#ffffff;--gemini-header:#ffffff;--gemini-hover:#f1f3f4}[data-theme="dark"]{--gemini-bg:#202124;--gemini-surface:#303134;--gemini-border:#5f6368;--gemini-text:#e8eaed;--gemini-text-secondary:#9aa0a6;--gemini-blue:#8ab4f8;--gemini-blue-hover:#aecbfa;--gemini-sidebar:#303134;--gemini-header:#303134;--gemini-hover:#3c4043}*{margin:0;padding:0;box-sizing:border-box}body{font-family:'Google Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:var(--gemini-bg);color:var(--gemini-text);transition:all 0.2s ease}.gemini-header{background:var(--gemini-header);border-bottom:1px solid var(--gemini-border);padding:0 24px;height:64px;display:flex;align-items:center;justify-content:space-between;position:fixed;top:0;left:0;right:0;z-index:1000}.gemini-sidebar{position:fixed;top:64px;left:0;width:280px;height:calc(100vh - 64px);background:var(--gemini-sidebar);border-right:1px solid var(--gemini-border);padding:16px 0;overflow-y:auto}.gemini-main{margin-left:280px;margin-top:64px;padding:32px;min-height:calc(100vh - 64px)}.gemini-card{background:var(--gemini-surface);border:1px solid var(--gemini-border);border-radius:12px;padding:24px;margin-bottom:24px;box-shadow:0 1px 3px rgba(0,0,0,0.1)}.gemini-nav-item{display:flex;align-items:center;padding:12px 24px;color:var(--gemini-text);text-decoration:none;font-size:14px;transition:all 0.2s;border-radius:0 24px 24px 0;margin-right:12px}.gemini-nav-item:hover{background:var(--gemini-hover);color:var(--gemini-text)}.gemini-nav-item.active{background:#e8f0fe;color:var(--gemini-blue);font-weight:500}.gemini-btn{background:var(--gemini-blue);color:white;border:none;padding:10px 24px;border-radius:20px;font-size:14px;font-weight:500;cursor:pointer;transition:all 0.2s;text-decoration:none;display:inline-flex;align-items:center;gap:8px}.gemini-btn:hover{background:var(--gemini-blue-hover);color:white}
    </style>
    @stack('styles')
    <script>
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-collapsed');
        }
        if (localStorage.getItem('header-collapsed') === 'true') {
            document.body.classList.add('header-collapsed');
        }
    </script>
    <script>
        // Prevent flash of unstyled content
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

</head>
<body>
    <!-- Gemini Header -->
    <header class="gemini-header">
        <a href="{{ route('admin.dashboard') }}" class="gemini-logo">
            <div class="gemini-logo-icon">I</div>
            @if(request()->routeIs('admin.dashboard'))
                Iftixor Learning Management System
            @else
                Iftixor LMS
            @endif
        </a>

        <div class="gemini-search" style="position: relative;">
            <input type="text" id="globalSearch" class="gemini-search-input" placeholder="Qidirish..." autocomplete="off">
            <div id="searchResults" style="position: absolute; top: 100%; left: 0; right: 0; background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 8px; max-height: 400px; overflow-y: auto; z-index: 1000; display: none;"></div>
        </div>

        <!-- Branch Selector -->
        <div style="position: relative;">
            <button class="gemini-btn" onclick="toggleBranchMenu()" style="display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-building"></i>
                @php
                    if (session('current_branch_id')) {
                        \DB::setDefaultConnection('sqlite');
                        $currentBranch = App\Models\Branch::find(session('current_branch_id'));
                        $currentBranchName = $currentBranch?->name ?? 'Filial tanlang';
                    } else {
                        $currentBranchName = 'Filial tanlang';
                    }
                @endphp
                <span id="currentBranchName">{{ $currentBranchName }}</span>
                <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
            </button>
            <div id="branchMenu" class="branch-dropdown" style="display: none;">
                @php
                    \DB::setDefaultConnection('sqlite');
                    $branches = App\Models\Branch::where('is_active', true)->get();
                @endphp
                @foreach($branches as $branch)
                <div class="branch-menu-item" onclick="switchBranch({{ $branch->id }}, '{{ $branch->name }}')"
                     style="{{ session('current_branch_id') == $branch->id ? 'background: var(--gemini-hover);' : '' }}">
                    <i class="fas fa-building" style="margin-right: 8px;"></i>
                    {{ $branch->name }}
                    @if($branch->is_main)
                        <span style="margin-left: auto; font-size: 10px; background: var(--gemini-blue); color: white; padding: 2px 6px; border-radius: 4px;">ASOSIY</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <div class="gemini-user">
            <button class="gemini-btn-icon" onclick="toggleTheme()" title="Mavzu">
                <i class="fas fa-palette" id="theme-icon"></i>
            </button>
            <button class="gemini-btn" onclick="showCreateModal()">
                <i class="fas fa-plus"></i>
                Yangi
            </button>
            <div style="position: relative;">
                <button class="gemini-btn-icon" onclick="toggleProfileMenu()" title="Profil">
                    <img src="{{ auth()->user()->photo_url ?? asset('images/default-avatar.svg') }}" 
                         style="width: 32px; height: 32px; border-radius: 50%;" alt="Profile"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--gemini-blue); color: white; display: none; align-items: center; justify-content: center; font-weight: 600; font-size: 14px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </button>
                <div id="profileMenu" class="profile-dropdown" style="display: none;">
                    <div class="profile-header">
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-role">Administrator</div>
                    </div>
                    <div class="profile-menu">
                        <a href="{{ route('admin.profile') }}" class="profile-menu-item">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="profile-menu-item">
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
    
    <style>
    .search-item:hover {
        background-color: #f8f9fa !important;
    }
    #searchResults {
        border-color: var(--claude-border) !important;
        background: var(--claude-card) !important;
    }
    [data-theme="dark"] #searchResults {
        background: var(--claude-card) !important;
        border-color: var(--claude-border) !important;
    }
    [data-theme="dark"] .search-item {
        color: var(--claude-text) !important;
    }
    [data-theme="dark"] .search-item:hover {
        background-color: rgba(255, 124, 46, 0.1) !important;
    }
    </style>
    
    <style>
    .branch-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: var(--gemini-surface);
        border: 1px solid var(--gemini-border);
        border-radius: 8px;
        min-width: 200px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 1000;
        margin-top: 4px;
    }
    .branch-menu-item {
        padding: 12px 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        color: var(--gemini-text);
        border-bottom: 1px solid var(--gemini-border);
    }
    .branch-menu-item:last-child {
        border-bottom: none;
    }
    .branch-menu-item:hover {
        background: var(--gemini-hover);
    }
    </style>
    
    <!-- Gemini Sidebar -->
    <nav class="gemini-sidebar" id="adminSidebar">
        <div class="gemini-nav-section">
            <a href="{{ route('admin.dashboard') }}" class="gemini-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Bosh sahifa
            </a>
            <a href="{{ route('admin.leads.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                Potensial mijozlar
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
            <a href="{{ route('admin.courses.applications') }}" class="gemini-nav-item {{ request()->routeIs('admin.courses.applications') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                Kurs arizalari
            </a>
            <a href="{{ route('admin.groups.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Guruhlar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Jadval</div>
            <a href="{{ route('admin.schedules.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                Dars jadvali
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                Davomat
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Moliya</div>
            <a href="{{ route('admin.finance.payments') }}" class="gemini-nav-item {{ request()->routeIs('admin.finance.payments') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i>
                To'lovlar boshqaruvi
            </a>
            <a href="{{ route('admin.finance.reports') }}" class="gemini-nav-item {{ request()->routeIs('admin.finance.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                Moliyaviy hisobot
            </a>
            <a href="{{ route('admin.expenses.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                Xarajatlar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Aloqa</div>
            <a href="{{ route('admin.messages.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                Xabarlar
            </a>
            <a href="{{ route('admin.video-lessons.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.video-lessons.*') ? 'active' : '' }}">
                <i class="fas fa-video"></i>
                Video darslar
            </a>
            <a href="{{ route('admin.live-streams.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.live-streams.*') ? 'active' : '' }}">
                <i class="fas fa-broadcast-tower"></i>
                Jonli efirlar
            </a>
        </div>
        
        <div class="gemini-nav-section">
            <div class="gemini-nav-title">Boshqaruv</div>
            <a href="{{ route('admin.branches.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.branches.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i>
                Filiallar
            </a>
            <a href="{{ route('admin.certificates.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                <i class="fas fa-certificate"></i>
                Sertifikatlar
            </a>
            <a href="{{ route('admin.gamification.dashboard') }}" class="gemini-nav-item {{ request()->routeIs('admin.gamification.*') ? 'active' : '' }}">
                <i class="fas fa-coins"></i>
                Gamification
            </a>
            <a href="{{ route('admin.reports.index') }}" class="gemini-nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Hisobotlar
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="gemini-main" id="mainContent">
        <!-- Include Notifications Component -->
        @include('components.notifications')

        @if(session('success'))
            <div style="background: var(--gemini-bg); color: var(--gemini-text); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #4caf50; border-left: 4px solid #4caf50;">
                <i class="fas fa-check-circle" style="color: #4caf50;"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: var(--gemini-bg); color: var(--gemini-text); padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #f44336; border-left: 4px solid #f44336;">
                <i class="fas fa-exclamation-circle" style="color: #f44336;"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        @yield('content')
        
        <!-- Floating Action Button -->
        <button class="fab" onclick="showQuickActions()" title="Tezkor amallar">
            <i class="fas fa-plus"></i>
        </button>
        
        <!-- Quick Actions Menu -->
        <div id="quickActionsMenu" style="display: none; position: fixed; bottom: 90px; right: 24px; background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 12px; padding: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); z-index: 1001;">
            <a href="{{ route('admin.students.create') }}" class="quick-action-item">
                <i class="fas fa-user-graduate"></i>
                Yangi o'quvchi
            </a>
            <a href="{{ route('admin.teachers.create') }}" class="quick-action-item">
                <i class="fas fa-chalkboard-teacher"></i>
                Yangi o'qituvchi
            </a>
            <a href="{{ route('admin.courses.create') }}" class="quick-action-item">
                <i class="fas fa-book"></i>
                Yangi kurs
            </a>
            <a href="{{ route('admin.groups.create') }}" class="quick-action-item">
                <i class="fas fa-users"></i>
                Yangi guruh
            </a>
        </div>
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

        // Global Search
        const searchInput = document.getElementById('globalSearch');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data);
                    });
            }, 300);
        });

        function displaySearchResults(results) {
            if (results.length === 0) {
                searchResults.innerHTML = '<div style="padding: 16px; text-align: center; color: var(--gemini-text-secondary);">Natija topilmadi</div>';
            } else {
                searchResults.innerHTML = results.map(result => `
                    <a href="${result.url}" style="display: flex; align-items: center; padding: 12px 16px; text-decoration: none; color: var(--gemini-text); border-bottom: 1px solid var(--gemini-border);" onmouseover="this.style.background='var(--gemini-hover)'" onmouseout="this.style.background='transparent'">
                        <i class="${result.icon}" style="width: 20px; margin-right: 12px; color: var(--gemini-blue);"></i>
                        <div>
                            <div style="font-weight: 500;">${result.title}</div>
                            <div style="font-size: 12px; color: var(--gemini-text-secondary);">${result.subtitle}</div>
                        </div>
                    </a>
                `).join('');
            }
            searchResults.style.display = 'block';
        }

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });

        // Profile menu functions
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Branch menu functions
        function toggleBranchMenu() {
            const menu = document.getElementById('branchMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        function switchBranch(branchId, branchName) {
            fetch('{{ route("admin.branches.switch") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ branch_id: branchId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('branchMenu').style.display = 'none';
                    location.reload();
                }
            });
        }

        // Quick Actions Menu
        function showQuickActions() {
            const menu = document.getElementById('quickActionsMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(e) {
            const profileMenu = document.getElementById('profileMenu');
            const profileButton = e.target.closest('[onclick="toggleProfileMenu()"]');
            const branchMenu = document.getElementById('branchMenu');
            const branchButton = e.target.closest('[onclick="toggleBranchMenu()"]');
            const quickMenu = document.getElementById('quickActionsMenu');
            const fabButton = e.target.closest('.fab');
            
            if (!profileButton && profileMenu && !profileMenu.contains(e.target)) {
                profileMenu.style.display = 'none';
            }
            
            if (!branchButton && branchMenu && !branchMenu.contains(e.target)) {
                branchMenu.style.display = 'none';
            }
            
            if (!fabButton && quickMenu && !quickMenu.contains(e.target)) {
                quickMenu.style.display = 'none';
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/error-handler.js') }}"></script>
    <script src="{{ asset('js/gemini-notifications.js') }}"></script>
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
    <script src="{{ asset('js/modal-handler.js') }}"></script>
    <script>
    // Essential inline JS fallback
    if(typeof $ === 'undefined') {
        console.log('jQuery not loaded, using vanilla JS');
    }
    
    // Modal functionality
    function showModal(id) {
        const modal = document.getElementById(id);
        if(modal) {
            modal.style.display = 'block';
            modal.classList.add('show');
        }
    }
    
    function hideModal(id) {
        const modal = document.getElementById(id);
        if(modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }
    
    // Close modals on backdrop click
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });
    
    // Form submissions
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[data-ajax="true"]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Xatolik yuz berdi');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Xatolik yuz berdi');
                });
            });
        });
    });
    </script>
    
    <!-- Session validation -->
    <script>
        // Check session every 30 seconds
        setInterval(function() {
            fetch('/admin/dashboard', {
                method: 'HEAD',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (response.status === 401) {
                    window.location.href = '/login';
                }
            }).catch(() => {
                // Network error, ignore
            });
        }, 30000);
    </script>
    
    <!-- Auto-show notifications for session messages -->
    <script>
        // Simple notification system
        const notifications = {
            show: function(message, type) {
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
                    border-left: 4px solid ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#ff9800'};
                `;
                
                toast.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}" 
                           style="color: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#ff9800'};"></i>
                        <div style="font-size: 14px; color: var(--gemini-text);">${message}</div>
                    </div>
                `;

                document.body.appendChild(toast);

                // Add animation CSS if not exists
                if (!document.getElementById('toast-animations')) {
                    const style = document.createElement('style');
                    style.id = 'toast-animations';
                    style.textContent = `
                        @keyframes slideIn {
                            from { transform: translateX(100%); opacity: 0; }
                            to { transform: translateX(0); opacity: 1; }
                        }
                    `;
                    document.head.appendChild(style);
                }
                
                // Remove after 5 seconds
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }
        };
        
        @if(session('success'))
            notifications.show('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            notifications.show('{{ session('error') }}', 'error');
        @endif
        @if(session('warning'))
            notifications.show('{{ session('warning') }}', 'warning');
        @endif
    </script>
    
    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nima yaratmoqchisiz?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" onclick="showStudentModal()">
                                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                <span>O'quvchi</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" onclick="showTeacherModal()">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                <span>O'qituvchi</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" onclick="showCourseModal()">
                                <i class="fas fa-book fa-2x mb-2"></i>
                                <span>Kurs</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" onclick="showGroupModal()">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>Guruh</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" onclick="showExpenseModal()">
                                <i class="fas fa-credit-card fa-2x mb-2"></i>
                                <span>Xarajat</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" onclick="showScheduleModal()">
                                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                <span>Jadval</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Create Forms -->
    <div class="modal fade" id="quickCreateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickCreateTitle">Yangi yaratish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickCreateBody">
                    <!-- Dynamic content -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCreateModal() {
            new bootstrap.Modal(document.getElementById('createModal')).show();
        }

        function showStudentModal() {
            document.getElementById('quickCreateTitle').textContent = 'Yangi O\'quvchi';
            document.getElementById('quickCreateBody').innerHTML = `
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ism</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Familiya</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tug'ilgan sana</label>
                            <input type="date" class="form-control" name="birth_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jinsi</label>
                            <select class="form-control" name="gender" required>
                                <option value="male">Erkak</option>
                                <option value="female">Ayol</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ota-ona ismi</label>
                            <input type="text" class="form-control" name="parent_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ota-ona telefoni</label>
                            <input type="text" class="form-control" name="parent_phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ro'yxatga olingan sana</label>
                            <input type="date" class="form-control" name="enrollment_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            `;
            bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
            new bootstrap.Modal(document.getElementById('quickCreateModal')).show();
        }

        function showCourseModal() {
            document.getElementById('quickCreateTitle').textContent = 'Yangi Kurs';
            document.getElementById('quickCreateBody').innerHTML = `
                <form action="{{ route('admin.courses.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kurs nomi</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Davomiyligi (oy)</label>
                            <input type="number" class="form-control" name="duration_months" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Narxi</label>
                            <input type="number" class="form-control" name="price" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Darslar soni</label>
                            <input type="number" class="form-control" name="lessons_count" min="1" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Tavsif</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            `;
            bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
            new bootstrap.Modal(document.getElementById('quickCreateModal')).show();
        }

        function showTeacherModal() {
            window.location.href = '{{ route("admin.teachers.create") }}';
        }

        function showGroupModal() {
            window.location.href = '{{ route("admin.groups.create") }}';
        }

        function showExpenseModal() {
            window.location.href = '{{ route("admin.expenses.create") }}';
        }

        function showScheduleModal() {
            window.location.href = '{{ route("admin.schedules.create") }}';
        }
    </script>

    @yield('scripts')
</body>
</html>