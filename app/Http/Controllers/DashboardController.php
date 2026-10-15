<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\SkemaSertifikasi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard beserta ringkasan data
    public function index(): View
    {
        $jumlahPeserta = Peserta::count();
        $jumlahSkema = SkemaSertifikasi::count();
        $pesertaTerbaru = Peserta::with('skema')->latest()->take(5)->get();

        return view('dashboard.index', compact('jumlahPeserta', 'jumlahSkema', 'pesertaTerbaru'));
    }
}
