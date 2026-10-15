@extends('layouts.auth')

@section('title', 'Sesi Berakhir')

@section('content')
<div class="text-center space-y-4">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400">
        <i data-lucide="clock" class="w-8 h-8"></i>
    </div>
    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">419 - Sesi Berakhir</h2>
    <p class="text-sm text-slate-600 dark:text-slate-400">Halaman atau sesi Anda telah kedaluwarsa karena tidak ada aktivitas. Silakan muat ulang halaman.</p>
    <div class="pt-4">
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
            <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i> Muat Ulang Halaman
        </a>
    </div>
</div>
@endsection
