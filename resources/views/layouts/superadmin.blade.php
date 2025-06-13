<!DOCTYPE html>
{{-- Tambahkan class 'dark' di sini jika terdeteksi dari localStorage --}}
<html lang="en" class=""> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat-In - Reservasi Kafe & Restoran Online</title>
    
    {{-- SKRIP PENTING UNTUK MENCEGAH FLASH --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{-- Memuat CSS dan JS melalui Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
    <body class="bg-gray-900 text-white">
       <div class="flex h-screen">
        
        {{-- Panggil sidebar dari file partial --}}
        @include('partials.nav_superadmin')

        {{-- Konten utama --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-6 bg-white dark:bg-gray-800 border-b dark:border-gray-700 md:hidden">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-white text-xl font-semibold">Tempat-In</a>
                <button id="mobile-menu-button" class="text-gray-500 dark:text-gray-300 focus:outline-none">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </header>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mobileMenuButton = document.getElementById('mobile-menu-button');

        // Pastikan button ada sebelum menambahkan event listener
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>