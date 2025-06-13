@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="container mx-auto max-w-md mt-12">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Buat Akun Baru</h1>

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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex items-center justify-between">
                <a class="inline-block align-baseline font-bold text-sm text-indigo-500 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200" href="{{ route('login') }}"">
                    Sudah punya akun?
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection