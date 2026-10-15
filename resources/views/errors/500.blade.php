@extends('layouts.auth')

@section('title', 'Kesalahan Server')

@section('content')
<div class="text-center space-y-4">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rose-50 dark:bg-rose-950 text-rose-600 dark:text-rose-400">
        <i data-lucide="server-crash" class="w-8 h-8"></i>
    </div>
    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">500 - Kesalahan Server</h2>
    <p class="text-sm text-slate-600 dark:text-slate-400">Terjadi kesalahan pada sistem server kami. Silakan coba beberapa saat lagi.</p>
    <div class="pt-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
            <i data-lucide="home" class="w-4 h-4 mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
