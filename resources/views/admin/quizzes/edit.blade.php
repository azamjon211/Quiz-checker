@extends('layouts.admin')

@section('title', 'Quizni tahrirlash')
@section('breadcrumb', 'Admin / Quizlar / Tahrirlash')

@section('content')
<div class="max-w-3xl" x-data="quizEditor()" x-init="init()">
    <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" @submit="prepareForm">
        @csrf @method('PUT')

        @if($errors->any())
            <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-6 mb-4">
            <h2 class="text-white font-semibold mb-5 flex items-center gap-2">
                <span class="w-6 h-6 bg-indigo-500/20 border border-indigo-500/30 rounded-lg flex items-center justify-center text-indigo-400 text-xs font-bold">1</span>
                Asosiy ma'lumotlar
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-2">Quiz nomi <span class="text-rose-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required
                           class="w-full bg-slate-900 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-slate-500">
                </div>
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-2">Tavsif</label>
                    <textarea name="description" rows="2"
                              class="w-full bg-slate-900 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition resize-none">{{ old('description', $quiz->description) }}</textarea>
                </div>
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                    <span class="text-slate-300 text-sm">Faol</span>
                </div>
            </div>
        </div>

        <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-white font-semibold flex items-center gap-2">
                    <span class="w-6 h-6 bg-indigo-500/20 border border-indigo-500/30 rounded-lg flex items-center justify-center text-indigo-400 text-xs font-bold">2</span>
                    Javoblarni tahrirlash
                </h2>
                <div class="flex gap-2">
                    @foreach(['A','B','C','D'] as $opt)
                    <button type="button" @click="fillAll('{{ $opt }}')"
                            class="px-3 py-1.5 text-xs font-bold rounded-lg border transition-all
                                   {{ $opt === 'A' ? 'border-blue-500/40 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20' :
                                      ($opt === 'B' ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20' :
                                      ($opt === 'C' ? 'border-amber-500/40 bg-amber-500/10 text-amber-400 hover:bg-amber-500/20' :
                                                      'border-rose-500/40 bg-rose-500/10 text-rose-400 hover:bg-rose-500/20')) }}">
                        {{ $opt }}
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                <template x-for="(q, idx) in questions" :key="idx">
                    <div class="bg-slate-900/80 border border-slate-700 rounded-xl p-3">
                        <div class="text-slate-500 text-xs font-medium mb-2 text-center" x-text="'#' + q.number"></div>
                        <div class="grid grid-cols-4 gap-1 mb-2">
                            <template x-for="opt in ['A','B','C','D']" :key="opt">
                                <button type="button"
                                        @click="q.answer = opt"
                                        :class="q.answer === opt ? getActiveClass(opt) : 'bg-slate-800 text-slate-500 border-slate-700 hover:border-slate-500'"
                                        class="h-7 rounded-lg text-xs font-bold border transition-all">
                                    <span x-text="opt"></span>
                                </button>
                            </template>
                        </div>
                        <input type="text"
                               :value="q.answer"
                               @input="q.answer = $event.target.value"
                               placeholder="yoki matn..."
                               class="w-full bg-slate-700 border border-slate-600 text-white text-xs rounded-lg px-2 py-1.5 focus:outline-none focus:border-indigo-500 transition placeholder-slate-500">
                    </div>
                </template>
            </div>

            <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                A/B/C/D tugmasini bosing yoki matn kiriting (masalan: jumping). Katta-kichik harf farq qilmaydi.
            </div>
        </div>

        <div id="hiddenAnswers"></div>

        <div class="flex gap-3">
            <button type="submit"
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/25">
                O'zgarishlarni saqlash
            </button>
            <a href="{{ route('admin.quizzes.index') }}"
               class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-300 font-semibold rounded-xl transition-colors">
                Bekor qilish
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function quizEditor() {
    const existing = @json($quiz->questions->pluck('correct_answer', 'question_number'));

    return {
        questions: [],

        init() {
            const count = {{ $quiz->question_count }};
            for (let i = 1; i <= count; i++) {
                this.questions.push({ number: i, answer: existing[i] || '' });
            }
        },

        fillAll(opt) {
            this.questions.forEach(q => q.answer = opt);
        },

        getActiveClass(opt) {
            const map = {
                'A': 'bg-blue-500/20 text-blue-400 border-blue-500',
                'B': 'bg-emerald-500/20 text-emerald-400 border-emerald-500',
                'C': 'bg-amber-500/20 text-amber-400 border-amber-500',
                'D': 'bg-rose-500/20 text-rose-400 border-rose-500',
            };
            return map[opt] || '';
        },

        prepareForm(e) {
            const container = document.getElementById('hiddenAnswers');
            container.innerHTML = '';
            this.questions.forEach(q => {
                if (q.answer) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `answers[${q.number}]`;
                    input.value = q.answer;
                    container.appendChild(input);
                }
            });
        }
    }
}
</script>
@endpush
@endsection
