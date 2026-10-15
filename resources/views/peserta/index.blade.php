@extends('layouts.app')

@section('title', 'Data Peserta')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">Daftar Peserta Sertifikasi</h2>
        <div class="flex items-center space-x-3">
            <form action="{{ route('peserta.index') }}" method="GET" class="flex items-center">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, NIK, email..." class="px-3 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-l-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" aria-label="Cari" class="px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white rounded-r-lg text-sm font-medium transition flex items-center">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                @if(!empty($search) || request('status'))
                    <a href="{{ route('peserta.index') }}" class="ml-2 px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">Reset</a>
                @endif
            </form>
            <a href="{{ route('peserta.import.form') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white text-sm font-medium rounded-lg shadow-sm transition whitespace-nowrap">
                <i data-lucide="upload" class="w-4 h-4 mr-2"></i> Import Excel
            </a>
            <a href="{{ route('peserta.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition whitespace-nowrap">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Peserta
            </a>
        </div>
    </div>

    <!-- Tab Filter Status -->
    <div class="flex flex-wrap gap-2 border-b border-slate-200 dark:border-slate-700 pb-3 text-sm">
        <a href="{{ route('peserta.index', array_merge(request()->except(['status', 'page']), [])) }}" class="px-3.5 py-1.5 rounded-lg font-medium transition {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750' }}">
            Semua ({{ $totalPeserta ?? 0 }})
        </a>
        <a href="{{ route('peserta.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}" class="px-3.5 py-1.5 rounded-lg font-medium transition {{ request('status') === 'pending' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750' }}">
            Pending ({{ $statusCounts['pending'] ?? 0 }})
        </a>
        <a href="{{ route('peserta.index', array_merge(request()->except(['status', 'page']), ['status' => 'terverifikasi'])) }}" class="px-3.5 py-1.5 rounded-lg font-medium transition {{ request('status') === 'terverifikasi' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750' }}">
            Terverifikasi ({{ $statusCounts['terverifikasi'] ?? 0 }})
        </a>
        <a href="{{ route('peserta.index', array_merge(request()->except(['status', 'page']), ['status' => 'lulus'])) }}" class="px-3.5 py-1.5 rounded-lg font-medium transition {{ request('status') === 'lulus' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750' }}">
            Lulus ({{ $statusCounts['lulus'] ?? 0 }})
        </a>
        <a href="{{ route('peserta.index', array_merge(request()->except(['status', 'page']), ['status' => 'tidak_lulus'])) }}" class="px-3.5 py-1.5 rounded-lg font-medium transition {{ request('status') === 'tidak_lulus' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750' }}">
            Tidak Lulus ({{ $statusCounts['tidak_lulus'] ?? 0 }})
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-750/50 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="py-3 px-6 font-medium">Nama Lengkap</th>
                        <th class="py-3 px-6 font-medium">NIK</th>
                        <th class="py-3 px-6 font-medium">Skema</th>
                        <th class="py-3 px-6 font-medium">Status</th>
                        <th class="py-3 px-6 font-medium">Kontak</th>
                        <th class="py-3 px-6 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($pesertas as $peserta)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-750/30 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-800 dark:text-slate-200">{{ $peserta->nama_lengkap }}</td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300 font-mono">{{ $peserta->nik }}</td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300">
                                    {{ $peserta->skema->nama_skema ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $peserta->status->badgeClass() }}">
                                    {{ $peserta->status->label() }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-600 dark:text-slate-300">
                                <div>{{ $peserta->email }}</div>
                                <div class="text-xs text-slate-400">{{ $peserta->no_telepon }}</div>
                            </td>
                            <td class="py-3.5 px-6 text-right space-x-2">
                                <a href="{{ route('peserta.show', $peserta) }}" aria-label="Detail Peserta" class="inline-flex items-center text-slate-600 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('peserta.edit', $peserta) }}" aria-label="Edit Peserta" class="inline-flex items-center text-slate-600 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400 transition" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <button type="button" onclick="openDeleteModal('{{ route('peserta.destroy', $peserta) }}', '{{ $peserta->nama_lengkap }}')" aria-label="Hapus Peserta" class="inline-flex items-center text-slate-600 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 px-6 text-center text-slate-500 dark:text-slate-400">Tidak ada data peserta ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pesertas->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                {{ $pesertas->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Custom Delete Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-2xl max-w-md w-full mx-4 p-6 transform transition-all scale-95 opacity-0 duration-200" id="deleteModalCard">
        <div class="flex items-center space-x-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Konfirmasi Penghapusan</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <p class="text-sm text-slate-600 dark:text-slate-300 mb-6">
            Apakah Anda yakin ingin menghapus data peserta <span id="deleteItemName" class="font-semibold text-slate-800 dark:text-white"></span>?
        </p>
        <div class="flex items-center justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-750 transition">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-sm font-medium shadow-sm transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl, itemName) {
        const modal = document.getElementById('deleteModal');
        const card = document.getElementById('deleteModalCard');
        const form = document.getElementById('deleteForm');
        const nameSpan = document.getElementById('deleteItemName');

        form.action = actionUrl;
        nameSpan.textContent = '"' + itemName + '"';
        modal.classList.remove('hidden');
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const card = document.getElementById('deleteModalCard');
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
</script>
@endsection
