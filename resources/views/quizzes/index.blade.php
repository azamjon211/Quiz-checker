@extends('layouts.app')

@section('title', 'QuizChecker — Test natijangizni bilib oling')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden pt-20 pb-16 px-4">
    {{-- Grid lines background --}}
    <div class="absolute inset-0 pointer-events-none opacity-20"
         style="background-image: linear-gradient(rgba(99,102,241,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.08) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="max-w-4xl mx-auto text-center relative">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 border border-indigo-500/30 bg-indigo-500/10 rounded-full px-4 py-1.5 text-indigo-300 text-xs font-medium mb-8 fade-in-up">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Tezkor va aniq natija
        </div>

        {{-- Headline --}}
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white leading-[1.05] mb-6 fade-in-up stagger-1">
            Test<br>
            <span class="gradient-text">natijangizni</span><br>
            bilib oling
        </h1>

        <p class="text-slate-400 text-lg sm:text-xl max-w-xl mx-auto mb-10 leading-relaxed fade-in-up stagger-2">
            Testni tanlang, javoblaringizni kiriting va sekundlar ichida ballingizni ko'ring
        </p>

        {{-- Stats row --}}
        <div class="flex items-center justify-center gap-8 sm:gap-12 mb-16 fade-in-up stagger-3">
            <div class="text-center">
                <div class="text-2xl font-black text-white">{{ $quizzes->count() }}</div>
                <div class="text-slate-500 text-xs mt-0.5">Faol test</div>
            </div>
            <div class="w-px h-8 bg-slate-800"></div>
            <div class="text-center">
                <div class="text-2xl font-black text-white">∞</div>
                <div class="text-slate-500 text-xs mt-0.5">Urinish</div>
            </div>
            <div class="w-px h-8 bg-slate-800"></div>
            <div class="text-center">
                <div class="text-2xl font-black text-white">100%</div>
                <div class="text-slate-500 text-xs mt-0.5">Bepul</div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        @if($quizzes->isNotEmpty())
        <div class="flex flex-col items-center gap-2 text-slate-600 text-xs fade-in-up stagger-4">
            <span>Testlarni ko'rish</span>
            <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        @endif
    </div>
</section>

{{-- Quiz cards --}}
<section class="max-w-6xl mx-auto px-4 pb-20">
    @if($quizzes->isEmpty())
        <div class="glass-card rounded-3xl p-20 text-center">
            <div class="w-20 h-20 rounded-3xl bg-slate-800 flex items-center justify-center mx-auto mb-6">
                <svg class="w-9 h-9 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Hozircha testlar yo'q</h3>
            <p class="text-slate-500">Tez orada yangi testlar qo'shiladi</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($quizzes as $i => $quiz)
            <a href="{{ route('quiz.show', $quiz) }}"
               class="glass-card glow-hover rounded-2xl p-6 block group fade-in-up"
               style="animation-delay: {{ $i * 0.06 }}s; opacity:0">

                {{-- Top row --}}
                <div class="flex items-start justify-between mb-5">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/20 flex items-center justify-center group-hover:from-indigo-500/30 group-hover:to-purple-500/30 transition-colors">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center group-hover:bg-indigo-500/10 group-hover:border-indigo-500/30 transition-all">
                        <svg class="w-3.5 h-3.5 text-slate-500 group-hover:text-indigo-400 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                {{-- Title --}}
                <h3 class="text-white font-bold text-lg leading-snug mb-2 group-hover:text-indigo-200 transition-colors">
                    {{ $quiz->title }}
                </h3>

                @if($quiz->description)
                    <p class="text-slate-500 text-sm leading-relaxed mb-5 line-clamp-2">{{ $quiz->description }}</p>
                @else
                    <div class="mb-5"></div>
                @endif

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-4 border-t border-white/5">
                    <div class="flex items-center gap-1.5 text-slate-400 text-sm">
                        <div class="w-6 h-6 rounded-lg bg-slate-800 flex items-center justify-center">
                            <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-300">{{ $quiz->question_count }}</span>
                        <span class="text-slate-600">savol</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-slate-500 text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $quiz->submissions_count }} ishtirokchi
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</section>

{{-- How it works --}}
<section class="relative border-t border-white/5 py-20 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-indigo-400 text-sm font-semibold uppercase tracking-widest mb-3">Qanday ishlaydi?</p>
            <h2 class="text-3xl sm:text-4xl font-black text-white">Faqat 3 qadam</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 relative">
            {{-- Connecting line (desktop) --}}
            <div class="hidden sm:block absolute top-12 left-1/6 right-1/6 h-px bg-gradient-to-r from-transparent via-indigo-500/30 to-transparent"></div>

            @foreach([
                ['num'=>'01', 'color'=>'indigo', 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title'=>'Test tanlang', 'desc'=>'Mavjud testlar ro\'yxatidan keraklisini bosing'],
                ['num'=>'02', 'color'=>'purple', 'icon'=>'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z', 'title'=>'Javob kiriting', 'desc'=>'A/B/C/D tugmalar yoki so\'z bilan javob bering'],
                ['num'=>'03', 'color'=>'violet', 'icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title'=>'Natijani ko\'ring', 'desc'=>'Ball, foiz va baho darhol ko\'rsatiladi'],
            ] as $step)
            <div class="glass-card-light rounded-2xl p-6 text-center">
                <div class="relative inline-flex mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-{{ $step['color'] }}-500/10 border border-{{ $step['color'] }}-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-{{ $step['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-slate-900 border border-slate-700 rounded-full text-xs font-black text-slate-300 flex items-center justify-center">
                        {{ substr($step['num'], 1) }}
                    </span>
                </div>
                <h3 class="text-white font-bold mb-2">{{ $step['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
