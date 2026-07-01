@extends('layouts.admin')

@section('title', $submission->student_name . ' — Natija')
@section('breadcrumb', 'Admin / Natijalar / #' . $submission->id)

@section('header-actions')
<div class="flex items-center gap-3">
    <a href="{{ route('admin.submissions.index') }}"
       class="text-slate-400 hover:text-white text-sm flex items-center gap-1 transition-colors">
        ← Orqaga
    </a>
    <form method="POST" action="{{ route('admin.submissions.destroy', $submission) }}"
          onsubmit="return confirm('{{ $submission->student_name }} natijasini o\'chirishga ishonchingiz komilmi?')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="flex items-center gap-1.5 px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 hover:text-rose-300 border border-rose-500/20 rounded-lg text-sm transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            O'chirish
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- Header card --}}
    <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    {{ strtoupper(substr($submission->student_name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-white font-bold text-xl">{{ $submission->student_name }}</h2>
                    <p class="text-slate-400 text-sm">{{ $submission->quiz->title }}</p>
                    <p class="text-slate-500 text-xs mt-0.5">{{ $submission->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="text-center">
                    <div class="text-3xl font-black text-white">{{ $submission->score }}<span class="text-slate-500 text-lg font-normal">/{{ $submission->total_questions }}</span></div>
                    <div class="text-slate-400 text-xs mt-0.5">To'g'ri javoblar</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-black text-white">{{ $submission->percentage }}<span class="text-slate-500 text-lg font-normal">%</span></div>
                    <div class="text-slate-400 text-xs mt-0.5">Foiz</div>
                </div>
                <div class="text-center">
                    <div @class([
                        'text-5xl font-black',
                        'text-emerald-400' => $submission->percentage >= 90,
                        'text-blue-400'    => $submission->percentage >= 75 && $submission->percentage < 90,
                        'text-yellow-400'  => $submission->percentage >= 60 && $submission->percentage < 75,
                        'text-orange-400'  => $submission->percentage >= 45 && $submission->percentage < 60,
                        'text-rose-400'    => $submission->percentage < 45,
                    ])>{{ $submission->grade }}</div>
                    <div class="text-slate-400 text-xs mt-0.5">Baho</div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                <span>Natija</span>
                <span>{{ $submission->percentage }}%</span>
            </div>
            <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-1000
                            {{ $submission->percentage >= 75 ? 'bg-gradient-to-r from-emerald-500 to-teal-400' :
                               ($submission->percentage >= 50 ? 'bg-gradient-to-r from-yellow-500 to-amber-400' :
                                                                'bg-gradient-to-r from-rose-500 to-pink-400') }}"
                     style="width: {{ $submission->percentage }}%"></div>
            </div>
        </div>
    </div>

    {{-- Answers detail --}}
    <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700/50">
            <h3 class="text-white font-semibold">Batafsil natijalar</h3>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 p-5">
            @foreach($submission->answers as $answer)
            <div @class([
                'rounded-xl p-3 border text-center',
                'bg-emerald-500/5 border-emerald-500/30' => $answer->is_correct,
                'bg-rose-500/5 border-rose-500/30' => !$answer->is_correct,
            ])>
                <div class="text-slate-500 text-xs mb-2">#{{ $answer->question_number }}</div>
                <div class="flex items-center justify-center gap-2">
                    <span @class([
                        'w-7 h-7 rounded-lg flex items-center justify-center font-bold text-sm',
                        'bg-emerald-500/20 text-emerald-400' => $answer->is_correct,
                        'bg-rose-500/20 text-rose-400' => !$answer->is_correct && $answer->student_answer,
                        'bg-slate-700 text-slate-500' => !$answer->student_answer,
                    ])>{{ $answer->student_answer ?: '—' }}</span>
                    @if(!$answer->is_correct)
                        <span class="text-slate-500 text-xs">→</span>
                        <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm">
                            {{ $answer->correct_answer }}
                        </span>
                    @else
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-6 pb-5 flex items-center gap-6 text-xs text-slate-400">
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 bg-emerald-500/20 border border-emerald-500/30 rounded"></div>
                To'g'ri javob
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 bg-rose-500/20 border border-rose-500/30 rounded"></div>
                Noto'g'ri javob
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 bg-slate-700 rounded"></div>
                Javob berilmagan
            </div>
        </div>
    </div>
</div>
@endsection
