@extends('layouts.admin')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="p-4 md:p-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Daftar Reservasi Masuk</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Pemesan</th>
                        <th scope="col" class="px-6 py-3">Tanggal & Waktu</th>
                        <th scope="col" class="px-6 py-3">Jumlah Tamu</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
    @forelse ($reservations as $reservation)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                {{ $reservation->user->name }}
            </td>
            <td class="px-6 py-4">
                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
            </td>
            <td class="px-6 py-4">
                {{ $reservation->number_of_guests }} orang
            </td>
            <td class="px-6 py-4">
                @if($reservation->status == 'pending')
                    <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">Menunggu</span>
                @elseif($reservation->status == 'confirmed')
                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Dikonfirmasi</span>
                @else
                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Dibatalkan</span>
                @endif
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex items-center justify-center space-x-2">
                    {{-- Tampilkan tombol Konfirmasi/Batalkan hanya jika status 'pending' --}}
                    @if($reservation->status == 'pending')
                        {{-- Form untuk Konfirmasi --}}
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline">Konfirmasi</button>
                        </form>
                        {{-- Form untuk Batalkan --}}
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="font-medium text-orange-600 dark:text-orange-500 hover:underline">Batalkan</button>
                        </form>
                    @endif

                    {{-- Form untuk Hapus (bisa untuk semua status) --}}
                    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                Belum ada reservasi yang masuk.
            </td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection