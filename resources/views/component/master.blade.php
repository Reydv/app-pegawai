<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>@yield('title', 'App Pegawai')</title>
</head>

<body class="bg-[#fcfaf8]">
    <header>
        <nav class="sticky top-0 z-50 w-full bg-white border-b border-gray-200">
            <div class="container mx-auto flex justify-between items-center p-4 relative">
                <a href="#" class="text-xl font-semibold text-gray-800">MyKantor</a>

                <a href="{{ route('home') }}"
                    class="absolute left-1/2 -translate-x-1/2 text-3xl font-bold text-gray-700 hover:text-gray-900 transition-all">
                    → KEMBALI KE DASHBOARD ←
                </a>
            </div>
        </nav>


        <main class="bg-[#fcfaf8]">
            @yield('content')
        </main>
    </header>

    {{-- <footer>
        <p>&copy; {{ date('Y') }} App Pegawai</p>
    </footer> --}}
</body>

</html>
