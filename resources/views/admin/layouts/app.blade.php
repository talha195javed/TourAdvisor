<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title') | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                    },
                    animation: {
                        'bounce-gentle': 'bounceGentle 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.3s ease;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
        }

        .active-nav-item {
            position: relative;
        }

        .active-nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #0ea5e9;
            border-radius: 0 4px 4px 0;
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        .sidebar-overlay {
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .construction-alert {
            z-index: 100;
        }

        @keyframes bounceGentle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        @keyframes pulseSoft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .construction-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glow-effect {
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
        }
    </style>
    @livewireStyles
    @livewireScripts
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">

<!-- Under Construction Alert Modal -->
<div id="constructionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 construction-alert hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-500 scale-95 opacity-0">
        <div class="construction-gradient rounded-t-2xl p-6 text-white text-center relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-4 left-4 w-8 h-8 bg-white rounded-full animate-float"></div>
                <div class="absolute top-12 right-8 w-6 h-6 bg-white rounded-full animate-float" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-8 left-12 w-4 h-4 bg-white rounded-full animate-float" style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse-soft">
                    <i class="fas fa-tools text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">Coming Soon!</h3>
                <p class="text-white text-opacity-90">We're building something amazing</p>
            </div>
        </div>

        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce-gentle">
                <i class="fas fa-hammer text-white text-xl"></i>
            </div>

            <h4 class="text-xl font-semibold text-gray-800 mb-3">Module Under Construction</h4>
            <p class="text-gray-600 mb-6 leading-relaxed">
                This feature is currently being developed with care and attention. Our team is working hard to bring you an exceptional experience.
            </p>

            <div class="space-y-3 mb-6">
                <div class="flex items-center justify-center text-sm text-gray-500">
                    <i class="fas fa-clock text-purple-500 mr-2"></i>
                    <span>Expected Launch: Coming Weeks</span>
                </div>
                <div class="flex items-center justify-center text-sm text-gray-500">
                    <i class="fas fa-rocket text-purple-500 mr-2"></i>
                    <span>Innovative Features In Progress</span>
                </div>
            </div>

            <div class="bg-purple-50 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-center space-x-2 text-purple-700">
                    <i class="fas fa-lightbulb"></i>
                    <span class="text-sm font-medium">Stay tuned for updates!</span>
                </div>
            </div>

            <button onclick="closeConstructionModal()" class="w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 glow-effect">
                <i class="fas fa-thumbs-up mr-2"></i>
                Got It - Can't Wait!
            </button>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden sidebar-overlay"></div>

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white shadow-soft flex-shrink-0 flex flex-col fixed md:relative h-full z-50 sidebar-transition transform -translate-x-full md:translate-x-0">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-100 flex items-center">
        <div class="w-10 h-10 rounded-lg gradient-bg flex items-center justify-center text-white font-bold text-xl mr-3">
            A
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Admin Panel</h1>
            <p class="text-xs text-gray-500">Management System</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dashboard</p>
        <a href="/dashboard" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600">
            <i class="fas fa-chart-pie mr-3 text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <div class="pt-4 mt-4 border-t border-gray-100">
            <a href="{{ route('admin.packages.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 active-nav-item {{ request()->routeIs('admin.packages.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                <i class="fas fa-boxes mr-3 text-lg"></i>
                <span class="font-medium">Packages</span>
                <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">5</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 active-nav-item {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                <i class="fas fa-tags mr-3 text-lg"></i>
                <span class="font-medium">Categories</span>
                <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">{{ \App\Models\Category::count() }}</span>
            </a>
            <a href="{{ route('admin.hotels.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 active-nav-item {{ request()->routeIs('admin.hotels.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                <i class="fas fa-hotel mr-3 text-lg"></i>
                <span class="font-medium">Hotels</span>
                <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">12</span>
            </a>
        </div>

        <!-- Additional menu items for a more complete dashboard -->
        <div class="pt-4 mt-4 border-t border-gray-100">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Management</p>
            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 active-nav-item {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                <i class="fas fa-users mr-3 text-lg"></i>
                <span class="font-medium">Users</span>
                <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">{{ \App\Models\User::count() }}</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 construction-link">
                <i class="fas fa-calendar-alt mr-3 text-lg"></i>
                <span class="font-medium">Bookings</span>
                <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Soon</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 construction-link">
                <i class="fas fa-chart-bar mr-3 text-lg"></i>
                <span class="font-medium">Analytics</span>
                <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Soon</span>
            </a>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-100">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">System</p>
            <a href="#" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 construction-link">
                <i class="fas fa-cog mr-3 text-lg"></i>
                <span class="font-medium">Settings</span>
                <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Soon</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 construction-link">
                <i class="fas fa-question-circle mr-3 text-lg"></i>
                <span class="font-medium">Help & Support</span>
                <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Soon</span>
            </a>
        </div>
    </nav>

    <!-- User Section -->
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-800 font-semibold mr-3">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">Administrator</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</aside>

<!-- Mobile header -->
<div class="md:hidden flex items-center justify-between bg-white shadow p-4 text-gray-800 w-full fixed top-0 left-0 z-30">
    <button id="mobile-menu-btn" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div class="flex items-center">
        <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center text-white font-bold text-sm mr-2">
            A
        </div>
        <span class="font-bold text-gray-800">Admin Panel</span>
    </div>
    <div class="relative">
        <button id="notification-btn" class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative">
            <i class="fas fa-bell text-xl text-gray-600"></i>
            <span class="notification-dot"></span>
        </button>
    </div>
</div>

<!-- Main content -->
<div class="flex-1 flex flex-col overflow-auto md:ml-0 pt-16 md:pt-0">
    <!-- Topbar -->
    <header class="bg-white shadow-card p-4 flex justify-between items-center sticky top-0 z-20">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">@yield('page-title')</h1>
            <nav class="flex text-sm text-gray-500 mt-1">
                <a href="#" class="text-primary-600 hover:text-primary-800">Dashboard</a>
                <span class="mx-2">/</span>
                <span>@yield('page-title')</span>
            </nav>
        </div>
        <div class="flex items-center space-x-4">
            <div class="hidden md:flex items-center space-x-3 bg-gray-50 rounded-lg px-4 py-2">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" placeholder="Search..." class="bg-transparent border-none focus:outline-none focus:ring-0 text-sm">
            </div>

            <div class="relative hidden md:block">
                <button id="desktop-notification-btn" class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative">
                    <i class="fas fa-bell text-xl text-gray-600"></i>
                    <span class="notification-dot"></span>
                </button>
            </div>

            <div class="hidden md:flex items-center text-gray-700 border-l border-gray-200 pl-4">
                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-800 font-semibold mr-2">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-medium">Welcome, {{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500">Last login: Today</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="p-6 flex-1 overflow-auto bg-gray-50">
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-500"></i>
            <div>
                <p class="font-medium">Success!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            <button class="ml-auto text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
    }

    mobileMenuBtn.addEventListener('click', toggleSidebar);
    sidebarOverlay.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking on a link (mobile)
    const sidebarLinks = document.querySelectorAll('aside nav a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        });
    });

    // Notification dropdown (simplified for this example)
    const notificationBtns = document.querySelectorAll('#notification-btn, #desktop-notification-btn');
    notificationBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            alert('Notifications would appear here in a real implementation');
        });
    });

    // Under Construction Modal Functions
    function showConstructionModal() {
        const modal = document.getElementById('constructionModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
            modal.querySelector('.transform').classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeConstructionModal() {
        const modal = document.getElementById('constructionModal');
        modal.querySelector('.transform').classList.remove('scale-100', 'opacity-100');
        modal.querySelector('.transform').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Add click event to all construction links
    document.querySelectorAll('.construction-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            showConstructionModal();
        });
    });

    // Close modal when clicking outside
    document.getElementById('constructionModal').addEventListener('click', (e) => {
        if (e.target.id === 'constructionModal') {
            closeConstructionModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeConstructionModal();
        }
    });
</script>

</body>
</html>
