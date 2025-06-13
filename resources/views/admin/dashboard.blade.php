@extends('layouts.admin') {{-- Menggunakan layout admin utama --}}

@section('title', 'Dashboard Admin')

@section('content')
    <div class="p-4 md:p-8">
        {{-- Header Sambutan --}}
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Anda saat ini mengelola dasbor untuk restoran Anda.</p>

        {{-- Kartu Profil Restoran --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $restaurant->name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $restaurant->address }}
                        </p>
                    </div>
                    
                    {{-- INI ADALAH BAGIAN KUNCI-NYA --}}
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.restaurant.edit', $restaurant->id) }}" class="inline-block text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i> Kelola Profil Restoran
                        </a>
                    </div>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                {{-- Detail Informasi Tambahan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Deskripsi</h4>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            {{ $restaurant->description ?? 'Deskripsi belum diatur.' }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Jam Operasional</h4>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            <i class="fas fa-clock mr-1"></i> 
                            {{ \Carbon\Carbon::parse($restaurant->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($restaurant->closing_time)->format('H:i') }}
                        </p>
                         <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mt-4">Kontak</h4>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                             <i class="fas fa-phone mr-1"></i>
                            {{ $restaurant->phone_number }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Kartu Manajemen Menu --}}
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Manajemen Menu</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                            Atur daftar makanan dan minuman yang tersedia di restoran Anda.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.menu-items.index') }}" class="inline-block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200">
                            <i class="fas fa-utensils mr-2"></i> Buka Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Jika perlu ikon Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush