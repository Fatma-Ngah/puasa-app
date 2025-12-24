@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card 1: Puasa --}}
        <div class="bg-white p-6 rounded shadow flex flex-col items-center justify-center">
            <h3 class="text-lg font-semibold mb-4">Puasa</h3>
            <p class="text-gray-600 mb-4">Rekod Ganti Puasa bulanan / tahunan</p>
            <a href="{{ route('puasa.index') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                Lihat Rekod Puasa
            </a>
        </div>

        {{-- Card 2: Example Statistik --}}
        <div class="bg-white p-6 rounded shadow flex flex-col items-center justify-center">
            <h3 class="text-lg font-semibold mb-4">Statistik</h3>
            <p class="text-gray-600 mb-4">Jumlah pengguna & laporan</p>
            <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                Lihat Statistik
            </a>
        </div>

        {{-- Card 3: Another Action --}}
        <div class="bg-white p-6 rounded shadow flex flex-col items-center justify-center">
            <h3 class="text-lg font-semibold mb-4">Tetapan</h3>
            <p class="text-gray-600 mb-4">Urus sistem & konfigurasi</p>
            <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                Buka Tetapan
            </a>
        </div>

    </div>
</div>
@endsection
