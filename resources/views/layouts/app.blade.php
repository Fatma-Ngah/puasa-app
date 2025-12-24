<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puasa System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-lg font-bold text-gray-700">Sistem Puasa Ganti</a>
        <div>
            @auth
                <span class="mr-4 text-gray-600">Hi, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 mr-4">Login</a>
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700">Register</a>
            @endauth
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto py-6 px-4">
        @yield('content')
    </main>

</body>
</html>
