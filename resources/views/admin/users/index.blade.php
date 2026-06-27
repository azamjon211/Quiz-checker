@extends('layouts.admin')

@section('title', 'Adminlar boshqaruvi')
@section('breadcrumb', 'Superadmin / Adminlar')

@section('header-actions')
<a href="{{ route('admin.users.create') }}"
   class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-lg shadow-indigo-500/20">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
    </svg>
    Yangi admin
</a>
@endsection

@section('content')
<div class="space-y-3 max-w-3xl">

    @if(session('error'))
        <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Admin list --}}
    <div class="bg-slate-800/50 border border-slate-700/50 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between">
            <div>
                <h2 class="text-white font-semibold text-sm">Tizim foydalanuvchilari</h2>
                <p class="text-slate-500 text-xs mt-0.5">{{ $admins->count() }} ta foydalanuvchi</p>
            </div>
        </div>

        <div class="divide-y divide-slate-800">
            @foreach($admins as $admin)
            <div x-data="{ resetOpen: false }" class="px-6 py-4">
                <div class="flex items-center justify-between gap-4">
                    {{-- Info --}}
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm flex-shrink-0
                                    {{ $admin->isSuperAdmin() ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/20' : 'bg-indigo-500/10 border border-indigo-500/20 text-indigo-400' }}">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-white font-semibold text-sm">{{ $admin->name }}</span>
                                @if($admin->id === auth()->id())
                                    <span class="text-xs text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded-full border border-indigo-500/20">siz</span>
                                @endif
                            </div>
                            <div class="text-slate-500 text-xs truncate">{{ $admin->email }}</div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold
                                     {{ $admin->isSuperAdmin() ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' }}">
                            {{ $admin->isSuperAdmin() ? '⭐ Superadmin' : 'Admin' }}
                        </span>

                        <span class="text-slate-600 text-xs hidden sm:block">{{ $admin->created_at->format('d.m.Y') }}</span>

                        {{-- Reset password toggle --}}
                        <button @click="resetOpen = !resetOpen"
                                class="p-2 rounded-lg text-slate-500 hover:text-slate-300 hover:bg-slate-700 transition-all"
                                title="Parolni yangilash">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </button>

                        {{-- Delete (not self) --}}
                        @if($admin->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $admin) }}"
                              onsubmit="return confirm('{{ addslashes($admin->name) }} ni o\'chirasizmi?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-2 rounded-lg text-slate-500 hover:text-rose-400 hover:bg-rose-500/10 transition-all"
                                    title="O'chirish">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                {{-- Inline password reset form --}}
                <div x-show="resetOpen" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-3 pt-3 border-t border-slate-700/50">
                    <form method="POST" action="{{ route('admin.users.reset-password', $admin) }}" class="flex gap-3">
                        @csrf
                        <input type="password" name="password" required minlength="8"
                               placeholder="Yangi parol (kamida 8 belgi)"
                               class="flex-1 bg-slate-900 border border-slate-600 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50 transition placeholder-slate-600">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors flex-shrink-0">
                            Saqlash
                        </button>
                        <button type="button" @click="resetOpen = false"
                                class="px-3 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm rounded-xl transition-colors">
                            Bekor
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Info box --}}
    <div class="bg-slate-800/30 border border-slate-700/30 rounded-xl px-5 py-4 flex items-start gap-3">
        <svg class="w-4 h-4 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-slate-500 text-xs leading-relaxed">
            Adminlar test kalitlarini boshqarishi va natijalarni ko'rishi mumkin.
            Superadminni o'chirish va o'zingizni o'chirish mumkin emas.
        </p>
    </div>
</div>
@endsection
