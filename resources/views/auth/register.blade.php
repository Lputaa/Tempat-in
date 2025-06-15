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
<div class="container mx-auto max-w-md mt-12">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Buat Akun Baru</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <p class="font-bold">Oops! Ada yang salah:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex items-center justify-between">
                <a class="inline-block align-baseline font-bold text-sm text-indigo-500 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200" href="{{ route('login') }}"">
                    Sudah punya akun?
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Daftar
                </button>
            </div>
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
        </form>
    </div>
</div>
</body>
</html>