@extends("layouts.app")

@section("content")

<body class="bg-gray-50 dark:bg-gray-900 font-sans">
<header class="bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6 py-16 text-center">
        <div class="mx-auto max-w-lg">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white md:text-4xl">Temukan & Reservasi Tempat Favoritmu Berikutnya</h1>
            <p class="mt-6 text-gray-500 dark:text-gray-300">Hindari antrian dan ketidakpastian. Pesan mejamu dengan mudah melalui Tempat-In dan nikmati momen spesial tanpa khawatir.</p>
            <a href="{{ route('register') }}" class="mt-8 inline-block rounded-md bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:bg-indigo-700">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="mt-8 inline-block rounded-md bg-transparent px-8 py-3 text-sm font-medium text-indigo-600 transition hover:text-indigo-700">Login</a>
        </div>
    </div>
</header>

<section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">Reservasi Mudah dalam 3 Langkah</h2>
        <div class="flex flex-wrap text-center">
            <div class="w-full md:w-1/3 p-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-indigo-500 mb-4 inline-block rounded-full bg-indigo-100 p-4 dark:bg-indigo-900">
                        <i class="fas fa-search-location fa-2x"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">1. Cari Restoran</h3>
                    <p class="text-gray-500 dark:text-gray-400">Temukan tempat makan atau kafe yang Anda inginkan berdasarkan lokasi atau nama.</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 transform hover:-translate-y-2 transition-transform duration-300">
                     <div class="text-indigo-500 mb-4 inline-block rounded-full bg-indigo-100 p-4 dark:bg-indigo-900">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">2. Pilih & Pesan</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pilih tanggal, waktu, dan paket atau menu yang tersedia untuk dipesan di muka.</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-indigo-500 mb-4 inline-block rounded-full bg-indigo-100 p-4 dark:bg-indigo-900">
                        <i class="fas fa-credit-card fa-2x"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">3. Bayar & Nikmati</h3>
                    <p class="text-gray-500 dark:text-gray-400">Selesaikan pembayaran uang muka dengan aman dan reservasi Anda terkonfirmasi.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="restaurants" class="py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-12">Restoran Pilihan Untukmu</h2>

        <div class="relative">
            <div class="swiper restaurant-swiper">
                <div class="swiper-wrapper">
                    
                    {{-- Looping data restoran dari controller --}}
                    @forelse($featuredRestaurants as $restaurant)
                        <div class="swiper-slide">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg h-full flex flex-col transform hover:scale-105 transition-transform duration-300">
                                <img src="{{ $restaurant->profile_image_path ? asset('storage/' . $restaurant->profile_image_path) : 'https://via.placeholder.com/400x300.png?text=Tempat-In' }}" 
                                     alt="Foto {{ $restaurant->name }}" 
                                     class="w-full h-48 object-cover">
                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="font-bold text-xl mb-2 text-gray-800 dark:text-white">{{ $restaurant->name }}</h3>
                                    <p class="text-gray-700 dark:text-gray-300 text-base mb-4 flex-grow">
                                        {{ Str::limit($restaurant->description, 100) }}
                                    </p>
                                    {{-- Link untuk tamu akan mengarah ke halaman login --}}
                                    <a href="{{ route('login') }}" class="mt-4 inline-block self-start bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                        Lihat & Reservasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <p class="text-center text-gray-500 col-span-3">Belum ada restoran yang terdaftar.</p>
                        </div>
                    @endforelse

                </div>
                
                <div class="swiper-pagination mt-8"></div>
            </div>
            
            <!-- Custom Navigation Buttons -->
            <div class="swiper-button-prev !w-12 !h-12 !bg-white dark:!bg-gray-700 !text-indigo-600 dark:!text-indigo-400 !rounded-full !shadow-lg hover:!bg-indigo-50 dark:hover:!bg-gray-600 !transition-all !duration-300 !border-2 !border-indigo-200 dark:!border-gray-600 after:!text-xl after:!font-bold !-left-6"></div>
            <div class="swiper-button-next !w-12 !h-12 !bg-white dark:!bg-gray-700 !text-indigo-600 dark:!text-indigo-400 !rounded-full !shadow-lg hover:!bg-indigo-50 dark:hover:!bg-gray-600 !transition-all !duration-300 !border-2 !border-indigo-200 dark:!border-gray-600 after:!text-xl after:!font-bold !-right-6"></div>
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.restaurant-swiper', {
            // Mengaktifkan loop agar slider bisa berputar terus
            loop: true,
            // Jumlah slide yang terlihat
            slidesPerView: 1,
            // Jarak antar slide
            spaceBetween: 30,
            
            // Pengaturan responsif
            breakpoints: {
                // untuk layar 768px ke atas
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // untuk layar 1024px ke atas
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40
                }
            },

            // Mengaktifkan paginasi (titik-titik)
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Mengaktifkan tombol navigasi (panah kiri/kanan)
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Mengaktifkan autoplay
            autoplay: {
                delay: 4000, // delay 4 detik
                disableOnInteraction: false, // autoplay tidak berhenti saat di-klik
            },
        });
    });
</script>
@endpush