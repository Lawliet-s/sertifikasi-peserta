<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesertaRequest;
use App\Models\Peserta;
use App\Models\SkemaSertifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $pesertas = Peserta::with('skema')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peserta.index', compact('pesertas', 'search'));
    }

    public function create(): View
    {
        $skemas = SkemaSertifikasi::all();
        return view('peserta.create', compact('skemas'));
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
        return view('peserta.edit', compact('peserta', 'skemas'));
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
}
