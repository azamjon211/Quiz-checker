<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Quiz Checker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item { transition: all 0.2s ease; }
        .sidebar-item:hover, .sidebar-item.active { background: rgba(99,102,241,0.15); color: #818cf8; }
        .sidebar-item.active { border-right: 3px solid #6366f1; }
        @@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        .fade-in { animation: fadeIn 0.3s ease; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-900 min-h-screen flex" x-data="{ sidebarOpen: false }">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false" class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

    {{-- Sidebar --}}
    <aside class="fixed lg:static inset-y-0 left-0 w-64 bg-slate-950 border-r border-slate-800 flex flex-col z-30 transform transition-transform duration-300"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        <div class="p-6 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">Quiz Checker</div>
                    <div class="text-slate-500 text-xs">Admin Panel</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active text-indigo-400 bg-indigo-500/10' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.quizzes.index') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 text-sm font-medium {{ request()->routeIs('admin.quizzes.*') ? 'active text-indigo-400 bg-indigo-500/10' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Test Kalitlari
            </a>
            <a href="{{ route('admin.submissions.index') }}"
               class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 text-sm font-medium {{ request()->routeIs('admin.submissions.*') ? 'active text-indigo-400 bg-indigo-500/10' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Tekshirilgan Natijalar
            </a>

            @if(auth()->user()->isSuperAdmin())
            <div class="pt-3 mt-3 border-t border-slate-800">
                <div class="px-4 mb-1.5 text-xs font-semibold text-amber-500/70 uppercase tracking-wider">Superadmin</div>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'active text-indigo-400 bg-indigo-500/10' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Adminlar
                </a>
            </div>
            @endif

            <div class="pt-3 mt-3 border-t border-slate-800">
                <a href="{{ route('home') }}" target="_blank"
                   class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Saytni ko'rish
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-white text-sm font-medium">{{ auth()->user()->name }}</div>
                    <div class="text-slate-500 text-xs">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-slate-400 text-sm hover:text-rose-400 hover:bg-rose-500/10 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Chiqish
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
        {{-- Top bar --}}
        <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex items-center gap-4 sticky top-0 z-10">
            <button @click="sidebarOpen=true" class="lg:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex-1">
                <h1 class="text-white font-semibold text-lg">@yield('title', 'Dashboard')</h1>
                @hasSection('breadcrumb')
                    <div class="text-slate-500 text-xs mt-0.5">@yield('breadcrumb')</div>
                @endif
            </div>
            @yield('header-actions')
        </header>

        <main class="flex-1 p-6 fade-in">
            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
