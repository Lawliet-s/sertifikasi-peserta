@extends('layouts.app')

@section('title', 'Skema Sertifikasi')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">Daftar Skema Sertifikasi</h2>
        <a href="{{ route('skema-sertifikasi.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Skema
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-750/50 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="py-3 px-6 font-medium">Kode Skema</th>
                        <th class="py-3 px-6 font-medium">Nama Skema</th>
                        <th class="py-3 px-6 font-medium">Jumlah Peserta</th>
                        <th class="py-3 px-6 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($skemas as $skema)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-750/30 transition">
                            <td class="py-3.5 px-6 font-mono font-medium text-slate-800 dark:text-slate-200">{{ $skema->kode_skema }}</td>
                            <td class="py-3.5 px-6 text-slate-800 dark:text-slate-200">{{ $skema->nama_skema }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                                    {{ $skema->peserta_count }} Peserta
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right space-x-2">
                                <a href="{{ route('skema-sertifikasi.show', $skema) }}" class="inline-flex items-center text-slate-600 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('skema-sertifikasi.edit', $skema) }}" class="inline-flex items-center text-slate-600 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400 transition" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('skema-sertifikasi.destroy', $skema) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus skema ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center text-slate-600 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 px-6 text-center text-slate-500 dark:text-slate-400">Belum ada data skema sertifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($skemas->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                {{ $skemas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
