<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran - Tempat-In</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans">
  <nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <a class="text-gray-800 dark:text-white text-xl font-bold md:text-2xl hover:text-gray-700 dark:hover:text-gray-300" href="{{ route('user.dashboard') }}">
                    Tempat-In
                </a>
            </div>

            <div class="flex md:hidden">
                <button id="user-mobile-menu-button" type="button" class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>

            <div id="user-nav-links" class="hidden md:flex md:items-center">
                <div class="flex flex-col md:flex-row md:mx-6">
                    <a class="my-1 text-sm text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 md:mx-4 md:my-0" href="{{ route('restaurants.index') }}">Browse Restoran</a>
                    <a class="my-1 text-sm text-gray-700 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 md:mx-4 md:my-0" href="{{ route('reservations.history') }}">Riwayat Reservasi</a>
                </div>

                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-4">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.121-3.536a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM10 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.464-4.95l-.707-.707a1 1 0 00-1.414 1.414l.707.707a1 1 0 101.414-1.414zm-2.121-3.536a1 1 0 010-1.414l.707-.707a1 1 0 111.414 1.414l-.707-.707a1 1 0 01-1.414 0zM3.536 6.464l.707-.707a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414z"></path></svg>
                </button>

                <div class="relative">
                    <button id="user-dropdown-button" class="relative z-10 flex items-center rounded-md bg-white p-2 focus:outline-none dark:bg-gray-700">
                        <span class="text-sm text-gray-700 dark:text-gray-200">Halo, {{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs ml-2 text-gray-700 dark:text-gray-200"></i>
                    </button>

                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 py-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-xl z-20">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600">
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="user-mobile-menu" class="hidden md:hidden">
            <a href="{{ route('restaurants.index') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 dark:hover:bg-gray-700">Browse Restoran</a>
            <a href="{{ route('reservations.history') }}" class="block py-2 px-4 text-sm hover:bg-gray-200 dark:hover:bg-gray-700">Riwayat Reservasi</a>
            <hr class="my-2 border-gray-200 dark:border-gray-700">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="block py-2 px-4 text-sm text-red-500 hover:bg-gray-200 dark:hover:bg-gray-700">
                    Logout
                </a>
            </form>
        </div>
    </div>
</nav>

    <div class="container mx-auto max-w-lg mt-12 p-4">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
            <div class="text-center mb-6">
                <a href="/" class="font-bold text-2xl text-gray-800 dark:text-white">Tempat-In</a>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white mt-4">Selesaikan Pembayaran Anda</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Reservasi Anda telah kami simpan. Mohon selesaikan pembayaran uang muka untuk mengamankan tempat Anda.</p>
            </div>

            <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Restoran:</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $reservation->restaurant->name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Uang Muka:</span>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400 text-xl">Rp {{ number_format($reservation->down_payment_amount) }}</span>
                </div>
            </div>

            <div class="mt-8">
                <button id="pay-button" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 font-bold text-lg">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      // Logika untuk tombol bayar
      document.addEventListener('DOMContentLoaded', function () {
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
          // Periksa apakah 'snap' ada sebelum memanggilnya
          if (window.snap) {
            window.snap.pay('{{ $reservation->midtrans_token }}', {
              onSuccess: function(result){
                alert("Pembayaran berhasil!"); 
                window.location.href = '{{ route("reservations.history") }}';
              },
              onPending: function(result){
                alert("Menunggu pembayaran Anda.");
                window.location.href = '{{ route("reservations.history") }}';
              },
              onError: function(result){
                alert("Pembayaran gagal!");
                window.location.href = '{{ route("reservations.history") }}';
              },
              onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
              }
            });
          } else {
            alert('Gateway pembayaran gagal dimuat. Periksa koneksi atau ad-blocker Anda.');
          }
        });
      });
    </script>

</body>
</html>