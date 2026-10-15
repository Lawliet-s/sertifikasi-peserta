@extends('layouts.app')

@section('title', 'Detail Skema')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">{{ $skemaSertifikasi->nama_skema }}</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                {{ $skemaSertifikasi->kode_skema }}
            </span>
        </div>
        <p class="text-slate-600 dark:text-slate-300 text-sm mb-6">{{ $skemaSertifikasi->deskripsi ?: 'Tidak ada deskripsi.' }}</p>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200 dark:border-slate-700">
            <a href="{{ route('skema-sertifikasi.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">Kembali</a>
            <a href="{{ route('skema-sertifikasi.edit', $skemaSertifikasi) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium shadow-sm transition">Edit Skema</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700">
            <h3 class="font-semibold text-slate-800 dark:text-white">Daftar Peserta pada Skema Ini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-750/50 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="py-3 px-6 font-medium">Nama Lengkap</th>
                        <th class="py-3 px-6 font-medium">NIK</th>
                        <th class="py-3 px-6 font-medium">Email</th>
                        <th class="py-3 px-6 font-medium">No Telepon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($skemaSertifikasi->peserta as $peserta)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-750/30 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-800 dark:text-slate-200">{{ $peserta->nama_lengkap }}</td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300 font-mono">{{ $peserta->nik }}</td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300">{{ $peserta->email }}</td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300">{{ $peserta->no_telepon }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 px-6 text-center text-slate-500 dark:text-slate-400">Belum ada peserta terdaftar pada skema ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
