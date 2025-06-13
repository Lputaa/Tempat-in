{{-- Kita asumsikan ada layout utama untuk user bernama layouts.app --}}
@extends('layouts.user') 

@section('title', 'Daftar Restoran')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Temukan Restoran Favorit Anda</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-8">Jelajahi berbagai pilihan tempat makan dan kafe terbaik.</p>

    @if($restaurants->isEmpty())
        <div class="text-center py-20">
            <p class="text-gray-500 dark:text-gray-400 text-lg">Saat ini belum ada restoran yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($restaurants as $restaurant)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    {{-- Gambar Restoran (BARIS INI YANG DIPERBAIKI) --}}
                    <img class="w-full h-48 object-cover" src="{{ $restaurant->profile_image_path ? asset('storage/' . $restaurant->profile_image_path) : 'https://via.placeholder.com/400x300.png?text=Tempat-In' }}" alt="Foto {{ $restaurant->name }}">
                    
                    <div class="p-6">
                        {{-- Nama & Alamat --}}
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $restaurant->name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1 truncate">
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $restaurant->address }}
                        </p>

                        {{-- Deskripsi Singkat --}}
                        <p class="text-gray-600 dark:text-gray-400 mt-4 text-sm leading-relaxed h-20 overflow-hidden">
                            {{ Str::limit($restaurant->description, 120) }}
                        </p>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6">
                            <a href="{{ route('restaurants.show', $restaurant->id) }}" class="w-full text-center block text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5">
                                Lihat Detail & Menu
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Link Paginasi --}}
        <div class="mt-12">
            {{ $restaurants->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
@endpush