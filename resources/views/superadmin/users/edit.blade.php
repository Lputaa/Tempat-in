@extends('layouts.superadmin')

@section('title', 'Edit Pengguna: ' . $user->name)

@section('content')
<div class="p-4 md:p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Edit Pengguna: {{ $user->name }}</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 max-w-2xl mx-auto">
        {{-- Menampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <p class="font-bold">Oops! Terjadi kesalahan:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Menggunakan metode PUT untuk update --}}

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            
            <hr class="my-6 border-gray-200 dark:border-gray-700">

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Isi bagian di bawah ini hanya jika Anda ingin mengganti password pengguna.</p>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm">
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm">
            </div>

            <div class="flex justify-end items-center mt-6">
                <a href="{{ route('superadmin.users.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline mr-4">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection