<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk | Puasa Ganti</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f7f4] font-sans text-slate-800 antialiased">
    <main class="mx-auto grid min-h-screen max-w-screen-2xl lg:grid-cols-2">
        <section class="relative isolate min-h-72 overflow-hidden bg-emerald-950 lg:min-h-screen" aria-label="Selamat datang ke Puasa Ganti">
            <img src="{{ asset('images/ramadan-login.png') }}" alt="Ilustrasi masjid, bulan sabit dan lentera pada waktu senja" width="1024" height="1536" fetchpriority="high" class="absolute inset-0 -z-20 h-full w-full object-cover object-center">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-emerald-950/70 via-transparent to-emerald-950/90"></div>
            <div class="flex h-full min-h-72 flex-col justify-between gap-12 p-7 sm:p-10 lg:min-h-screen lg:p-12">
                <a href="{{ url('/') }}" class="inline-flex w-fit items-center gap-3 rounded-lg text-xl font-bold tracking-tight text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-lime-200"><span aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/30 text-2xl text-lime-200">&#9790;</span>Puasa<span class="-ml-2 font-normal text-emerald-100">Ganti</span></a>
                <div class="max-w-md text-white">
                    <p class="mb-3 text-xs font-semibold uppercase tracking-[0.2em] text-lime-200">Setiap hari, satu langkah</p>
                    <h1 class="text-3xl font-semibold leading-tight tracking-tight sm:text-4xl lg:text-5xl">Lengkapkan puasa,<br>tenangkan hati.</h1>
                    <p class="mt-4 max-w-sm text-sm leading-7 text-emerald-100">Catat puasa yang diganti dan pantau baki setiap tahun. Mulakan dengan satu hari pada satu masa.</p>
                </div>
            </div>
        </section>

        <section class="flex items-center justify-center px-6 py-12 sm:px-12 lg:py-16" aria-labelledby="login-title">
            <div class="w-full max-w-md">
                <span aria-hidden="true" class="mb-6 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-800"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 0 1 8 0v3M6 10h12a1 1 0 0 1 1 1v9H5v-9a1 1 0 0 1 1-1Zm6 4v2"/></svg></span>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">Ruang peribadi anda</p>
                <h2 id="login-title" class="mt-3 text-3xl font-bold tracking-tight text-emerald-950">Selamat kembali</h2>
                <p class="mt-3 text-sm leading-6 text-slate-500">Log masuk untuk sambung catatan puasa anda.</p>

                <x-auth-session-status class="mt-6 rounded-xl bg-emerald-50 p-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Alamat e-mel</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@contoh.com" @if ($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif class="block w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-slate-400 focus:border-emerald-600 focus:ring-emerald-600">
                        <div id="email-error"><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Kata laluan</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata laluan" @if ($errors->has('password')) aria-invalid="true" aria-describedby="password-error" @endif class="block w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-slate-400 focus:border-emerald-600 focus:ring-emerald-600">
                        <div id="password-error"><x-input-error :messages="$errors->get('password')" class="mt-2" /></div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                        <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2 text-slate-600">
                            <input id="remember_me" type="checkbox" name="remember" @checked(old('remember')) class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                            Ingat saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="rounded font-semibold text-emerald-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-emerald-700">Lupa kata laluan?</a>
                        @endif
                    </div>
                    <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-xl bg-emerald-800 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-emerald-700">Log Masuk <span aria-hidden="true">&rarr;</span></button>
                </form>

                @if (Route::has('register'))
                    <p class="mt-7 text-center text-sm text-slate-500">Belum ada akaun? <a href="{{ route('register') }}" class="rounded font-bold text-emerald-700 hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-emerald-700">Daftar sekarang</a></p>
                @endif
                <p class="mt-10 border-t border-slate-200 pt-6 text-center text-xs leading-5 text-slate-500">Catatan kecil hari ini, langkah bermakna untuk esok.</p>
            </div>
        </section>
    </main>
</body>
</html>
