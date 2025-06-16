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
            <th scope="col" class="px-6 py-3">Jadwal Reservasi</th>
            <th scope="col" class="px-6 py-3">Meja & Kapasitas</th>
            <th scope="col" class="px-6 py-3">Status Booking</th>
            <th scope="col" class="px-6 py-3">Status Pembayaran</th>
            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reservations as $reservation)
            {{-- Beri highlight kuning jika ada pengajuan reschedule --}}
            <tr class="border-b {{ $reservation->status == 'reschedule_pending' ? 'bg-yellow-50 dark:bg-yellow-900/50' : 'bg-white dark:bg-gray-800' }}">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                    {{ $reservation->user->name }}
                </td>
                <td class="px-6 py-4">
                    {{-- Tampilkan jadwal asli --}}
                    <span class="{{ $reservation->status == 'reschedule_pending' ? 'line-through text-gray-500' : '' }}">
                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                    </span>

                    {{-- Tampilkan jadwal baru jika ada pengajuan reschedule --}}
                    @if($reservation->status == 'reschedule_pending' && $reservation->reschedule_request_date)
                        <div class="text-sm font-bold text-yellow-600 dark:text-yellow-400 border-t border-dashed border-yellow-300 mt-2 pt-2">
                            <i class="fas fa-arrow-right mr-1"></i> Diajukan: {{ \Carbon\Carbon::parse($reservation->reschedule_request_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($reservation->reschedule_request_time)->format('H:i') }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $reservation->table->name ?? 'N/A' }} ({{ $reservation->table->capacity ?? 'N/A' }} org)
                </td>
                <td class="px-6 py-4">
                    {{-- Badge Status Booking --}}
                    @if($reservation->status == 'reschedule_pending')
                        <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">Diajukan Reschedule</span>
                    @elseif($reservation->status == 'confirmed')
                         <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Dikonfirmasi</span>
                    @else
                        <span class="px-2 py-1 font-semibold leading-tight text-gray-600 bg-gray-200 rounded-full">{{ ucfirst($reservation->status) }}</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{-- Badge Status Pembayaran --}}
                    <span class="px-2 py-1 font-semibold leading-tight {{ $reservation->payment_status == 'paid' ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100' }} rounded-full">{{ ucfirst($reservation->payment_status) }}</span>
                </td>
               <td class="px-6 py-4 text-center">
    <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="flex items-center space-x-2">
            <select name="status" class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm text-xs focus:border-indigo-500 focus:ring-indigo-500">
                
                {{-- Opsi berdasarkan status saat ini --}}
                @if($reservation->status == 'pending' || $reservation->status == 'reschedule_pending')
                    {{-- Jika menunggu atau reschedule, admin bisa konfirmasi atau batalkan --}}
                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Setujui / Konfirmasi</option>
                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Tolak / Batalkan</option>
                
                @elseif($reservation->status == 'confirmed')
                    {{-- Jika sudah dikonfirmasi, admin hanya bisa membatalkan --}}
                    <option value="confirmed" selected>Dikonfirmasi</option>
                    <option value="cancelled">Batalkan</option>
                
                @else
                    {{-- Jika sudah batal, tampilkan statusnya saja --}}
                    <option value="{{ $reservation->status }}" selected disabled>{{ ucfirst($reservation->status) }}</option>
                @endif

            </select>
            
            {{-- Tombol simpan hanya muncul jika ada aksi yang bisa dilakukan --}}
            @if($reservation->status != 'cancelled')
                <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-xs px-3 py-2">Update</button>
            @endif
        </div>
    </form>
</td>
            </tr>
        @empty
            {{-- ... --}}
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