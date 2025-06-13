@extends('layouts.admin')

@section('title', 'Tambah Item Menu Baru')

@section('content')
<div class="p-4 md:p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Item Menu Baru</h1>
        <a href="{{ route('admin.menu-items.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            &larr; Kembali ke Daftar Menu
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8">
        @include('admin.restaurant._menu_form')
    </div>
</div>
@endsection