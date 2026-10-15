@extends('layouts.app')

@section('title', 'Import Data Peserta')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">Import Data Peserta dari Excel</h2>
        <a href="{{ route('peserta.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">
            Kembali
        </a>
    </div>

    <!-- Petunjuk dan Unduh Template -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 text-indigo-600 dark:text-indigo-400">
            <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
            <h3 class="font-semibold text-slate-800 dark:text-white text-base">Panduan Pengisian & Format File</h3>
        </div>
        <p class="text-sm text-slate-600 dark:text-slate-300">
            Pastikan file Excel yang diunggah berformat <code class="bg-slate-100 dark:bg-slate-900 px-1.5 py-0.5 rounded text-xs">.xlsx</code>, <code class="bg-slate-100 dark:bg-slate-900 px-1.5 py-0.5 rounded text-xs">.xls</code>, atau <code class="bg-slate-100 dark:bg-slate-900 px-1.5 py-0.5 rounded text-xs">.csv</code> dengan jumlah baris maksimal 500. Kolom <b>NIK</b> dan <b>Nomor Telepon</b> dianjurkan diformat sebagai Text.
        </p>
        <div class="pt-2">
            <a href="{{ route('peserta.import.template') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition shadow-sm">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i> Unduh Template Excel
            </a>
        </div>
    </div>

    <!-- Form Upload -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
        <form action="{{ route('peserta.import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="file" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Pilih File Excel</label>
                <input type="file" id="file" name="file" accept=".xlsx, .xls, .csv" required class="mt-1 block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-950 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 transition border border-slate-300 dark:border-slate-700 rounded-lg p-2">
                @error('file')
                    <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-slate-200 dark:border-slate-700">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition flex items-center">
                    <i data-lucide="upload" class="w-4 h-4 mr-2"></i> Mulai Import
                </button>
            </div>
        </form>
    </div>

    <!-- Jika ada error detail import dari session -->
    @if(session('import_errors'))
        <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 rounded-xl p-6 space-y-3">
            <h3 class="font-bold text-rose-800 dark:text-rose-200 flex items-center">
                <i data-lucide="alert-triangle" class="w-5 h-5 mr-2 text-rose-600"></i> Detail Kegagalan Baris Import
            </h3>
            <div class="overflow-x-auto max-h-60 overflow-y-auto">
                <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                    <thead>
                        <tr class="border-b border-rose-200 dark:border-rose-800">
                            <th class="py-2 px-3">Baris ke-</th>
                            <th class="py-2 px-3">Kolom</th>
                            <th class="py-2 px-3">Pesan Error</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-100 dark:divide-rose-900/50">
                        @foreach(session('import_errors') as $err)
                            <tr>
                                <td class="py-2 px-3 font-mono font-medium">{{ $err['row'] }}</td>
                                <td class="py-2 px-3">{{ $err['attribute'] }}</td>
                                <td class="py-2 px-3 text-rose-600 dark:text-rose-400">{{ implode(', ', $err['errors']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
