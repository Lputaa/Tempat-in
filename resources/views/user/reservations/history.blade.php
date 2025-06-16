@extends('layouts.user')

@section('title', 'Riwayat Reservasi Saya')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Riwayat Reservasi Saya</h1>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">Restoran & Meja</th>
            <th scope="col" class="px-6 py-3">Jadwal Reservasi</th>
            <th scope="col" class="px-6 py-3">Status Booking</th>
            <th scope="col" class="px-6 py-3">Status Pembayaran</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reservations as $reservation)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                    <div class="font-bold">{{ $reservation->restaurant->name }}</div>
                    <div class="text-xs text-gray-500">{{ $reservation->table->name ?? 'Meja Dihapus' }} (Kapasitas: {{ $reservation->table->capacity ?? 'N/A' }})</div>
                </td>
                <td class="px-6 py-4 {{ $reservation->status == 'reschedule_pending' ? 'bg-yellow-50 dark:bg-yellow-900/50' : '' }}">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                    
                    {{-- Tampilkan jadwal baru jika ada pengajuan reschedule --}}
                    @if($reservation->status == 'reschedule_pending' && $reservation->reschedule_request_date)
                        <div class="text-xs text-yellow-600 dark:text-yellow-400 border-t border-dashed border-yellow-300 mt-2 pt-2">
                            Diajukan: {{ \Carbon\Carbon::parse($reservation->reschedule_request_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($reservation->reschedule_request_time)->format('H:i') }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{-- Badge Status Booking --}}
                    @if($reservation->status == 'confirmed')
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Dikonfirmasi</span>
                    @elseif($reservation->status == 'reschedule_pending')
                        <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">Pengajuan Reschedule</span>
                    @else
                        <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Dibatalkan</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{-- Badge Status Pembayaran --}}
                    <span class="px-2 py-1 font-semibold leading-tight {{ $reservation->payment_status == 'paid' ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100' }} rounded-full">{{ ucfirst($reservation->payment_status) }}</span>
                </td>
{{-- Ganti seluruh isi <td> Aksi dengan ini --}}
<td class="px-6 py-4">
    @php
        // Cek apakah reservasi bisa di-reschedule (H-1 dari jadwal)
        $canReschedule = \Carbon\Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time)->isFuture() &&
                         \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($reservation->reservation_date)->startOfDay());
    @endphp

    @if($reservation->status == 'confirmed' && $canReschedule)
        {{-- Tombol untuk membuka modal --}}
        <button type="button" data-modal-target="reschedule-modal-{{ $reservation->id }}" class="open-reschedule-modal font-medium text-indigo-600 dark:text-indigo-500 hover:underline">
            Ajukan Reschedule
        </button>

        {{-- ====================================================== --}}
        {{-- == STRUKTUR MODAL (AWALNYA TERSEMBUNYI) == --}}
        {{-- ====================================================== --}}
        <div id="reschedule-modal-{{ $reservation->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="relative w-full max-w-md p-4">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Ajukan Jadwal Baru
                        </h3>
                        <button type="button" data-modal-close="reschedule-modal-{{ $reservation->id }}" class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <form action="{{ route('reservations.reschedule.request', $reservation->id) }}" method="POST" class="p-6">
                        @csrf
                        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">Jadwal Asli: {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }} jam {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</p>
                        
                        <div class="mb-4">
                            <label for="new_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Baru</label>
                            <input type="date" name="new_date" id="new_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="new_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu Baru</label>
                            <input type="time" name="new_time" id="new_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kirim Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Cari semua tombol yang berfungsi untuk membuka modal
    const openModalButtons = document.querySelectorAll('.open-reschedule-modal');
    openModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex'); // Gunakan flex untuk menengahkan konten
            }
        });
    });

    // Cari semua tombol yang berfungsi untuk menutup modal
    const closeModalButtons = document.querySelectorAll('.close-modal');
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-close');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });

    // (Opsional) Tutup modal jika user mengklik area backdrop gelap
    window.addEventListener('click', function (event) {
        if (event.target.matches('.fixed.inset-0')) {
            event.target.classList.add('hidden');
            event.target.classList.remove('flex');
        }
    });
});
</script>
@endpush