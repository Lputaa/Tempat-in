<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\MenuItem; // <-- Tambahkan import
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Tambahkan import untuk Transaksi

class ReservationController extends Controller
{
    /**
     * Menyimpan reservasi baru dari pengguna beserta pre-order menu.
     */
    public function store(Request $request)
    {
        // 1. Validasi data utama dan keranjang belanja (cart)
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'number_of_guests' => 'required|integer|min:1',
            'cart' => 'required|json', // Pastikan data keranjang ada dan dalam format JSON
        ]);

        $cartItems = json_decode($validatedData['cart'], true);

        if (empty($cartItems)) {
            return back()->withErrors(['cart' => 'Keranjang belanja tidak boleh kosong.']);
        }
        
        // Ambil data restoran dan definisikan biaya
        $restaurant = Restaurant::findOrFail($validatedData['restaurant_id']);
        $service_fee = 5000; // Anda bisa buat ini dinamis nanti
        $down_payment_percentage = 0.5; // 50%

        // Inisialisasi variabel
        $subtotal = 0;
        $itemsToAttach = [];

        // 2. Kalkulasi ulang harga di backend untuk keamanan
        foreach ($cartItems as $id => $item) {
            $menuItem = MenuItem::find($id);
            if ($menuItem) {
                $subtotal += $menuItem->price * $item['quantity'];
                // Siapkan data untuk tabel pivot
                $itemsToAttach[$id] = [
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price // Simpan harga dari database
                ];
            }
        }
        
        $total_price = $subtotal + $service_fee;
        $down_payment_amount = $total_price * $down_payment_percentage;


        // 3. Gunakan Transaksi Database
        $reservation = null;
        try {
            DB::transaction(function () use ($validatedData, $itemsToAttach, $subtotal, $service_fee, $total_price, $down_payment_amount, &$reservation) {
                // a. Buat data reservasi utama
                $reservation = Reservation::create([
                    'user_id' => Auth::id(),
                    'restaurant_id' => $validatedData['restaurant_id'],
                    'reservation_date' => $validatedData['reservation_date'],
                    'reservation_time' => $validatedData['reservation_time'],
                    'number_of_guests' => $validatedData['number_of_guests'],
                    'subtotal' => $subtotal,
                    'service_fee' => $service_fee,
                    'total_price' => $total_price,
                    'down_payment_amount' => $down_payment_amount,
                    'status' => 'pending', // Status reservasi, bukan pembayaran
                    'payment_status' => 'pending',
                ]);

                // b. Lampirkan item-item menu ke reservasi di tabel pivot
                $reservation->menuItems()->attach($itemsToAttach);
            });
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan dengan pesan kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat reservasi. Silakan coba lagi. ' . $e->getMessage());
        }

        // TODO: Langkah selanjutnya adalah memicu pembayaran Midtrans di sini
        // Untuk sekarang, kita anggap berhasil dan redirect.

        return redirect()->route('reservations.history')->with('success', 'Reservasi Anda telah berhasil dibuat dan menunggu pembayaran.');
    }

    public function history()
    {
        // Langkah 1: Dapatkan objek User yang sedang login.
        $user = Auth::user();

        // Langkah 2: Panggil relasi 'reservations' dari objek User tersebut.
        // Di sinilah error terjadi jika method 'reservations()' tidak ditemukan di Model User.
        $reservations = $user->reservations()
                             ->with('restaurant') // Eager load data restoran untuk efisiensi
                             ->latest()           // Urutkan dari yang terbaru
                             ->paginate(10);     // Batasi 10 per halaman

        // Langkah 3: Kirim data ke view.
        return view('user.reservations.history', compact('reservations'));
    }

        public function destroy(Reservation $reservation)
    {
        // 1. Keamanan: Pastikan yang membatalkan adalah pemilik reservasi
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // 2. Logika Bisnis: Pastikan reservasi masih bisa dibatalkan
        $reservationDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
        if ($reservation->status === 'cancelled' || $reservationDateTime->isPast()) {
            return redirect()->back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
        }

        // 3. Update status menjadi 'cancelled', bukan menghapus data
        $reservation->update(['status' => 'cancelled']);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('reservations.history')->with('success', 'Reservasi Anda telah berhasil dibatalkan.');
    }
}