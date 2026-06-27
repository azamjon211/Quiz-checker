@extends('layouts.admin')

@section('title', 'Natijalar')
@section('breadcrumb', 'Admin / Natijalar')

@section('content')
<div class="mb-4">
    <form method="GET" class="flex gap-3">
        <select name="quiz_id" onchange="this.form.submit()"
                class="bg-slate-800 border border-slate-600 text-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition">
            <option value="">Barcha quizlar</option>
            @foreach($quizzes as $quiz)
                <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                    {{ $quiz->title }}
                </option>
            @endforeach
        </select>
        @if(request('quiz_id'))
            <a href="{{ route('admin.submissions.index') }}"
               class="px-4 py-2.5 bg-slate-700 text-slate-300 rounded-xl text-sm hover:bg-slate-600 transition-colors flex items-center gap-1">
                ✕ Tozalash
            </a>
        @endif
    </form>
</div>

<div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl overflow-hidden">
    @if($submissions->isEmpty())
        <div class="p-16 text-center">
            <div class="text-5xl mb-4">📊</div>
            <p class="text-slate-400">Hali hech qanday natija yo'q</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-700/50">
                        <th class="text-left px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">#</th>
                        <th class="text-left px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Talaba</th>
                        <th class="text-left px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Quiz</th>
                        <th class="text-center px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Ball</th>
                        <th class="text-center px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Foiz</th>
                        <th class="text-center px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Baho</th>
                        <th class="text-left px-6 py-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Sana</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @foreach($submissions as $sub)
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-6 py-4 text-slate-500 text-sm">{{ $sub->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-indigo-500/10 border border-indigo-500/20 rounded-lg flex items-center justify-center text-indigo-400 font-bold text-xs">
                                    {{ strtoupper(substr($sub->student_name, 0, 1)) }}
                                </div>
                                <span class="text-white text-sm font-medium">{{ $sub->student_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-300 text-sm max-w-xs">
                            <div class="truncate">{{ $sub->quiz->title }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-white font-semibold text-sm">{{ $sub->score }}</span>
                            <span class="text-slate-500 text-xs">/{{ $sub->total_questions }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <div class="w-16 h-1.5 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all
                                                {{ $sub->percentage >= 75 ? 'bg-emerald-500' : ($sub->percentage >= 50 ? 'bg-yellow-500' : 'bg-rose-500') }}"
                                         style="width: {{ $sub->percentage }}%"></div>
                                </div>
                                <span class="text-slate-300 text-sm">{{ $sub->percentage }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span @class([
                                'px-2.5 py-1 rounded-lg text-xs font-bold',
                                'bg-emerald-500/10 text-emerald-400' => $sub->percentage >= 90,
                                'bg-blue-500/10 text-blue-400' => $sub->percentage >= 75 && $sub->percentage < 90,
                                'bg-yellow-500/10 text-yellow-400' => $sub->percentage >= 60 && $sub->percentage < 75,
                                'bg-orange-500/10 text-orange-400' => $sub->percentage >= 45 && $sub->percentage < 60,
                                'bg-rose-500/10 text-rose-400' => $sub->percentage < 45,
                            ])>{{ $sub->grade }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-xs">{{ $sub->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.submissions.show', $sub) }}"
                               class="text-slate-500 hover:text-indigo-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-slate-700/50">
                {{ $submissions->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
