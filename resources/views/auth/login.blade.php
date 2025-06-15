<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tempat-In</title>
    
    {{-- Skrip penting untuk menerapkan tema (terang/gelap) sebelum halaman render --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    {{-- Memuat aset dari Vite (CSS & JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900">

    <div class="min-h-screen flex flex-col items-center justify-center p-4">

        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <div class="mb-6 text-center">
                <a href="/" class="font-bold text-3xl text-gray-800 dark:text-white">Tempat-In</a>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Selamat datang kembali! Silakan login.</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Input Email --}}
                <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" placeholder="nama@email.com" required="">
                </div>

                {{-- Input Password --}}
                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required="">
                </div>

                {{-- Remember Me & Lupa Password --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                          <input id="remember" type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-indigo-300 dark:bg-gray-700">
                        </div>
                        <div class="ml-3 text-sm">
                          <label for="remember" class="text-gray-500 dark:text-gray-300">Ingat saya</label>
                        </div>
                    </div>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-500">Lupa password?</a>
                </div>

                {{-- Tombol Submit Login --}}
                <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600">Login</button>

                {{-- Link ke Halaman Register --}}
                <p class="mt-6 text-sm font-light text-center text-gray-500 dark:text-gray-400">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline dark:text-indigo-500">Daftar di sini</a>
                </p>

                {{-- Garis Pemisah --}}
                <div class="my-6 flex items-center">
                    <hr class="flex-grow border-t border-gray-300 dark:border-gray-600">
                    <span class="mx-4 text-xs text-gray-400 dark:text-gray-500">Atau</span>
                    <hr class="flex-grow border-t border-gray-300 dark:border-gray-600">
                </div>

                <div class="text-center">
                    <a class="group relative inline-block overflow-hidden border border-indigo-600 px-8 py-3 focus:ring-3 focus:outline-none focus:ring-indigo-300 dark:focus:ring-indigo-800 rounded-md"
                       href="{{ url('/') }}">
                      {{-- Span untuk animasi, sekarang dari kanan --}}
                      <span
                        class="absolute inset-y-0 right-0 w-[2px] bg-indigo-600 transition-all group-hover:w-full group-active:bg-indigo-500"
                      ></span>
                    
                      <span
                        class="relative text-sm font-medium text-indigo-600 transition-colors group-hover:text-white"
                      >
                        Kembali
                      </span>
                    </a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>