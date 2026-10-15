<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkemaSertifikasiRequest;
use App\Models\SkemaSertifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkemaSertifikasiController extends Controller
{
    public function index(): View
    {
        $skemas = SkemaSertifikasi::withCount('peserta')->latest()->paginate(10);
        return view('skema.index', compact('skemas'));
    }

    public function create(): View
    {
        return view('skema.create');
    }

    public function store(SkemaSertifikasiRequest $request): RedirectResponse
    {
        SkemaSertifikasi::create($request->validated());

        return redirect(route('skema-sertifikasi.index'))->with('success', 'Skema sertifikasi berhasil ditambahkan.');
    }

    public function show(SkemaSertifikasi $skemaSertifikasi): View
    {
        $skemaSertifikasi->load('peserta');
        return view('skema.show', compact('skemaSertifikasi'));
    }

    public function edit(SkemaSertifikasi $skemaSertifikasi): View
    {
        return view('skema.edit', compact('skemaSertifikasi'));
    }

    public function update(SkemaSertifikasiRequest $request, SkemaSertifikasi $skemaSertifikasi): RedirectResponse
    {
        $skemaSertifikasi->update($request->validated());

        return redirect(route('skema-sertifikasi.index'))->with('success', 'Skema sertifikasi berhasil diperbarui.');
    }

    public function destroy(SkemaSertifikasi $skemaSertifikasi): RedirectResponse
    {
        $jumlahPeserta = $skemaSertifikasi->peserta()->count();

        if ($jumlahPeserta > 0) {
            return back()->with('error', "Skema tidak dapat dihapus karena masih digunakan oleh {$jumlahPeserta} peserta.");
        }

        $skemaSertifikasi->delete();

        return redirect(route('skema-sertifikasi.index'))->with('success', 'Skema sertifikasi berhasil dihapus.');
    }
}
