@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Rekod Ganti Puasa</h2>

        <div class="space-x-2">
            <a href="{{ route('dashboard') }}" 
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                Kembali ke Dashboard
            </a>

            <a href="{{ route('puasa.create') }}" 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                + Tambah Rekod
            </a>
        </div>
</div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Tahun</th>
                    <th class="py-2 px-4 border-b">Jumlah Hari</th>
                    <th class="py-2 px-4 border-b">Telah Ganti</th>
                    <th class="py-2 px-4 border-b">Baki</th>
                    <th class="py-2 px-4 border-b">Tarikh Ganti</th>
                    <th class="py-2 px-4 border-b">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($puasas as $puasa)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $puasa->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ $puasa->jumlah_hari }}</td>
                    <td class="py-2 px-4 border-b">{{ $puasa->telah_ganti }}</td>
                   <td class="py-2 px-4 border-b">
                    <span class="px-2 py-1 rounded text-white {{ $puasa->baki > 0 ? 'bg-red-500' : 'bg-green-500' }}">
                        {{ $puasa->baki }}
                    </span>
                </td>
                    <td class="py-2 px-4 border-b">{{ $puasa->tarikh_ganti ? $puasa->tarikh_ganti->format('d-m-Y') : '-' }}</td>
                    <td class="py-2 px-4 border-b space-x-2">
                        <a href="{{ route('puasa.edit', $puasa) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('puasa.destroy', $puasa) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Padam rekod?')" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Padam</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($puasas->isEmpty())
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Tiada rekod.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
