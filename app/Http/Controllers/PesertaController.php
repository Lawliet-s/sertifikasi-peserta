<?php

namespace App\Http\Controllers;

use App\Enums\StatusPeserta;
use App\Exports\PesertaTemplateExport;
use App\Http\Requests\ImportPesertaRequest;
use App\Http\Requests\PesertaRequest;
use App\Imports\PesertaImport;
use App\Models\Peserta;
use App\Models\SkemaSertifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $pesertas = Peserta::with('skema')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Hitung jumlah peserta per status untuk tab filter
        $statusCounts = Peserta::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $totalPeserta = array_sum($statusCounts);

        return view('peserta.index', compact('pesertas', 'search', 'status', 'statusCounts', 'totalPeserta'));
    }

    public function create(): View
    {
        $skemas = SkemaSertifikasi::all();
        $statuses = StatusPeserta::cases();
        return view('peserta.create', compact('skemas', 'statuses'));
    }

    public function store(PesertaRequest $request): RedirectResponse
    {
        Peserta::create($request->validated());

        return redirect(route('peserta.index'))->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function show(Peserta $peserta): View
    {
        $peserta->load('skema');
        return view('peserta.show', compact('peserta'));
    }

    public function edit(Peserta $peserta): View
    {
        $skemas = SkemaSertifikasi::all();
        $statuses = StatusPeserta::cases();
        return view('peserta.edit', compact('peserta', 'skemas', 'statuses'));
    }

    public function update(PesertaRequest $request, Peserta $peserta): RedirectResponse
    {
        $peserta->update($request->validated());

        return redirect(route('peserta.index'))->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Peserta $peserta): RedirectResponse
    {
        $peserta->delete();

        return redirect(route('peserta.index'))->with('success', 'Data peserta berhasil dihapus.');
    }

    // Menampilkan halaman form import Excel
    public function importForm(): View
    {
        return view('peserta.import');
    }

    // Proses import data peserta dari file Excel
    public function importProcess(ImportPesertaRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $import = new PesertaImport();

        try {
            DB::transaction(function () use ($file, $import) {
                Excel::import($import, $file);
            });

            $imported = $import->getImportedCount();
            $failures = $import->getFailures();
            $failedCount = count($failures);

            $message = "Berhasil mengimpor {$imported} data peserta.";
            if ($failedCount > 0) {
                $message .= " Terdapat {$failedCount} baris yang gagal/dilewati.";
            }

            // Simpan kegagalan ke session untuk ditampilkan di view jika ada
            $errorDetails = [];
            $limit = 0;
            foreach ($failures as $failure) {
                if ($limit >= 20) break;
                $errorDetails[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                ];
                $limit++;
            }

            return redirect(route('peserta.index'))
                ->with('success', $message)
                ->with('import_errors', $errorDetails);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    // Mengunduh template Excel untuk import peserta
    public function importTemplate(): BinaryFileResponse
    {
        return Excel::download(new PesertaTemplateExport(), 'template_import_peserta.xlsx');
    }
}
