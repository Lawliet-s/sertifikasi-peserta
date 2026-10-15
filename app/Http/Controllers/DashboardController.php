<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\SkemaSertifikasi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $jumlahPeserta = Peserta::count();
        $jumlahSkema = SkemaSertifikasi::count();
        $pesertaTerbaru = Peserta::with('skema')->latest()->take(5)->get();

        // Statistik jumlah peserta per status (1 query groupBy)
        $statusStats = Peserta::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        return view('dashboard.index', compact('jumlahPeserta', 'jumlahSkema', 'pesertaTerbaru', 'statusStats'));
    }
}
