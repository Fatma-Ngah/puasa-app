@extends('layouts.app')

@section('content')
<div class="space-y-8 text-slate-800">
    <section class="relative overflow-hidden rounded-3xl bg-emerald-950 p-6 text-white shadow-xl shadow-emerald-900/10 sm:p-10">
        <div aria-hidden="true" class="pointer-events-none absolute -right-16 -top-24 h-80 w-80 rounded-full border-[40px] border-emerald-800/40"></div>
        <div class="relative flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
            <div class="max-w-xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-200">Catatan puasa anda</p>
                <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">Sedikit demi sedikit,<br>lengkapkan yang tertinggal.</h1>
                <p class="mt-4 text-sm leading-7 text-emerald-100">Pantau baki puasa mengikut tahun dan catat setiap hari yang berjaya diganti.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('puasa.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-lime-200 px-5 py-3 text-sm font-bold text-emerald-950 transition hover:bg-lime-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white"><span aria-hidden="true" class="text-lg leading-none">+</span> Catat Ganti Puasa</a>
                    <a href="{{ route('puasa.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">Lihat Rekod <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <div class="rounded-2xl border border-emerald-700 bg-emerald-900/70 p-6 lg:min-w-60">
                <p class="text-sm text-emerald-100">Baki keseluruhan</p>
                <p class="mt-2 text-5xl font-bold tracking-tight">{{ number_format($jumlahBaki) }} <span class="text-lg font-normal text-emerald-200">hari</span></p>
                <div class="mt-5 border-t border-emerald-700 pt-4 text-sm text-emerald-100">{{ $ringkasanTahunan->where('baki_hari', 0)->count() }} daripada {{ $ringkasanTahunan->count() }} tahun selesai</div>
            </div>
        </div>
    </section>

    <section aria-labelledby="baki-tahunan">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">Satu hari, satu langkah</p>
                <h2 id="baki-tahunan" class="mt-2 text-2xl font-bold tracking-tight">Baki mengikut tahun</h2>
            </div>
            <span class="rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-500">{{ $ringkasanTahunan->count() }} tahun direkodkan</span>
        </div>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($ringkasanTahunan as $ringkasan)
                @php
                    $kemajuan = $ringkasan->jumlah_hari > 0 ? min(100, max(0, round($ringkasan->telah_ganti / $ringkasan->jumlah_hari * 100))) : 0;
                @endphp
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                    <div class="flex items-center justify-between gap-3">
                        <h3 class="flex items-center gap-3 font-bold"><span aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M8 3v4m8-4v4M4 10h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg></span>Tahun {{ $ringkasan->tahun }}</h3>
                        @if ($ringkasan->baki_hari > 0)
                            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">Belum selesai</span>
                        @else
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Selesai</span>
                        @endif
                    </div>
                    <p class="mt-7 text-5xl font-bold tracking-tight text-emerald-950">{{ number_format($ringkasan->baki_hari) }} <span class="text-base font-medium tracking-normal text-slate-500">hari lagi</span></p>
                    <p class="mt-2 text-sm text-slate-500">{{ $ringkasan->baki_hari > 0 ? 'Puasa yang masih perlu diganti' : 'Semua puasa tahun ini telah diganti' }}</p>
                    <div class="mb-2 mt-7 flex justify-between text-xs font-medium text-slate-600"><span>Kemajuan ganti puasa</span><span class="text-emerald-700">{{ $kemajuan }}%</span></div>
                    <div role="progressbar" aria-label="Kemajuan ganti puasa tahun {{ $ringkasan->tahun }}" aria-valuenow="{{ $kemajuan }}" aria-valuemin="0" aria-valuemax="100" class="h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-emerald-500" style="width: {{ $kemajuan }}%"></div></div>
                    <div class="mt-5 flex justify-between border-t border-slate-100 pt-4 text-sm"><span class="text-slate-500">Jumlah asal <strong class="ml-1 font-semibold text-slate-800">{{ number_format($ringkasan->jumlah_hari) }} hari</strong></span><span class="font-semibold text-emerald-700">{{ number_format($ringkasan->telah_ganti) }} diganti</span></div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-emerald-200 bg-white px-6 py-12 text-center md:col-span-2 xl:col-span-3">
                    <h3 class="text-xl font-bold text-emerald-950">Mulakan catatan pertama anda</h3>
                    <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-slate-500">Belum ada rekod puasa. Tambah rekod untuk melihat baki puasa mengikut tahun.</p>
                    <a href="{{ route('puasa.create') }}" class="mt-6 inline-flex rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800">+ Tambah Rekod</a>
                </div>
            @endforelse
        </div>
    </section>

    @if ($ringkasanTahunan->isNotEmpty())
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" aria-labelledby="ringkasan-tahunan">
            <div class="border-b border-slate-100 px-6 py-5">
                <h2 id="ringkasan-tahunan" class="text-lg font-bold">Ringkasan tahunan</h2>
                <p class="mt-1 text-sm text-slate-500">Semua catatan anda dalam satu pandangan.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Tahun</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Jumlah asal</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Telah diganti</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold">Baki</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($ringkasanTahunan as $ringkasan)
                            <tr class="transition-colors hover:bg-emerald-50/50">
                                <th scope="row" class="px-6 py-5 font-bold">{{ $ringkasan->tahun }}</th>
                                <td class="px-6 py-5 text-right text-slate-600">{{ number_format($ringkasan->jumlah_hari) }} hari</td>
                                <td class="px-6 py-5 text-right text-slate-600">{{ number_format($ringkasan->telah_ganti) }} hari</td>
                                <td class="px-6 py-5 text-right font-bold text-emerald-800">{{ number_format($ringkasan->baki_hari) }} hari</td>
                                <td class="px-6 py-5">
                                    @if ($ringkasan->baki_hari > 0)
                                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800"><span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Belum selesai</span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"><span aria-hidden="true">&#10003;</span>Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif
    <p class="pb-2 text-center text-xs text-slate-500">Setiap usaha kecil membawa anda selangkah lebih dekat.</p>
</div>
@endsection
