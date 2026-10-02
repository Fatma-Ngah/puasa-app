@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Kemaskini Rekod Puasa</h2>

    <form action="{{ route('puasa.update', $puasa) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-gray-700">Tahun</label>
            <input type="number" value="{{ $puasa->tahun }}" class="w-full border border-gray-300 rounded px-3 py-2" readonly>
        </div>
        <div>
            <label class="block text-gray-700">Jumlah Baki Puasa Tahun Ini</label>
            <input type="number" value="{{ $bakiTahunan }}" class="w-full border border-gray-300 rounded px-3 py-2" readonly>
            <p class="mt-1 text-sm text-gray-500">Baki semasa daripada semua rekod tahun ini. Baki dikira semula selepas perubahan disimpan.</p>
        </div>
        <div>
            <label class="block text-gray-700">Hari Diganti Dalam Rekod Ini</label>
            <input type="number" name="telah_ganti" value="{{ $puasa->telah_ganti }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700">Tarikh Ganti Puasa</label>
            <input type="date" name="tarikh_ganti" value="{{ $puasa->tarikh_ganti ? $puasa->tarikh_ganti->format('Y-m-d') : '' }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div class="flex justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Kemaskini</button>
            <a href="{{ route('puasa.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
        </div>
    </form>
</div>
@endsection
