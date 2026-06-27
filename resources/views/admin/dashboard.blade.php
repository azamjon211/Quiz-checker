@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label'=>'Jami quizlar', 'value'=>$stats['total_quizzes'], 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color'=>'indigo'],
                ['label'=>'Faol quizlar', 'value'=>$stats['active_quizzes'], 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color'=>'emerald'],
                ['label'=>'Jami natijalar', 'value'=>$stats['total_submissions'], 'icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color'=>'purple'],
                ['label'=>'Bugun', 'value'=>$stats['today_submissions'], 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color'=>'amber'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="stat-card bg-slate-800/50 border border-slate-700/50 rounded-2xl p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">{{ $card['label'] }}</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $card['value'] }}</p>
                </div>
                <div class="w-10 h-10 bg-{{ $card['color'] }}-500/10 border border-{{ $card['color'] }}-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-{{ $card['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <a href="{{ route('admin.quizzes.create') }}"
           class="group bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 flex items-center gap-4 hover:shadow-lg hover:shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-1">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <div class="text-white font-semibold">Yangi Quiz</div>
                <div class="text-indigo-200 text-sm">Quiz yaratish</div>
            </div>
        </a>
        <a href="{{ route('admin.quizzes.index') }}"
           class="group bg-slate-800 border border-slate-700 rounded-2xl p-6 flex items-center gap-4 hover:border-indigo-500/50 transition-all duration-200 hover:-translate-y-1">
            <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div>
                <div class="text-white font-semibold">Quizlar ro'yxati</div>
                <div class="text-slate-400 text-sm">Barchasini ko'rish</div>
            </div>
        </a>
        <a href="{{ route('admin.submissions.index') }}"
           class="group bg-slate-800 border border-slate-700 rounded-2xl p-6 flex items-center gap-4 hover:border-emerald-500/50 transition-all duration-200 hover:-translate-y-1">
            <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center group-hover:bg-emerald-500/20 transition-colors">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-white font-semibold">Natijalar</div>
                <div class="text-slate-400 text-sm">Barcha javoblar</div>
            </div>
        </a>
    </div>

    {{-- Recent submissions --}}
    <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between">
            <h2 class="text-white font-semibold">So'nggi natijalar</h2>
            <a href="{{ route('admin.submissions.index') }}" class="text-indigo-400 text-sm hover:text-indigo-300 transition-colors">Barchasini ko'rish →</a>
        </div>

        @if($recentSubmissions->isEmpty())
            <div class="p-12 text-center">
                <div class="text-slate-600 text-4xl mb-3">📊</div>
                <p class="text-slate-400 text-sm">Hali hech qanday natija yo'q</p>
            </div>
        @else
            <div class="divide-y divide-slate-700/50">
                @foreach($recentSubmissions as $sub)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-700/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-indigo-500/10 border border-indigo-500/20 rounded-xl flex items-center justify-center text-indigo-400 font-bold text-sm">
                            {{ strtoupper(substr($sub->student_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-white text-sm font-medium">{{ $sub->student_name }}</div>
                            <div class="text-slate-400 text-xs">{{ $sub->quiz->title }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="text-white text-sm font-semibold">{{ $sub->score }}/{{ $sub->total_questions }}</div>
                            <div class="text-slate-400 text-xs">{{ $sub->percentage }}%</div>
                        </div>
                        <span @class([
                            'px-2.5 py-1 rounded-lg text-xs font-bold',
                            'bg-emerald-500/10 text-emerald-400' => $sub->percentage >= 75,
                            'bg-yellow-500/10 text-yellow-400' => $sub->percentage >= 50 && $sub->percentage < 75,
                            'bg-rose-500/10 text-rose-400' => $sub->percentage < 50,
                        ])>{{ $sub->grade }}</span>
                        <a href="{{ route('admin.submissions.show', $sub) }}" class="text-slate-500 hover:text-indigo-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
