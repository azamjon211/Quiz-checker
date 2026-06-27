<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — QuizChecker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, body { font-family: 'Inter', sans-serif; }

        body { background: #020617; }

        .aurora-a {
            position: fixed; top: -20%; left: -15%; width: 65vw; height: 65vw;
            background: radial-gradient(circle, rgba(79,70,229,0.14) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
            animation: drift1 16s ease-in-out infinite;
        }
        .aurora-b {
            position: fixed; bottom: -20%; right: -10%; width: 55vw; height: 55vw;
            background: radial-gradient(circle, rgba(124,58,237,0.12) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
            animation: drift2 20s ease-in-out infinite;
        }
        @@keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(3%,4%)} }
        @@keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-3%,-3%)} }

        @@keyframes floatLogo { 0%,100%{transform:translateY(0) rotate(-1deg)} 50%{transform:translateY(-8px) rotate(1deg)} }
        .float-logo { animation: floatLogo 4s ease-in-out infinite; }

        @@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .slide-up { animation: slideUp 0.6s ease forwards; }
        .delay-1 { animation-delay: 0.1s; opacity:0; }
        .delay-2 { animation-delay: 0.2s; opacity:0; }
        .delay-3 { animation-delay: 0.3s; opacity:0; }

        .glass-form {
            background: rgba(15,23,42,0.8);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.06);
        }

        .input-field {
            background: rgba(2,6,23,0.7);
            border: 1px solid rgba(51,65,85,0.8);
            color: #f1f5f9;
            transition: all 0.2s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }
        .input-field::placeholder { color: #334155; }

        .submit-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.25s ease;
        }
        .submit-btn:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(79,70,229,0.4);
        }
        .submit-btn:active { transform: translateY(0); }

        /* Grid bg */
        .grid-bg {
            background-image: linear-gradient(rgba(99,102,241,0.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(99,102,241,0.04) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 grid-bg">

    <div class="aurora-a"></div>
    <div class="aurora-b"></div>

    <div class="relative w-full max-w-[400px] z-10">

        {{-- Logo --}}
        <div class="text-center mb-8 slide-up">
            <div class="float-logo inline-flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl shadow-indigo-500/30 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-white tracking-tight">Quiz<span style="background:linear-gradient(135deg,#818cf8,#c084fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Checker</span></h1>
                <p class="text-slate-500 text-sm mt-1">Boshqaruv tizimi</p>
            </div>
        </div>

        {{-- Card --}}
        <div class="glass-form rounded-3xl p-8 shadow-2xl slide-up delay-1">

            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/25 rounded-xl px-4 py-3 flex items-start gap-3">
                    <svg class="w-4 h-4 text-rose-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-rose-400 text-sm">{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf

                <div class="slide-up delay-2">
                    <label class="block text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Email manzil</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="admin@example.com"
                           class="input-field w-full rounded-xl px-4 py-3.5 text-sm">
                </div>

                <div class="slide-up delay-3">
                    <label class="block text-slate-400 text-xs font-semibold uppercase tracking-wider mb-2">Parol</label>
                    <input type="password" name="password" required
                           placeholder="••••••••••"
                           class="input-field w-full rounded-xl px-4 py-3.5 text-sm">
                </div>

                <button type="submit" class="submit-btn w-full text-white font-bold py-3.5 rounded-xl text-sm mt-2 slide-up delay-3">
                    Tizimga kirish
                </button>
            </form>
        </div>

        <div class="text-center mt-6 slide-up delay-3">
            <a href="{{ route('home') }}" class="text-slate-600 text-sm hover:text-slate-400 transition-colors inline-flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Asosiy sahifaga qaytish
            </a>
        </div>

        {{-- Security note --}}
        <div class="mt-8 flex items-center justify-center gap-2 text-slate-700 text-xs slide-up delay-3">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            256-bit shifrlash bilan himoyalangan
        </div>
    </div>

</body>
</html>
