@extends('layouts.admin')

@section('title', 'Edit Paket Harga')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Edit Paket Bundling</h1>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 max-w-2xl mx-auto">
    @if ($errors->any())
        {{-- ... blok error validasi ... --}}
    @endif

    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Gunakan metode PUT untuk update --}}

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Paket</label>
            <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}" class="mt-1 block w-full rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md">{{ old('description', $package->description) }}</textarea>
        </div>

        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga (Rp)</label>
            <input type="number" name="price" id="price" value="{{ old('price', $package->price) }}" class="mt-1 block w-full rounded-md" required>
        </div>

        <div class="mb-6">
    <label for="image_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Paket (Opsional)</label>
    <input type="file" name="image_path" id="image_path" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Kosongkan jika tidak ingin mengubah foto.</p>

    @if($package->image_path)
    <div class="mt-4">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Foto Saat Ini:</p>
        <img src="{{ asset('storage/' . $package->image_path) }}" alt="{{ $package->name }}" class="mt-2 w-48 h-auto rounded-lg">
    </div>
    @endif
        </div>

        <div class="flex justify-end items-center mt-6">
            <a href="{{ route('admin.packages.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline mr-4">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection