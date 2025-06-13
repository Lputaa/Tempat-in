@extends('layouts.admin')

@section('title', 'Tambah Paket Harga Baru')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Tambah Paket Harga Baru</h1>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 max-w-2xl mx-auto">
    {{-- Menampilkan Error Validasi --}}
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

    <form action="{{ route('admin.packages.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Paket</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Paket Hemat" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3" placeholder="Jelaskan tentang paket ini" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm">{{ old('description') }}</textarea>
        </div>

        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga (Rp)</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="Contoh: 25000 (tanpa titik atau koma)" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
        </div>

        <div class="flex justify-end items-center mt-6">
            <a href="{{ route('admin.packages.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline mr-4">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Paket
            </button>
        </div>
    </form>
</div>
@endsection