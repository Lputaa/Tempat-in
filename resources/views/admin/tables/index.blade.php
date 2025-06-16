@extends('layouts.admin')

@section('title', 'Manajemen Meja')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Meja</h1>
    <a href="{{ route('admin.tables.create') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Tambah Meja Baru
    </a>
</div>

{{-- Menampilkan pesan sukses setelah create/update/delete --}}
@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Meja</th>
                    <th scope="col" class="px-6 py-3">Kapasitas (Orang)</th>
                    <th scope="col" class="px-6 py-3">Dibuat Pada</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $table->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $table->capacity }} orang
                        </td>
                        <td class="px-6 py-4">
                            {{ $table->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-4">
                                <a href="{{ route('admin.tables.edit', $table->id) }}" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus meja ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            Anda belum menambahkan data meja. Silakan klik "Tambah Meja Baru".
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Menampilkan link paginasi --}}
    @if ($tables->hasPages())
        <div class="p-4 bg-white dark:bg-gray-800">
            {{ $tables->links() }}
        </div>
    @endif
</div>
@endsection