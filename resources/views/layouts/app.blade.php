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
        <!-- Navbar -->
        @include("partials.header")

        <!-- Content -->
        <main>
            @yield("content")
        </main>

        <!-- Footer -->
        @include("partials.footer")

        <script src="{{ asset("js/app.js") }}"></script>
    </body>
</html>
