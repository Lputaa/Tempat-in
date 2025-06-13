@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<div class="p-4 md:p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Menu Restoran Anda</h1>
        <a href="{{ route('admin.menu-items.create') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            <i class="fas fa-plus mr-2"></i> Tambah Item Baru
        </a>
    </div>

    {{-- Pesan Sukses/Error --}}
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
                        <th scope="col" class="px-6 py-3">Nama Item</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Harga</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Menggunakan @forelse untuk handle jika data kosong --}}
                    @forelse ($menuItems as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->category }}
                            </td>
                            <td class="px-6 py-4">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end items-center space-x-4">
                                <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Edit</a>
                                
                                {{-- Tombol Hapus menggunakan form untuk keamanan (metode DELETE) --}}
                                <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan jika tidak ada item menu sama sekali --}}
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Belum ada item menu yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush