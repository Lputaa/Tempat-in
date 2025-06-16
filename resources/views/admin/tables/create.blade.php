@extends('layouts.admin')

@section('title', 'Tambah Meja Baru')
@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Tambah Meja Baru</h1>

<div class="bg-white dark:bg-gray-800 dark:text p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
    <form action="{{ route('admin.tables.store') }}" method="POST">
        @csrf

        {{-- Memanggil form parsial --}}
        @include('admin.tables._form')

        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.tables.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline mr-4">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Simpan Meja</button>
        </div>
    </form>
</div>
@endsection