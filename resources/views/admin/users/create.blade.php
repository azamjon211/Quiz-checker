@extends('layouts.admin')

@section('title', 'Yangi Admin Qo\'shish')
@section('breadcrumb', 'Admin / Adminlar / Yangi')

@section('content')
<div class="max-w-lg">

    @if($errors->any())
        <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm space-y-1">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-indigo-500/10 border border-indigo-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold">Yangi admin qo'shish</h2>
                <p class="text-slate-400 text-xs mt-0.5">Admin test kalitlarini boshqara oladi</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2">Ism <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="To'liq ism"
                       class="w-full bg-slate-900 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-slate-500">
            </div>
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2">Email <span class="text-rose-400">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="admin@example.com"
                       class="w-full bg-slate-900 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-slate-500">
            </div>
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2">Parol <span class="text-rose-400">*</span></label>
                <input type="password" name="password" required minlength="8"
                       placeholder="Kamida 8 ta belgi"
                       class="w-full bg-slate-900 border border-slate-600 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition placeholder-slate-500">
                <p class="text-slate-500 text-xs mt-1.5">Kamida 8 ta belgi bo'lishi shart</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                    Admin qo'shish
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-3 bg-slate-700 hover:bg-slate-600 text-slate-300 font-semibold rounded-xl transition-colors">
                    Bekor
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
