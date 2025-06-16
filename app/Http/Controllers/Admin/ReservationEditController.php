<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon; // <-- ADD THIS LINE
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // <-- Tambahkan import untuk Mail
use App\Mail\ReservationStatusUpdated; // <-- Tambahkan import untuk Mailable Anda

class ReservationEditController extends Controller
{
    /**
     * Menampilkan daftar semua reservasi untuk restoran milik admin.
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        $reservations = $restaurant->reservations()
                                    ->with('user')
                                    ->orderBy('reservation_date', 'asc')
                                    ->orderBy('reservation_time', 'asc')
                                    ->paginate(10);

        // Pastikan ini mengarah ke view Anda
        return view('admin.restaurant.reservation', compact('reservations'));
    }
        // app/Http/Controllers/Admin/ReservationEditController.php

public function update(Request $request, Reservation $reservation)
{
    // Keamanan: Pastikan reservasi ini milik restoran admin yang login
    if ($reservation->restaurant_id !== Auth::user()->restaurant->id) {
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }

    // Validasi input status dari dropdown
    $validated = $request->validate([
        'status' => 'required|string|in:pending,confirmed,cancelled',
    ]);

    // Jika admin menyetujui reservasi yang tadinya reschedule,
    // kita harus update tanggalnya sebelum mengubah status.
    if ($reservation->status == 'reschedule_pending' && $validated['status'] == 'confirmed') {
        
        // Cek ketersediaan lagi untuk tanggal baru
        $isBooked = Reservation::where('table_id', $reservation->table_id)
                             ->where('reservation_date', $reservation->reschedule_request_date)
                             ->where('reservation_time', $reservation->reschedule_request_time)
                             ->where('id', '!=', $reservation->id)
                             ->where('status', '!=', 'cancelled')
                             ->exists();

        if ($isBooked) {
            return redirect()->back()->with('error', 'Gagal menyetujui. Jadwal baru yang diajukan sudah dipesan orang lain.');
        }

        // Update ke jadwal baru & bersihkan data pengajuan
        $reservation->update([
            'reservation_date' => $reservation->reschedule_request_date,
            'reservation_time' => $reservation->reschedule_request_time,
            'reschedule_request_date' => null,
            'reschedule_request_time' => null,
        ]);
    }

    // Update status utama
    $reservation->update([
        'status' => $validated['status']
    ]);

    return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui.');
}

    public function destroy(Reservation $reservation)
    {
        // 1. Keamanan: Pastikan reservasi ini milik restoran admin yang login
        if ($reservation->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // 2. Hapus data dari database
        $reservation->delete();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Reservasi telah berhasil dihapus.');
    }
}