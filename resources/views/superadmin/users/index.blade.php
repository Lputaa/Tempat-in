@extends('layouts.superadmin')

@section('title', 'Manajemen Pengguna')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Manajemen Pengguna</h1>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Peran (Role)</th>
                    <th scope="col" class="px-6 py-3">Tanggal Bergabung</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4 uppercase">{{ $user->role }}</td>
                        <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            {{-- Link untuk Edit User --}}
                            <a href="{{ route('superadmin.users.edit', $user->id) }}" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Edit</a>

                            {{-- Form untuk Hapus User --}}
                            <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pengguna ini secara permanen?');">
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
        {{ $users->links() }}
    </div>
</div>
@endsection