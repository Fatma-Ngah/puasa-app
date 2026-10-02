<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puasa System</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f5f7f4] font-sans antialiased">

    {{-- Navbar --}}
    <nav class="flex flex-wrap items-center justify-between gap-4 border-b border-emerald-100 bg-white px-5 py-4 sm:px-8" aria-label="Navigasi utama">
        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center gap-3 text-lg font-bold tracking-tight text-emerald-950"><span aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-900 text-xl text-lime-200">&#9790;</span>Puasa<span class="-ml-2 font-normal text-emerald-700">Ganti</span></a>
        <div class="flex flex-wrap items-center gap-4 text-sm">
            @auth
                <span class="text-slate-600">Salam, <strong class="font-semibold text-slate-800">{{ auth()->user()->name }}</strong></span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-200 px-3 py-2 text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700">Log keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 mr-4">Login</a>
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700">Register</a>
            @endauth
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        @yield('content')
    </main>

</body>
</html>
