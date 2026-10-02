<?php

namespace App\Http\Controllers;

use App\Models\Puasa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $ringkasanTahunan = Puasa::query()
            ->where('user_id', $request->user()->id)
            ->select('tahun')
            // Jumlah asal tahunan diulang dalam rekod ganti, bukan hutang baharu.
            ->selectRaw('MAX(jumlah_hari) as jumlah_hari')
            ->selectRaw('SUM(telah_ganti) as telah_ganti')
            ->selectRaw('CASE WHEN MAX(jumlah_hari) > SUM(telah_ganti) THEN MAX(jumlah_hari) - SUM(telah_ganti) ELSE 0 END as baki_hari')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        return view('dashboard', [
            'ringkasanTahunan' => $ringkasanTahunan,
            'jumlahBaki' => $ringkasanTahunan->sum('baki_hari'),
        ]);
    }
}
