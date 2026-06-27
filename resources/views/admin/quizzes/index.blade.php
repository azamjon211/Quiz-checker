@extends('layouts.admin')

@section('title', 'Test Kalitlari')
@section('breadcrumb', 'Admin / Test Kalitlari')

@section('header-actions')
<a href="{{ route('admin.quizzes.create') }}"
   class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Yangi test kaliti
</a>
@endsection

@section('content')
@if($quizzes->isEmpty())
    <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-16 text-center">
        <div class="text-6xl mb-4">🗝️</div>
        <h3 class="text-white font-semibold text-lg mb-2">Hali test kaliti yo'q</h3>
        <p class="text-slate-400 text-sm mb-6">Birinchi test uchun to'g'ri javoblar kalitini kiriting</p>
        <a href="{{ route('admin.quizzes.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Test kaliti kiritish
        </a>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($quizzes as $quiz)
        <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-5 hover:border-indigo-500/40 transition-all duration-200 hover:-translate-y-1 group">
            <div class="flex items-start justify-between mb-3">
                <span @class([
                    'text-xs font-semibold px-2.5 py-1 rounded-lg',
                    'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' => $quiz->is_active,
                    'bg-slate-700 text-slate-400' => !$quiz->is_active,
                ])>{{ $quiz->is_active ? 'Faol' : 'Nofaol' }}</span>
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}"
                       class="w-8 h-8 bg-slate-700 hover:bg-indigo-500/20 border border-slate-600 hover:border-indigo-500/40 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-400 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}"
                          onsubmit="return confirm('{{ $quiz->title }} quizini o\'chirasizmi?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 bg-slate-700 hover:bg-rose-500/20 border border-slate-600 hover:border-rose-500/40 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-400 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <h3 class="text-white font-semibold text-base mb-1 leading-snug">{{ $quiz->title }}</h3>
            @if($quiz->description)
                <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ $quiz->description }}</p>
            @else
                <div class="mb-4"></div>
            @endif

            <div class="flex items-center justify-between text-sm">
                <div class="flex gap-4">
                    <div class="text-slate-400">
                        <span class="text-white font-semibold">{{ $quiz->question_count }}</span> savol
                    </div>
                    <div class="text-slate-400">
                        <span class="text-white font-semibold">{{ $quiz->submissions_count }}</span> ishtirokchi
                    </div>
                </div>
                <span class="text-slate-500 text-xs">{{ $quiz->created_at->format('d.m.Y') }}</span>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
