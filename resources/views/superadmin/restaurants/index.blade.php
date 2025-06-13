@extends('layouts.superadmin')

@section('title', 'Manajemen Restoran')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Manajemen Restoran</h1>
<div class="flex justify-end mb-4">
    <a href="{{ route('superadmin.users.create') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
        Tambah Admin Baru
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Restoran</th>
                    <th scope="col" class="px-6 py-3">Pemilik (Admin)</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restaurants as $restaurant)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $restaurant->name }}</td>
                        <td class="px-6 py-4">{{ $restaurant->user->name }}</td>
                        <td class="px-6 py-4">
                            @if($restaurant->is_active)
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Aktif</span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-gray-600 bg-gray-200 rounded-full dark:bg-gray-600 dark:text-gray-200">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-4">
                                {{-- Form untuk Ubah Status --}}
                                <form action="{{ route('superadmin.restaurants.update', $restaurant->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="font-medium {{ $restaurant->is_active ? 'text-yellow-600 dark:text-yellow-500 hover:underline' : 'text-green-600 dark:text-green-500 hover:underline' }}">
                                        {{ $restaurant->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                {{-- Form untuk Hapus --}}
                                <form action="{{ route('superadmin.restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus restoran akan menghapus semua menu dan data reservasi terkait secara permanen. Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">
        {{ $restaurants->links() }}
    </div>
</div>
@endsection