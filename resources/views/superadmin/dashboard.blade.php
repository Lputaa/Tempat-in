@extends('layouts.superadmin') {{-- Menggunakan layout admin utama --}}

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Dashboard Super Admin</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Pengguna</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $userCount }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Restoran</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $restaurantCount }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Reservasi</h3>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $reservationCount }}</p>
    </div>
</div>
@endsection