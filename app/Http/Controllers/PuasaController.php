<?php

namespace App\Http\Controllers;

use App\Models\Puasa;
use Illuminate\Http\Request;

class PuasaController extends Controller
{
    public function index()
    {
        $puasas = Puasa::where('user_id', auth()->id())
            ->orderBy('tarikh_ganti', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $bakiTahunan = $puasas->groupBy('tahun')
            ->map(fn ($rekod) => (int) $rekod->max('jumlah_hari'))->all();

        foreach ($puasas as $puasa) {
            $puasa->baki_sebelum = $bakiTahunan[$puasa->tahun];
            $bakiTahunan[$puasa->tahun] = max(0, $puasa->baki_sebelum - $puasa->telah_ganti);
            $puasa->baki_selepas = $bakiTahunan[$puasa->tahun];
        }

        return view('puasa.index', compact('puasas'));
    }

    public function create()
    {
        $ringkasanTahunan = Puasa::where('user_id', auth()->id())
            ->select('tahun')
            ->selectRaw('MAX(jumlah_hari) as jumlah_asal, SUM(telah_ganti) as jumlah_ganti')
            ->groupBy('tahun')
            ->get()
            ->keyBy('tahun');

        return view('puasa.create', compact('ringkasanTahunan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'tarikh_ganti' => 'nullable|date',
            'telah_ganti' => 'nullable|integer|min:0',
        ]);

        $rekodTahun = Puasa::where('user_id', auth()->id())
            ->where('tahun', $request->tahun)
            ->selectRaw('MAX(jumlah_hari) as jumlah_asal, SUM(telah_ganti) as jumlah_ganti')
            ->first();

        $request->validate([
            'jumlah_hari' => ($rekodTahun->jumlah_asal !== null ? 'nullable' : 'required').'|integer|min:1',
        ]);

        Puasa::create([
            'user_id' => auth()->id(),
            'tahun' => $request->tahun,
            'jumlah_hari' => $rekodTahun->jumlah_asal ?? $request->jumlah_hari,
            'telah_ganti' => $request->telah_ganti ?? 0,
            'tarikh_ganti' => $request->tarikh_ganti,
        ]);

        return redirect()->route('puasa.index')
            ->with('success', 'Rekod puasa berjaya ditambah');
    }

    public function edit(Puasa $puasa)
    {
        $this->authorizeOwner($puasa);

        $rekodTahun = Puasa::where('user_id', auth()->id())
            ->where('tahun', $puasa->tahun)
            ->selectRaw('MAX(jumlah_hari) as jumlah_asal, SUM(telah_ganti) as jumlah_ganti')
            ->first();
        $bakiTahunan = max(0, $rekodTahun->jumlah_asal - $rekodTahun->jumlah_ganti);

        return view('puasa.edit', compact('puasa', 'bakiTahunan'));
    }

    public function update(Request $request, Puasa $puasa)
    {
    // Pastikan user ada hak untuk kemaskini
        $this->authorizeOwner($puasa);

        // Validasi input
        $validated = $request->validate([
            'telah_ganti' => 'required|integer|min:0',
            'tarikh_ganti' => 'nullable|date',
        ]);

        // Update rekod
        $puasa->update($validated);

        // Redirect ke index dengan mesej success
        return redirect()->route('puasa.index')
                        ->with('success', 'Rekod puasa berjaya dikemaskini');
 }

    public function destroy(Puasa $puasa)
    {
        $this->authorizeOwner($puasa);

        $puasa->delete();

        return back()->with('success', 'Rekod puasa berjaya dipadam');
    }

    private function authorizeOwner(Puasa $puasa)
    {
        abort_if($puasa->user_id !== auth()->id(), 403);
    }
}
