<?php

namespace App\Http\Controllers\Admin;

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
        public function update(Request $request, Reservation $reservation)
    {
        // 1. Keamanan & Validasi (kode yang sudah ada)
        if ($reservation->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }
        $request->validate([
            'status' => 'required|string|in:confirmed,cancelled',
        ]);

        // 2. Update status reservasi (kode yang sudah ada)
        $reservation->update(['status' => $request->status]);

        // 3. KIRIM EMAIL NOTIFIKASI KE PENGGUNA
        // Kita gunakan try-catch untuk mencegah error jika pengiriman email gagal
        try {
            Mail::to($reservation->user->email)->send(new ReservationStatusUpdated($reservation));
        } catch (\Exception $e) {
            // Opsional: catat error ke log jika email gagal terkirim
            // Log::error('Gagal mengirim email update reservasi: ' . $e->getMessage());
        }
        
        // 4. Redirect kembali dengan pesan sukses (kode yang sudah ada)
        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui dan notifikasi telah dikirim.');
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