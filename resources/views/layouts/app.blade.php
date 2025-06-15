<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tempat-In')</title>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @stack('styles')
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">
    
    <div id="app">
        
        {{-- Memuat Navigasi Utama Pengguna dari file partial --}}
            @include('partials.header')
        
        {{-- Konten Utama Halaman --}}
        <main>
            @yield('content')
        </main>



        @include("partials.footer")
        {{-- @include('layouts.partials.footer') --}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @auth
    <script>
        // Logika untuk semua elemen interaktif di navbar
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Pengguna
            const userDropdownButton = document.getElementById('user-dropdown-button');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');
            if (userDropdownButton) {
                userDropdownButton.addEventListener('click', () => {
                    userDropdownMenu.classList.toggle('hidden');
                });
            }

            // Mobile Menu (Hamburger)
            const userMobileMenuButton = document.getElementById('user-mobile-menu-button');
            const userMobileMenu = document.getElementById('user-mobile-menu');
            if (userMobileMenuButton) {
                userMobileMenuButton.addEventListener('click', () => {
                    userMobileMenu.classList.toggle('hidden');
                });
            }

            // Tombol Tema Terang/Gelap
            const themeToggleBtn = document.getElementById('theme-toggle');
            if(themeToggleBtn) {
                const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

                // Tampilkan ikon yang benar saat halaman dimuat
                if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    themeToggleLightIcon.classList.remove('hidden');
                } else {
                    themeToggleDarkIcon.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', function() {
                    themeToggleDarkIcon.classList.toggle('hidden');
                    themeToggleLightIcon.classList.toggle('hidden');

                    if (localStorage.getItem('color-theme')) {
                        if (localStorage.getItem('color-theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                        }
                    } else {
                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                        }
                    }
                });
            }
        });
    </script>
    @endauth

    @stack('scripts')
</body>
</html>