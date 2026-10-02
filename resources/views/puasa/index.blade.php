@extends('layouts.app')

@section('content')
<div class="space-y-6 text-slate-800">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded text-sm font-semibold text-emerald-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4"><span aria-hidden="true">&larr;</span> Kembali ke Dashboard</a>

    <header class="relative overflow-hidden rounded-3xl bg-emerald-950 p-6 text-white shadow-lg shadow-emerald-900/10 sm:p-8">
        <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[32px] border-emerald-800/40"></div>
        <div class="relative flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-200">Perjalanan puasa anda</p>
                <h1 class="mt-3 text-3xl font-bold tracking-tight">Rekod Ganti Puasa</h1>
                <p class="mt-3 max-w-lg text-sm leading-6 text-emerald-100">Setiap catatan ialah satu langkah. Semak dan urus rekod puasa yang telah anda ganti di sini.</p>
            </div>
            <a href="{{ route('puasa.create') }}" class="inline-flex w-fit shrink-0 items-center justify-center gap-2 rounded-xl bg-lime-200 px-5 py-3 text-sm font-bold text-emerald-950 transition hover:bg-lime-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white"><span aria-hidden="true" class="text-lg">+</span> Tambah Rekod</a>
        </div>
    </header>

    @if (session('success'))
        <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800"><span aria-hidden="true">&#10003;</span>{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Jumlah catatan</p><p class="mt-2 text-3xl font-bold tracking-tight">{{ number_format($puasas->count()) }} <span class="text-sm font-normal tracking-normal text-slate-500">rekod</span></p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Hari telah diganti</p><p class="mt-2 text-3xl font-bold tracking-tight text-emerald-800">{{ number_format($puasas->sum('telah_ganti')) }} <span class="text-sm font-normal tracking-normal text-slate-500">hari</span></p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Tahun direkodkan</p><p class="mt-2 text-3xl font-bold tracking-tight">{{ $puasas->pluck('tahun')->unique()->count() }} <span class="text-sm font-normal tracking-normal text-slate-500">tahun</span></p></div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" aria-labelledby="senarai-rekod">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-6 py-5">
            <div><h2 id="senarai-rekod" class="text-lg font-bold">Catatan puasa anda</h2><p class="mt-1 text-sm text-slate-500">Disusun mengikut tarikh ganti, paling awal dahulu.</p></div>
            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $puasas->count() }} rekod</span>
        </div>
        @if ($puasas->isEmpty())
            <div class="px-6 py-14 text-center">
                <span aria-hidden="true" class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-3xl text-emerald-700">&#9790;</span>
                <h3 class="mt-5 text-xl font-bold text-emerald-950">Mulakan catatan pertama</h3>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">Belum ada rekod puasa. Catat jumlah puasa anda dan hari yang telah diganti.</p>
                <a href="{{ route('puasa.create') }}" class="mt-6 inline-flex rounded-xl bg-emerald-800 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-900">+ Tambah Rekod</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Tahun puasa</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Baki sebelum ganti</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Diganti kali ini</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Baki selepas ganti</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Tarikh ganti</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($puasas as $puasa)
                            <tr class="transition-colors hover:bg-emerald-50/50">
                                <th scope="row" class="px-6 py-5"><span class="inline-flex rounded-lg bg-slate-100 px-3 py-2 font-bold text-slate-700">{{ $puasa->tahun }}</span></th>
                                <td class="px-6 py-5 text-right text-slate-600">{{ number_format($puasa->baki_sebelum) }} hari</td>
                                <td class="px-6 py-5 text-right font-semibold text-emerald-700">{{ number_format($puasa->telah_ganti) }} hari</td>
                                <td class="px-6 py-5 text-right"><span @class(['inline-flex rounded-full px-3 py-1 text-xs font-semibold', 'bg-amber-50 text-amber-800' => $puasa->baki_selepas > 0, 'bg-emerald-50 text-emerald-700' => $puasa->baki_selepas <= 0])>{{ number_format($puasa->baki_selepas) }} hari</span></td>
                                <td class="px-6 py-5 text-slate-600">{{ $puasa->tarikh_ganti ? $puasa->tarikh_ganti->format('d/m/Y') : 'Belum ditetapkan' }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('puasa.edit', $puasa) }}" aria-label="Edit rekod {{ $puasa->id }} tahun {{ $puasa->tahun }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">Edit</a>
                                        <form action="{{ route('puasa.destroy', $puasa) }}" method="POST" onsubmit="return confirm('Padam rekod ini? Baki puasa akan dikira semula.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="Padam rekod {{ $puasa->id }} tahun {{ $puasa->tahun }}" class="rounded-lg border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:border-red-200 hover:bg-red-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700">Padam</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-xs leading-5 text-slate-500">Baki dikira secara terkumpul mengikut tarikh ganti bagi setiap tahun. Lihat <a href="{{ route('dashboard') }}" class="font-semibold text-emerald-700 underline">dashboard</a> untuk baki terkini setiap tahun.</div>
        @endif
    </section>
</div>
@endsection
