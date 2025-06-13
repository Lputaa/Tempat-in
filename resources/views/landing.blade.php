@extends("layouts.app")

@section("content")

<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <header class="bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6 py-20 text-center">
            <h1 class="text-5xl font-bold text-gray-800 dark:text-white mb-4">Temukan dan Reservasi Tempat Favoritmu</h1>
            <p class="text-gray-600 dark:text-gray-300 text-lg mb-8">Platform reservasi online untuk kafe dan restoran. Pesan meja, pilih menu, dan bayar semua dalam satu aplikasi. </p>
            <div class="mt-8">
                <input type="text" placeholder="Cari restoran atau kafe..." class="px-4 py-3 w-full md:w-1/2 rounded-l-lg border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600" />
                <button class="px-8 rounded-r-lg bg-indigo-600 text-white font-bold p-3 uppercase border-indigo-600 border-t border-b border-r hover:bg-indigo-700">Cari Meja</button>
            </div>
        </div>
    </header>

    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">Reservasi Mudah dalam 3 Langkah</h2>
            <div class="flex flex-wrap text-center">
                <div class="w-full md:w-1/3 p-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-calendar-check text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">1. Reservasi Meja</h3>
                        <p class="text-gray-600 dark:text-gray-300">Pilih restoran, pilih tanggal & waktu, tentukan jumlah orang. </p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-utensils text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">2. Pesan Makanan</h3>
                        <p class="text-gray-600 dark:text-gray-300">Lihat menu restoran, pesan makanan dan minuman. </p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-credit-card text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">3. Pembayaran Online</h3>
                        <p class="text-gray-600 dark:text-gray-300">Bayar menggunakan berbagai metode pembayaran. </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="restaurants" class="py-20 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">Restoran Pilihan Untukmu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg">
                    <img src="https://via.placeholder.com/400x300.png?text=Nama+Restoran" alt="Restaurant Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-gray-800 dark:text-white">Nama Restoran Contoh</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-base mb-4">Deskripsi singkat tentang restoran, jenis masakan, atau suasana.</p>
                        <a href="#" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Lihat Detail & Menu</a>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg">
                    <img src="https://via.placeholder.com/400x300.png?text=Kafe+Asik" alt="Restaurant Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-gray-800 dark:text-white">Kafe Asik</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-base mb-4">Tempat nongkrong yang nyaman dengan kopi terbaik di kota.</p>
                        <a href="#" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Lihat Detail & Menu</a>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg">
                    <img src="https://via.placeholder.com/400x300.png?text=Dapur+Ibu" alt="Restaurant Image" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2 text-gray-800 dark:text-white">Dapur Ibu</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-base mb-4">Menyajikan masakan rumah dengan resep turun-temurun yang otentik.</p>
                        <a href="#" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Lihat Detail & Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="partner" class="bg-indigo-700 text-white">
        <div class="container mx-auto px-6 py-20 text-center">
            <h2 class="text-3xl font-bold mb-4">Jadi Mitra Restoran Kami</h2>
            <p class="text-lg mb-8 text-indigo-200">Kelola reservasi, perbarui ketersediaan meja secara real-time, dan pantau operasional harian melalui dashboard yang praktis. </p>
            <a href="{{ route('partner.register.form') }}" class="bg-white text-indigo-700 font-bold py-3 px-8 rounded-full hover:bg-gray-200 transition-colors duration-300">Gabung Sekarang</a>
        </div>
    </section>

    <footer class="bg-gray-900 dark:bg-black text-white py-10">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="font-bold text-xl mb-2">Tempat-In</h3>
                    <p class="text-gray-400">© 2025 Tempat-In. All rights reserved.</p>
                </div>
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h4 class="font-semibold mb-2">Tautan</h4>
                    <ul>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Hubungi Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="w-full md:w-1/3">
                    <h4 class="font-semibold mb-2">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@endsection