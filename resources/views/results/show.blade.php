@extends('layouts.app')

@section('title', 'Natija — ' . $submission->student_name)

@push('styles')
<style>
    @keyframes popIn { 0%{transform:scale(0.5);opacity:0} 70%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }
    @keyframes slideUp { from{transform:translateY(30px);opacity:0} to{transform:translateY(0);opacity:1} }
    @keyframes barFill { from{width:0%} to{width:{{ $submission->percentage }}%} }
    @keyframes confettiFall {
        0% { transform: translateY(-10px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
    }
    @keyframes numberCount { from { opacity:0; transform:scale(0.5); } to { opacity:1; transform:scale(1); } }
    @keyframes ringPulse { 0%,100%{ box-shadow: 0 0 0 0 rgba(var(--ring-color), 0.4); } 50%{ box-shadow: 0 0 0 12px rgba(var(--ring-color), 0); } }

    .grade-circle { animation: popIn 0.7s cubic-bezier(0.34,1.56,0.64,1) forwards; }
    .stat-card { animation: slideUp 0.5s ease forwards; opacity: 0; }
    .bar-fill { animation: barFill 1.2s ease 0.5s forwards; width: 0%; }
    .grade-A { --ring-color: 16,185,129; }
    .grade-B { --ring-color: 59,130,246; }
    .grade-C { --ring-color: 245,158,11; }
    .grade-D { --ring-color: 249,115,22; }
    .grade-F { --ring-color: 244,63,94; }

    .confetti-piece {
        position: fixed; top: -10px; width: 10px; height: 10px; border-radius: 2px;
        animation: confettiFall linear forwards;
        pointer-events: none; z-index: 9999;
    }
</style>
@endpush

@section('content')
@php
    $pct = $submission->percentage;
    $grade = $submission->grade;
    $correct = $submission->score;
    $wrong = $submission->total_questions - $submission->score;
    $total = $submission->total_questions;
    $gradeConfig = [
        'A' => ['color'=>'emerald','rgb'=>'16,185,129','from'=>'from-emerald-500','to'=>'to-teal-500','bg'=>'bg-emerald-500/10','border'=>'border-emerald-500/30','text'=>'text-emerald-400','msg'=>'Ajoyib natija! Siz mukammal bajardingiz!','emoji'=>'🏆'],
        'B' => ['color'=>'blue','rgb'=>'59,130,246','from'=>'from-blue-500','to'=>'to-indigo-500','bg'=>'bg-blue-500/10','border'=>'border-blue-500/30','text'=>'text-blue-400','msg'=>'Zo\'r natija! Bir oz ko\'proq mashq qiling.','emoji'=>'🎯'],
        'C' => ['color'=>'amber','rgb'=>'245,158,11','from'=>'from-amber-500','to'=>'to-yellow-400','bg'=>'bg-amber-500/10','border'=>'border-amber-500/30','text'=>'text-amber-400','msg'=>'Yaxshi harakat! Yana o\'rganishda davom eting.','emoji'=>'📚'],
        'D' => ['color'=>'orange','rgb'=>'249,115,22','from'=>'from-orange-500','to'=>'to-amber-500','bg'=>'bg-orange-500/10','border'=>'border-orange-500/30','text'=>'text-orange-400','msg'=>'Ko\'proq mashq kerak. Qaytadan urinib ko\'ring!','emoji'=>'💡'],
        'F' => ['color'=>'rose','rgb'=>'244,63,94','from'=>'from-rose-500','to'=>'to-pink-500','bg'=>'bg-rose-500/10','border'=>'border-rose-500/30','text'=>'text-rose-400','msg'=>'Taslim bo\'lmang! Ko\'proq o\'qib qaytadan urinib ko\'ring.','emoji'=>'💪'],
    ];
    $c = $gradeConfig[$grade];
@endphp

{{-- Confetti for A grade --}}
@if($pct >= 90)
<div id="confetti-container"></div>
@push('scripts')
<script>
(function() {
    const colors = ['#818cf8','#c084fc','#34d399','#fbbf24','#f472b6','#60a5fa'];
    for (let i = 0; i < 80; i++) {
        setTimeout(() => {
            const el = document.createElement('div');
            el.className = 'confetti-piece';
            el.style.left = Math.random() * 100 + 'vw';
            el.style.background = colors[Math.floor(Math.random() * colors.length)];
            el.style.width = (Math.random() * 8 + 6) + 'px';
            el.style.height = (Math.random() * 8 + 6) + 'px';
            el.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
            el.style.animationDuration = (Math.random() * 3 + 2) + 's';
            el.style.animationDelay = Math.random() * 1.5 + 's';
            document.getElementById('confetti-container').appendChild(el);
            setTimeout(() => el.remove(), 6000);
        }, i * 30);
    }
})();
</script>
@endpush
@endif

<div class="max-w-lg mx-auto px-4 py-12">

    {{-- Main result card --}}
    <div class="glass-card rounded-3xl p-8 mb-5 text-center fade-in-up">

        {{-- Grade circle --}}
        <div class="relative inline-flex mb-6">
            <div class="grade-circle grade-{{ $grade }} w-28 h-28 rounded-full border-4 {{ $c['border'] }} {{ $c['bg'] }} flex items-center justify-center"
                 style="animation-delay:0.1s">
                <span class="{{ $c['text'] }} text-5xl font-black" style="line-height:1">{{ $grade }}</span>
            </div>
            <span class="absolute -top-2 -right-2 text-3xl" style="animation: popIn 0.5s 0.6s both;">{{ $c['emoji'] }}</span>
        </div>

        {{-- Name & quiz --}}
        <h1 class="text-2xl font-black text-white mb-1">{{ $submission->student_name }}</h1>
        <p class="text-slate-500 text-sm mb-8">{{ $submission->quiz->title }}</p>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-3 mb-8">
            <div class="stat-card glass-card-light rounded-2xl p-4" style="animation-delay:0.3s">
                <div class="text-3xl font-black text-white mb-1">{{ $correct }}</div>
                <div class="text-emerald-400 text-xs font-medium flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    To'g'ri
                </div>
            </div>
            <div class="stat-card glass-card-light rounded-2xl p-4" style="animation-delay:0.4s">
                <div class="text-3xl font-black text-white mb-1">{{ $wrong }}</div>
                <div class="text-rose-400 text-xs font-medium flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Noto'g'ri
                </div>
            </div>
            <div class="stat-card {{ $c['bg'] }} border {{ $c['border'] }} rounded-2xl p-4" style="animation-delay:0.5s">
                <div class="text-3xl font-black {{ $c['text'] }} mb-1">{{ $pct }}%</div>
                <div class="text-slate-400 text-xs font-medium">Foiz</div>
            </div>
        </div>

        {{-- Progress bar --}}
        <div class="mb-3">
            <div class="h-2.5 bg-slate-800 rounded-full overflow-hidden">
                <div class="bar-fill h-full rounded-full bg-gradient-to-r {{ $c['from'] }} {{ $c['to'] }}"
                     style="box-shadow: 0 0 8px rgba({{ $c['rgb'] }}, 0.5);"></div>
            </div>
        </div>
        <p class="text-slate-600 text-xs">{{ $correct }} / {{ $total }} savol to'g'ri</p>
    </div>

    {{-- Message card --}}
    <div class="glass-card-light border {{ $c['border'] }} rounded-2xl px-6 py-4 mb-5 fade-in-up stagger-2 flex items-center gap-4">
        <div class="text-2xl flex-shrink-0">{{ $c['emoji'] }}</div>
        <p class="{{ $c['text'] }} font-semibold text-sm leading-relaxed">{{ $c['msg'] }}</p>
    </div>

    {{-- Performance breakdown bar --}}
    <div class="glass-card rounded-2xl px-6 py-5 mb-5 fade-in-up stagger-3">
        <p class="text-slate-400 text-xs font-medium uppercase tracking-wider mb-4">Ko'rsatkich</p>
        <div class="space-y-3">
            <div class="flex items-center gap-3">
                <span class="text-slate-500 text-xs w-16">To'g'ri</span>
                <div class="flex-1 h-2 bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-1000"
                         style="width: {{ $total > 0 ? round(($correct/$total)*100) : 0 }}%; animation: barFill 1s 0.7s ease both; width:0%;"
                         class="bar-fill-correct"></div>
                </div>
                <span class="text-emerald-400 text-xs font-bold w-8 text-right">{{ $correct }}</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-slate-500 text-xs w-16">Noto'g'ri</span>
                <div class="flex-1 h-2 bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-rose-500 to-pink-400 rounded-full"
                         style="width: {{ $total > 0 ? round(($wrong/$total)*100) : 0 }}%;"></div>
                </div>
                <span class="text-rose-400 text-xs font-bold w-8 text-right">{{ $wrong }}</span>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3 fade-in-up stagger-4">
        <a href="{{ route('quiz.show', $submission->quiz) }}"
           class="flex-1 text-center font-bold py-4 rounded-2xl text-white transition-all text-sm flex items-center justify-center gap-2 hover:-translate-y-0.5"
           style="background:linear-gradient(135deg,#4f46e5,#7c3aed); box-shadow:0 6px 20px rgba(79,70,229,0.3);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Qayta topshirish
        </a>
        <a href="{{ route('home') }}"
           class="px-5 py-4 glass-card-light hover:border-slate-600 text-slate-300 font-semibold rounded-2xl transition-all text-sm flex items-center gap-2 hover:text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Bosh sahifa
        </a>
    </div>
</div>
@endsection
