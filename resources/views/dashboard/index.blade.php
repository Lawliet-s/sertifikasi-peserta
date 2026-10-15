@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Peserta</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $jumlahPeserta }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Skema Sertifikasi</p>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $jumlahSkema }}</h3>
            </div>
            <div class="w-12 h-12 rounded-lg bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Peserta Terbaru -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800 dark:text-white">Peserta Terbaru</h3>
            <a href="{{ route('peserta.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 flex items-center">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-750/50 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="py-3 px-6 font-medium">Nama Lengkap</th>
                        <th class="py-3 px-6 font-medium">NIK</th>
                        <th class="py-3 px-6 font-medium">Skema Sertifikasi</th>
                        <th class="py-3 px-6 font-medium">No Telepon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($pesertaTerbaru as $peserta)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-750/30 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-800 dark:text-slate-200">{{ $peserta->nama_lengkap }}</td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300 font-mono">{{ $peserta->nik }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                                    {{ $peserta->skema->nama_skema ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300">{{ $peserta->no_telepon }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 px-6 text-center text-slate-500 dark:text-slate-400">Belum ada data peserta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
