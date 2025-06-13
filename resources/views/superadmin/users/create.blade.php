@extends('layouts.superadmin')
@section('title', 'Tambah Admin Baru')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Tambah Admin Restoran Baru</h1>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 max-w-2xl mx-auto">
    <form action="{{ route('superadmin.users.store') }}" method="POST">
        @csrf
        <input type="hidden" name="role" value="admin">
        {{-- Form fields (name, email, password, password_confirmation) seperti di halaman edit --}}
        {{-- ... (Anda bisa salin form dari superadmin/users/edit.blade.php dan hapus bagian role) ... --}}
         <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md" required>
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Simpan Admin</button>
        </div>
    </form>
</div>
@endsection