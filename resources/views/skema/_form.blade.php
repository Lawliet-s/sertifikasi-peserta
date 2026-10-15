@csrf

<div class="space-y-4">
    <div>
        <label for="kode_skema" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Kode Skema</label>
        <input type="text" id="kode_skema" name="kode_skema" value="{{ old('kode_skema', $skemaSertifikasi->kode_skema ?? '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('kode_skema') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
        @error('kode_skema')
            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nama_skema" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Skema</label>
        <input type="text" id="nama_skema" name="nama_skema" value="{{ old('nama_skema', $skemaSertifikasi->nama_skema ?? '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('nama_skema') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
        @error('nama_skema')
            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="deskripsi" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('deskripsi') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $skemaSertifikasi->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200 dark:border-slate-700 mt-6">
    <a href="{{ route('skema-sertifikasi.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">Batal</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">{{ $submitButtonText ?? 'Simpan' }}</button>
</div>
