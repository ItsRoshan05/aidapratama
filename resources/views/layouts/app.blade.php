<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- DataTables + Lucide CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    
    

    @yield('styles')

</head>
<body class="bg-snow text-gray-800">
    {{-- PRELOADER --}}
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-300">
        <img src="{{ asset('img/logodrhpolos.png') }}" alt="Loading..." class="w-16 h-16 animate-pulse">
    </div>

    {{-- Main Layout --}}
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts.header')

            <main class="flex-1 p-6 bg-gray-50">
                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>

    {{-- Script Section --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- jQuery harus paling pertama --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Preloader --}}
    <script>
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 300); // delay untuk transisi halus
        });
    </script>

    {{-- Dropdown Admin --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Script tambahan per halaman --}}
    @yield('scripts')
</body>
</html>
