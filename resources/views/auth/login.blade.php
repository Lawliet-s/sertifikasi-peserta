@extends('layouts.auth')

@section('title', 'Masuk Administrator')

@section('content')
<div class="text-center">
    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 mb-4">
        <i data-lucide="lock" class="w-6 h-6"></i>
    </div>
    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Masuk Administrator</h2>
    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Pengelolaan Data Peserta Sertifikasi</p>
</div>

@if($errors->any())
    <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 p-3 rounded-lg text-sm text-rose-700 dark:text-rose-300">
        {{ $errors->first() }}
    </div>
@endif

<form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-750 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-750 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
    </div>

    <div class="flex items-center justify-between text-sm">
        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
            <label for="remember" class="ml-2 block text-slate-700 dark:text-slate-300">Ingat Saya</label>
        </div>
    </div>

    <div>
        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            Masuk
        </button>
    </div>
</form>
@endsection
