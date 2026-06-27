<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quiz Checker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        *, body { font-family: 'Inter', sans-serif; }

        .aurora-1 {
            position: fixed; top: -20%; left: -10%; width: 60vw; height: 60vw;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
            animation: drift1 18s ease-in-out infinite;
        }
        .aurora-2 {
            position: fixed; bottom: -10%; right: -10%; width: 50vw; height: 50vw;
            background: radial-gradient(circle, rgba(168,85,247,0.10) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
            animation: drift2 22s ease-in-out infinite;
        }
        .aurora-3 {
            position: fixed; top: 40%; left: 40%; width: 40vw; height: 40vw;
            background: radial-gradient(circle, rgba(59,130,246,0.06) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
            animation: drift3 28s ease-in-out infinite;
        }
        @keyframes drift1 { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(3%,5%) scale(1.05)} 66%{transform:translate(-2%,-3%) scale(0.98)} }
        @keyframes drift2 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-4%,3%) scale(1.08)} }
        @keyframes drift3 { 0%,100%{transform:translate(-50%,-50%) scale(1)} 40%{transform:translate(-52%,-48%) scale(1.1)} 70%{transform:translate(-48%,-52%) scale(0.95)} }

        .glass-card {
            background: rgba(15,23,42,0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.07);
        }
        .glass-card-light {
            background: rgba(30,41,59,0.5);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.06);
        }
        .glow-hover { transition: all 0.3s ease; }
        .glow-hover:hover { box-shadow: 0 0 30px rgba(99,102,241,0.15), 0 20px 40px rgba(0,0,0,0.3); border-color: rgba(99,102,241,0.3) !important; transform: translateY(-3px); }

        .gradient-text { background: linear-gradient(135deg, #818cf8, #c084fc, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .gradient-text-gold { background: linear-gradient(135deg, #fbbf24, #f59e0b, #d97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        .answer-btn { transition: all 0.15s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .answer-btn:hover { transform: scale(1.08); }
        .answer-btn.picked { transform: scale(1.1); }

        @keyframes fadeInUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @keyframes scaleIn { from { opacity:0; transform:scale(0.9); } to { opacity:1; transform:scale(1); } }
        @keyframes slideDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
        @keyframes countUp { from { opacity:0; transform: translateY(10px); } to { opacity:1; transform:translateY(0); } }

        .fade-in-up { animation: fadeInUp 0.5s ease forwards; }
        .fade-in { animation: fadeIn 0.4s ease forwards; }
        .scale-in { animation: scaleIn 0.4s cubic-bezier(0.34,1.56,0.64,1) forwards; }

        .stagger-1 { animation-delay: 0.05s; opacity:0; }
        .stagger-2 { animation-delay: 0.1s; opacity:0; }
        .stagger-3 { animation-delay: 0.15s; opacity:0; }
        .stagger-4 { animation-delay: 0.2s; opacity:0; }

        .progress-glow { box-shadow: 0 0 8px rgba(99,102,241,0.5); }

        /* Quiz row hover */
        .quiz-row { transition: all 0.2s ease; }
        .quiz-row:hover { background: rgba(99,102,241,0.05); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #4f46e5; }

        /* Noise texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-950 min-h-screen text-slate-100">

    <div class="aurora-1"></div>
    <div class="aurora-2"></div>
    <div class="aurora-3"></div>

    {{-- Navigation --}}
    <nav class="relative z-50 border-b border-white/5 backdrop-blur-xl" style="background: rgba(2,6,23,0.7);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg group-hover:shadow-indigo-500/40 transition-shadow">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-white">Quiz<span class="gradient-text">Checker</span></span>
            </a>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1.5 text-xs text-emerald-400 bg-emerald-400/10 border border-emerald-400/20 rounded-full px-3 py-1.5">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                    Tizim ishlayapti
                </div>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-2 text-xs text-slate-400 hover:text-indigo-400 border border-slate-700 hover:border-indigo-500/50 rounded-xl px-3 py-2 transition-all hover:bg-indigo-500/5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Admin
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>

    <footer class="relative z-10 mt-24 border-t border-white/5">
        <div class="max-w-6xl mx-auto px-4 py-10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-slate-500 text-sm font-medium">QuizChecker</span>
            </div>
            <p class="text-slate-600 text-xs">© {{ date('Y') }} — Bilimingizni sinab ko'ring</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
