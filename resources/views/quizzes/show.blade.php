@extends('layouts.app')

@section('title', $quiz->title . ' — QuizChecker')

@push('styles')
<style>
    .q-row { transition: all 0.2s ease; }
    .q-row.answered { background: rgba(99,102,241,0.06); border-color: rgba(99,102,241,0.2); }
    .q-row.answered .q-num { background: rgba(99,102,241,0.15); border-color: rgba(99,102,241,0.3); color: #818cf8; }

    .opt-btn { width:2.25rem; height:2.25rem; border-radius:0.625rem; border:2px solid; font-weight:700; font-size:0.8rem; transition:all 0.15s cubic-bezier(0.34,1.56,0.64,1); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .opt-btn:hover { transform:scale(1.1); }
    .opt-btn-a { border-color:#334155; color:#64748b; }
    .opt-btn-a:hover { border-color:#3b82f6; color:#3b82f6; background:rgba(59,130,246,0.08); }
    .opt-btn-a.sel { border-color:#3b82f6; color:#3b82f6; background:rgba(59,130,246,0.12); transform:scale(1.12); box-shadow:0 0 12px rgba(59,130,246,0.25); }
    .opt-btn-b { border-color:#334155; color:#64748b; }
    .opt-btn-b:hover { border-color:#10b981; color:#10b981; background:rgba(16,185,129,0.08); }
    .opt-btn-b.sel { border-color:#10b981; color:#10b981; background:rgba(16,185,129,0.12); transform:scale(1.12); box-shadow:0 0 12px rgba(16,185,129,0.25); }
    .opt-btn-c { border-color:#334155; color:#64748b; }
    .opt-btn-c:hover { border-color:#f59e0b; color:#f59e0b; background:rgba(245,158,11,0.08); }
    .opt-btn-c.sel { border-color:#f59e0b; color:#f59e0b; background:rgba(245,158,11,0.12); transform:scale(1.12); box-shadow:0 0 12px rgba(245,158,11,0.25); }
    .opt-btn-d { border-color:#334155; color:#64748b; }
    .opt-btn-d:hover { border-color:#f43f5e; color:#f43f5e; background:rgba(244,63,94,0.08); }
    .opt-btn-d.sel { border-color:#f43f5e; color:#f43f5e; background:rgba(244,63,94,0.12); transform:scale(1.12); box-shadow:0 0 12px rgba(244,63,94,0.25); }

    .text-input-answered { border-color:#7c3aed !important; background:rgba(124,58,237,0.08); color:#a78bfa; }

    .submit-btn { background: linear-gradient(135deg, #4f46e5, #7c3aed); transition: all 0.25s ease; }
    .submit-btn:hover { background: linear-gradient(135deg, #4338ca, #6d28d9); box-shadow: 0 8px 30px rgba(79,70,229,0.4); transform: translateY(-2px); }
    .submit-btn:active { transform: translateY(0); }
</style>
@endpush

@section('content')
@php $questions = $quiz->questions; $total = $quiz->question_count; @endphp

<div class="max-w-2xl mx-auto px-4 py-10" x-data="quizForm()">

    {{-- Sticky progress header --}}
    <div class="sticky top-16 z-40 mb-6">
        <div class="glass-card rounded-2xl px-5 py-3 flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-300 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex-1 min-w-0">
                <div class="text-white text-sm font-semibold truncate">{{ $quiz->title }}</div>
                <div class="flex items-center gap-3 mt-1.5">
                    <div class="flex-1 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500 progress-glow"
                             :style="'width: ' + ({{ $total }} > 0 ? Math.round((countAnswered()/{{ $total }})*100) : 0) + '%'"></div>
                    </div>
                    <span class="text-slate-400 text-xs flex-shrink-0 font-medium tabular-nums">
                        <span x-text="countAnswered()"></span>/{{ $total }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Error --}}
    <div x-show="error" x-cloak
         class="mb-5 bg-rose-500/10 border border-rose-500/25 text-rose-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span x-text="error"></span>
    </div>

    <form x-ref="theForm" method="POST" action="{{ route('quiz.submit', $quiz) }}">
        @csrf

        {{-- Student name --}}
        <div class="glass-card rounded-2xl p-5 mb-4 fade-in-up">
            <label class="block text-slate-300 text-sm font-semibold mb-3">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Ism va familiya
                    <span class="text-rose-400">*</span>
                </span>
            </label>
            <input type="text" name="student_name"
                   placeholder="Masalan: Azamjon Abdulhamidov"
                   value="{{ old('student_name') }}"
                   x-ref="studentName"
                   class="w-full bg-slate-900/60 border border-slate-700 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition placeholder-slate-600">
        </div>

        {{-- Answers --}}
        <div class="glass-card rounded-2xl p-5 mb-5 fade-in-up stagger-1">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-white font-bold text-base">Javoblaringiz</h2>
                <span class="flex items-center gap-1.5 text-xs text-slate-500 bg-slate-800/60 border border-slate-700/50 px-3 py-1.5 rounded-lg">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tugma yoki yozing
                </span>
            </div>

            <div class="space-y-2">
                @foreach($questions as $q)
                @php $n = $q->question_number; @endphp

                <div class="q-row flex items-center gap-3 px-3 py-2.5 rounded-xl border border-slate-800/60"
                     :class="answers['{{ $n }}'] ? 'answered' : ''">

                    {{-- Question number --}}
                    <span class="q-num w-8 h-8 bg-slate-800 border border-slate-700 rounded-lg flex items-center justify-center text-slate-400 text-xs font-bold flex-shrink-0 transition-all">
                        {{ $n }}
                    </span>

                    {{-- Option buttons --}}
                    <div class="flex gap-1.5 flex-shrink-0">
                        <button type="button" @click="pick('{{ $n }}', 'A')"
                                class="opt-btn opt-btn-a"
                                :class="answers['{{ $n }}'] === 'A' ? 'sel' : ''">A</button>
                        <button type="button" @click="pick('{{ $n }}', 'B')"
                                class="opt-btn opt-btn-b"
                                :class="answers['{{ $n }}'] === 'B' ? 'sel' : ''">B</button>
                        <button type="button" @click="pick('{{ $n }}', 'C')"
                                class="opt-btn opt-btn-c"
                                :class="answers['{{ $n }}'] === 'C' ? 'sel' : ''">C</button>
                        <button type="button" @click="pick('{{ $n }}', 'D')"
                                class="opt-btn opt-btn-d"
                                :class="answers['{{ $n }}'] === 'D' ? 'sel' : ''">D</button>
                    </div>

                    <span class="text-slate-700 text-xs flex-shrink-0">yoki</span>

                    {{-- Free text --}}
                    <input type="text"
                           :value="answers['{{ $n }}'] || ''"
                           @input="type('{{ $n }}', $event.target.value)"
                           placeholder="so'z..."
                           class="flex-1 min-w-0 bg-slate-900/40 border border-slate-700/60 rounded-lg px-3 py-1.5 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:border-slate-500 transition"
                           :class="answers['{{ $n }}'] && !isAbcd(answers['{{ $n }}']) ? 'text-input-answered' : ''">

                    <input type="hidden" name="answers[{{ $n }}]" :value="answers['{{ $n }}'] || ''">

                    {{-- Check --}}
                    <div class="w-5 h-5 flex-shrink-0 flex items-center justify-center">
                        <svg x-show="answers['{{ $n }}']" x-cloak class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Submit --}}
        <button type="button" @click="submit()"
                class="submit-btn w-full text-white font-bold py-4 rounded-2xl text-base flex items-center justify-center gap-3 fade-in-up stagger-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Natijani ko'rish
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </button>

        <p class="text-center text-slate-600 text-xs mt-3">
            {{ $total }} ta savoldan <span x-text="countAnswered()" class="text-slate-400 font-medium"></span> tasiga javob berdingiz
        </p>
    </form>
</div>

@push('scripts')
<script>
function quizForm() {
    return {
        answers: {},
        error: '',
        pick(n, opt) {
            this.answers[n] = opt;
            this.error = '';
        },
        type(n, val) {
            if (val.trim() === '') {
                delete this.answers[n];
            } else {
                this.answers[n] = val;
            }
            this.error = '';
        },
        isAbcd(val) {
            return val && ['A','B','C','D'].includes(val.toUpperCase());
        },
        countAnswered() {
            return Object.values(this.answers).filter(v => v && v.trim() !== '').length;
        },
        submit() {
            this.error = '';
            const name = this.$refs.studentName.value.trim();
            if (!name) {
                this.error = 'Iltimos, ismingizni kiriting.';
                this.$refs.studentName.focus();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }
            if (this.countAnswered() === 0) {
                this.error = 'Kamida bitta savolga javob bering.';
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }
            this.$refs.theForm.submit();
        }
    }
}
</script>
@endpush
@endsection
