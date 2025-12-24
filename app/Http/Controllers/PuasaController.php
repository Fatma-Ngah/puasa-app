<?php

namespace App\Http\Controllers;

use App\Models\Puasa;
use Illuminate\Http\Request;

class PuasaController extends Controller
{
    public function index()
    {
      $puasas = Puasa::where('user_id', auth()->id())
        ->orderBy('tarikh_ganti', 'asc') // order ikut tarikh_ganti naik
        ->get();

        return view('puasa.index', compact('puasas'));
    }

    public function create()
    {
        return view('puasa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'jumlah_hari' => 'required|integer|min:1',
            'tarikh_ganti' => 'nullable|date',
            'telah_ganti' => 'nullable|integer|min:0',
        ]);

        Puasa::create([
            'user_id' => auth()->id(),
            'tahun' => $request->tahun,
            'jumlah_hari' => $request->jumlah_hari,
            'telah_ganti' => $request->telah_ganti ?? 0,
            'tarikh_ganti' => $request->tarikh_ganti,
        ]);

        return redirect()->route('puasa.index')
            ->with('success', 'Rekod puasa berjaya ditambah');
    }

    public function edit(Puasa $puasa)
    {
        $this->authorizeOwner($puasa);

        return view('puasa.edit', compact('puasa'));
    }

    public function update(Request $request, Puasa $puasa)
    {
    // Pastikan user ada hak untuk kemaskini
        $this->authorizeOwner($puasa);

        // Validasi input
        $validated = $request->validate([
            'tahun' => 'required|integer|min:1',
            'jumlah_hari' => 'required|integer|min:1',
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
