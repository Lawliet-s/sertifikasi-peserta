@extends('layouts.app')

@section('title', 'Detail Peserta')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">{{ $peserta->nama_lengkap }}</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-mono mt-0.5">NIK: {{ $peserta->nik }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $peserta->status->badgeClass() }}">
                {{ $peserta->status->label() }}
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                {{ $peserta->skema->nama_skema ?? '-' }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
        <div>
            <span class="block text-slate-500 dark:text-slate-400 font-medium">Email</span>
            <span class="text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $peserta->email }}</span>
        </div>
        <div>
            <span class="block text-slate-500 dark:text-slate-400 font-medium">Nomor Telepon</span>
            <span class="text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $peserta->no_telepon }}</span>
        </div>
        <div>
            <span class="block text-slate-500 dark:text-slate-400 font-medium">Tanggal Lahir</span>
            <span class="text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $peserta->tanggal_lahir->translatedFormat('d F Y') }}</span>
        </div>
        <div>
            <span class="block text-slate-500 dark:text-slate-400 font-medium">Jenis Kelamin</span>
            <span class="text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $peserta->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
        </div>
        <div class="sm:col-span-2">
            <span class="block text-slate-500 dark:text-slate-400 font-medium">Alamat</span>
            <span class="text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $peserta->alamat }}</span>
        </div>
    </div>

    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200 dark:border-slate-700">
        <a href="{{ route('peserta.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">Kembali</a>
        <a href="{{ route('peserta.edit', $peserta) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium shadow-sm transition">Edit Peserta</a>
    </div>
</div>
@endsection
