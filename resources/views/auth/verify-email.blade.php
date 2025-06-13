{{-- Kita asumsikan Anda punya layout utama di layouts.app --}}
@extends('layouts.app')

@section('title', 'Verifikasi Email Anda')

@section('content')
<div class="container mx-auto max-w-md mt-12">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-4">Verifikasi Alamat Email Anda</h1>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Terima kasih telah mendaftar! Sebelum melanjutkan, bisakah Anda memverifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
        </div>

        @if (session('message'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('message') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection