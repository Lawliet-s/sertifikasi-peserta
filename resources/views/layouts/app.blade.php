<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sertifikasi Peserta</title>
    <!-- Offline Tailwind CSS & Lucide Icons -->
    <script src="{{ asset('vendor/tailwindcss/tailwindcss.js') }}"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        slate: {
                            750: '#293548',
                        }
                    }
                }
            }
        }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="{{ asset('vendor/lucide/lucide.min.js') }}"></script>
</head>
<body class="h-full bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden"></div>

        <!-- Sidebar Kiri (Collapsible di Mobile) -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between transform -translate-x-full md:translate-x-0 md:static transition-transform duration-200 ease-in-out border-r border-slate-800">
            <div>
                <!-- Brand Header -->
                <div class="h-16 flex items-center justify-between px-6 bg-slate-950 border-b border-slate-800">
                    <div class="flex items-center">
                        <i data-lucide="shield-check" class="w-6 h-6 text-indigo-400 mr-3"></i>
                        <span class="font-bold text-white text-lg tracking-wide">Sertifikasi</span>
                    </div>
                    <button id="sidebar-close" aria-label="Tutup Sidebar" class="md:hidden text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <!-- Navigation Menu -->
                <nav class="p-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('skema-sertifikasi.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('skema-sertifikasi*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layers" class="w-5 h-5 mr-3"></i>
                        Skema Sertifikasi
                    </a>
                    <a href="{{ route('peserta.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition {{ request()->routeIs('peserta*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                        Data Peserta
                    </a>
                </nav>
            </div>
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-800 text-xs text-slate-500 text-center">
                Uji Kompetensi JWD &copy; 2026
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header Atas -->
            <header class="h-16 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between px-6 shadow-sm z-10">
                <div class="flex items-center space-x-3">
                    <button id="sidebar-toggle" aria-label="Buka Menu" class="md:hidden p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-slate-800 dark:text-white">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" aria-label="Ubah Tema" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <i data-lucide="sun" class="w-5 h-5 hidden dark:block"></i>
                        <i data-lucide="moon" class="w-5 h-5 block dark:hidden"></i>
                    </button>
                    <!-- User Info & Logout -->
                    <div class="flex items-center space-x-3 border-l border-slate-200 dark:border-slate-700 pl-4">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 hidden sm:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" aria-label="Keluar" class="flex items-center text-sm font-medium text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition">
                                <i data-lucide="log-out" class="w-4 h-4 mr-1.5"></i>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Dynamic Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @if(session('success'))
                    <div role="alert" class="mb-6 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm flex items-center justify-between shadow-sm">
                        <div class="flex items-center">
                            <i data-lucide="check-circle-2" class="w-5 h-5 mr-2 text-emerald-600 dark:text-emerald-400"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div role="alert" class="mb-6 p-4 rounded-lg bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-sm flex items-center justify-between shadow-sm">
                        <div class="flex items-center">
                            <i data-lucide="alert-circle" class="w-5 h-5 mr-2 text-rose-600 dark:text-rose-400"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Sidebar mobile toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarClose.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Dark mode toggle handler
        const themeToggleBtn = document.getElementById('theme-toggle');
        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            // Re-initialize Lucide icons if icons inside button toggle
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
