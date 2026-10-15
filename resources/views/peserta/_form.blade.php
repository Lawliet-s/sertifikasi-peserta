@csrf

<div class="space-y-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $peserta->nama_lengkap ?? '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('nama_lengkap') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            @error('nama_lengkap')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nik" class="block text-sm font-medium text-slate-700 dark:text-slate-300">NIK (16 Digit)</label>
            <input type="text" id="nik" name="nik" maxlength="16" inputmode="numeric" pattern="\d{16}" value="{{ old('nik', $peserta->nik ?? '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('nik') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            @error('nik')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $peserta->email ?? '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('email') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            @error('email')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="no_telepon" class="block text-sm font-medium text-slate-700 dark:text-slate-300">No Telepon</label>
            <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $peserta->no_telepon ?? '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('no_telepon') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            @error('no_telepon')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($peserta) && $peserta->tanggal_lahir ? $peserta->tanggal_lahir->format('Y-m-d') : '') }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('tanggal_lahir') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            @error('tanggal_lahir')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('jenis_kelamin') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                <option value="">Pilih...</option>
                <option value="L" {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $peserta->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="skema_sertifikasi_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Skema Sertifikasi</label>
            <select id="skema_sertifikasi_id" name="skema_sertifikasi_id" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('skema_sertifikasi_id') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                <option value="">Pilih Skema...</option>
                @foreach($skemas as $skema)
                    <option value="{{ $skema->id }}" {{ old('skema_sertifikasi_id', $peserta->skema_sertifikasi_id ?? '') == $skema->id ? 'selected' : '' }}>{{ $skema->nama_skema }}</option>
                @endforeach
            </select>
            @error('skema_sertifikasi_id')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
            <select id="status" name="status" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('status') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                @foreach($statuses as $st)
                    <option value="{{ $st->value }}" {{ old('status', $peserta->status->value ?? \App\Enums\StatusPeserta::PENDING->value) == $st->value ? 'selected' : '' }}>
                        {{ $st->label() }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="alamat" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-900 border @error('alamat') border-rose-500 dark:border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">{{ old('alamat', $peserta->alamat ?? '') }}</textarea>
        @error('alamat')
            <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200 dark:border-slate-700 mt-6">
    <a href="{{ route('peserta.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">Batal</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">{{ $submitButtonText ?? 'Simpan' }}</button>
</div>
