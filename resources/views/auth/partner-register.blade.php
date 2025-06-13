@extends('layouts.app')
@section('title', 'Gabung Sebagai Mitra')
@section('content')
<div class="container mx-auto max-w-2xl mt-12">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-center">Gabung Sebagai Mitra Restoran</h1>
        <form action="{{ route('partner.register.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
            <p class="font-bold">Oops! Ada yang salah dengan data Anda:</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ====================================================== --}}
    {{-- Bagian Data Diri (Nama, Email, Password) --}}
    {{-- ====================================================== --}}
    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white border-b pb-2">Data Diri Pemilik</h3>
    
    <div class="mb-4">
        <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Lengkap Anda</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>
    
    {{-- ====================================================== --}}
    {{-- Bagian Data Restoran --}}
    {{-- ====================================================== --}}
    <h3 class="text-xl font-semibold mt-8 mb-4 text-gray-800 dark:text-white border-b pb-2">Data Restoran Anda</h3>

    <div class="mb-4">
        <label for="restaurant_name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Restoran</label>
        <input id="restaurant_name" type="text" name="restaurant_name" value="{{ old('restaurant_name') }}" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label for="address" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Lengkap Restoran</label>
        <textarea id="address" name="address" rows="3" required
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">{{ old('address') }}</textarea>
    </div>

    <div class="mb-4">
        <label for="phone_number" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nomor Telepon Restoran</label>
        <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}" required
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    
    <div class="mb-4">
        <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Deskripsi Singkat Restoran (Opsional)</label>
        <textarea id="description" name="description" rows="3"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="opening_time" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Jam Buka</label>
            <input id="opening_time" type="time" name="opening_time" value="{{ old('opening_time') }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="closing_time" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Jam Tutup</label>
            <input id="closing_time" type="time" name="closing_time" value="{{ old('closing_time') }}" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
        </div>
    </div>

    <button type="submit" class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline text-lg">
        Daftar Sebagai Mitra
    </button>
</form>
    </div>
</div>
@endsection