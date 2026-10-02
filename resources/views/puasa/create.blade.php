@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Rekod Puasa</h2>
    @if ($errors->any())
        <ul class="mb-4 text-sm text-red-700" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('puasa.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="tahun" class="block text-gray-700">Tahun</label>
            @php
                $tahunDipilih = old('tahun', now()->year);
                $pilihanTahun = collect(range(now()->year, now()->year - 100))
                    ->merge($ringkasanTahunan->keys())
                    ->push($tahunDipilih)
                    ->unique()->sortDesc();
            @endphp
            <select id="tahun" name="tahun" class="w-full border border-gray-300 rounded px-3 py-2" required>
                @foreach ($pilihanTahun as $tahun)
                    <option value="{{ $tahun }}" @selected((string) $tahunDipilih === (string) $tahun)>{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label id="jumlah-label" for="jumlah-paparan" class="block text-gray-700">Jumlah Asal Puasa Tahun Ini</label>
            <input id="jumlah-paparan" type="number" min="1" value="{{ old('jumlah_hari') }}" aria-describedby="jumlah-panduan" class="w-full border border-gray-300 rounded px-3 py-2" required>
            <input id="jumlah-asal" type="hidden" name="jumlah_hari" value="{{ old('jumlah_hari') }}">
            <p id="jumlah-panduan" aria-live="polite" class="mt-1 text-sm text-gray-500">Masukkan jumlah asal puasa yang perlu diganti untuk tahun ini.</p>
        </div>
        <div>
            <label class="block text-gray-700">Hari Diganti Kali Ini</label>
            <input type="number" name="telah_ganti" value="{{ old('telah_ganti', 0) }}" min="0" class="w-full border border-gray-300 rounded px-3 py-2">
            <p class="mt-1 text-sm text-gray-500">Masukkan hari yang diganti dalam rekod ini sahaja. Isi 0 jika baru merekodkan jumlah asal.</p>
        </div>
        <div>
            <label class="block text-gray-700">Tarikh Ganti Puasa</label>
            <input type="date" name="tarikh_ganti" value="{{ old('tarikh_ganti') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div class="flex justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('puasa.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
        </div>
    </form>
</div>
<script>
    (() => {
        const ringkasan = {{ Illuminate\Support\Js::from($ringkasanTahunan) }};
        const tahun = document.getElementById('tahun');
        const paparan = document.getElementById('jumlah-paparan');
        const asal = document.getElementById('jumlah-asal');
        const label = document.getElementById('jumlah-label');
        const panduan = document.getElementById('jumlah-panduan');
        const kemaskini = (kekalkanInput = false) => {
            const rekod = ringkasan[tahun.value];
            const sudahGanti = Boolean(rekod);
            label.textContent = sudahGanti ? 'Jumlah Baki Puasa Tahun Ini' : 'Jumlah Asal Puasa Tahun Ini';
            paparan.readOnly = Boolean(sudahGanti);
            paparan.min = sudahGanti ? '0' : '1';
            if (sudahGanti) {
                paparan.value = Math.max(0, Number(rekod.jumlah_asal) - Number(rekod.jumlah_ganti));
                asal.value = rekod.jumlah_asal;
                panduan.textContent = 'Baki semasa sebelum ditolak hari yang diganti kali ini. Dikira secara automatik.';
            } else {
                if (!kekalkanInput) paparan.value = rekod ? rekod.jumlah_asal : '';
                asal.value = paparan.value;
                panduan.textContent = 'Masukkan jumlah asal puasa yang perlu diganti untuk tahun ini.';
            }
        };
        tahun.addEventListener('change', () => kemaskini());
        paparan.addEventListener('input', () => { if (!paparan.readOnly) asal.value = paparan.value; });
        kemaskini({{ Illuminate\Support\Js::from(old('jumlah_hari') !== null) }});
    })();
</script>
@endsection
