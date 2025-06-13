@extends('layouts.admin') {{-- Menggunakan layout admin --}}

@section('title', 'Kelola Profil Restoran')

@section('content')
<div class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Profil Restoran Anda</h1>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.restaurant.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kolom Kiri --}}
            <div>
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Restoran</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $restaurant->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                </div>

                <div class="mb-4">
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                    <textarea id="address" name="address" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>{{ old('address', $restaurant->address) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $restaurant->phone_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div>
                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('description', $restaurant->description) }}</textarea>
                </div>

                <div class="flex space-x-4">
                    <div class="w-1/2 mb-4">
                        <label for="opening_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Buka</label>
                        <input type="time" id="opening_time" name="opening_time" value="{{ old('opening_time', $restaurant->opening_time) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div class="w-1/2 mb-4">
                        <label for="closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Tutup</label>
                        <input type="time" id="closing_time" name="closing_time" value="{{ old('closing_time', $restaurant->closing_time) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                </div>

                 <div class="mb-4">
                    <label for="profile_image_path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Restoran</label>
                    <input type="file" id="profile_image_path" name="profile_image_path" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Kosongkan jika tidak ingin mengubah foto.</p>
                    @if($restaurant->profile_image_path)
                        <img src="{{ asset('storage/' . $restaurant->profile_image_path) }}" alt="Foto Restoran" class="mt-4 w-48 h-auto rounded-lg">
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection