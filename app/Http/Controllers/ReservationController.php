<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\BookingPackage;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
 // <-- PENTING: Gunakan HTTP Client Laravel

class ReservationController extends Controller
{
    // KITA TIDAK LAGI MEMBUTUHKAN __construct() UNTUK MIDTRANS

public function store(Request $request)
{
    // 1. Validasi data, termasuk validasi ketersediaan meja
    $validatedData = $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id',
        'cart_items' => 'nullable|json',
        'booking_package_id' => 'nullable|exists:booking_packages,id',
        'reservation_date' => 'required|date|after_or_equal:today',
        'reservation_time' => 'required',
        'table_id' => [
            'required',
            'exists:tables,id',
            function ($attribute, $value, $fail) use ($request) {
                $isBooked = Reservation::where('table_id', $value)
                                     ->where('reservation_date', $request->reservation_date)
                                     ->where('reservation_time', $request->reservation_time)
                                     ->where('status', '!=', 'cancelled')
                                     ->exists();
                if ($isBooked) {
                    $fail('Meja yang dipilih sudah dipesan pada tanggal dan waktu ini.');
                }
            },
        ],
    ]);

    // 2. Kalkulasi harga
    $packagePrice = 0;
    $menuSubtotal = 0;
    $itemsToAttach = [];
    if (isset($validatedData['booking_package_id'])) {
        $package = BookingPackage::find($validatedData['booking_package_id']);
        $packagePrice = $package->price;
    }
    if (isset($validatedData['cart_items'])) {
        $cartItems = json_decode($validatedData['cart_items'], true);
        foreach ($cartItems as $id => $item) {
            $menuItem = MenuItem::find($id);
            if ($menuItem) {
                $menuSubtotal += $menuItem->price * $item['quantity'];
                $itemsToAttach[$id] = ['quantity' => $item['quantity'], 'price' => $menuItem->price];
            }
        }
    }
    $service_fee = $menuSubtotal > 0 ? 5000 : 0;
    $total_price = $packagePrice + $menuSubtotal + $service_fee;
    $down_payment_amount = $total_price * 0.5;

    // 3. Simpan ke DB menggunakan Transaksi
    $reservation = null;
    try {
        $reservation = DB::transaction(function () use ($validatedData, $itemsToAttach, $menuSubtotal, $service_fee, $total_price, $down_payment_amount) {
            $orderId = 'TRX-' . time() . '-' . uniqid();
            
            $newReservation = Reservation::create([
                'user_id' => Auth::id(),
                'restaurant_id' => $validatedData['restaurant_id'],
                'table_id' => $validatedData['table_id'],
                'booking_package_id' => $validatedData['booking_package_id'] ?? null,
                'reservation_date' => $validatedData['reservation_date'],
                'reservation_time' => $validatedData['reservation_time'],
                'subtotal' => $menuSubtotal,
                'service_fee' => $service_fee,
                'total_price' => $total_price,
                'down_payment_amount' => $down_payment_amount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'midtrans_order_id' => $orderId,
            ]);

            if (!empty($itemsToAttach)) {
                $newReservation->menuItems()->attach($itemsToAttach);
            }
            return $newReservation;
        });
    } catch (\Throwable $e) {
        return redirect()->back()->with('error', 'Gagal menyimpan reservasi ke database.')->withInput();
    }

    if (!$reservation) {
        return redirect()->back()->with('error', 'Gagal memproses data reservasi.')->withInput();
    }

    // =====================================================================
    // == BAGIAN YANG HILANG ADA DI SINI: MEMBUAT TRANSAKSI MIDTRANS ==
    // =====================================================================
    $serverKey = env('MIDTRANS_SERVER_KEY');
    $payload = [
        'transaction_details' => [
            'order_id'      => $reservation->midtrans_order_id,
            'gross_amount'  => (int) $reservation->down_payment_amount,
        ],
        'customer_details' => [
            'first_name'    => Auth::user()->name,
            'email'         => Auth::user()->email,
        ],
    ];

    $response = Http::withBasicAuth($serverKey, '')->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);
    $snapToken = $response->json('token');

    if (!$snapToken) {
        return redirect()->back()->with('error', 'Gagal terhubung dengan gateway pembayaran.');
    }

    // Simpan token ke reservasi
    $reservation->update(['midtrans_token' => $snapToken]);
    
    // Arahkan ke halaman pembayaran
    return redirect()->route('reservations.payment', $reservation);
}

    public function payment(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id() || $reservation->payment_status !== 'pending') {
            abort(403);
        }
        // Ambil snapToken langsung dari objek reservasi
        return view('user.reservations.payment', ['reservation' => $reservation, 'snapToken' => $reservation->midtrans_token]);
    }
    public function requestReschedule(Request $request, Reservation $reservation)
{
    // Keamanan: Pastikan user hanya bisa reschedule miliknya sendiri
    if ($reservation->user_id !== Auth::id()) {
        abort(403);
    }

    // Validasi aturan bisnis
    $originalDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
    if (now()->greaterThanOrEqualTo($originalDateTime->copy()->subDay())) {
        return back()->with('error', 'Batas waktu pengajuan reschedule telah lewat (H-1).');
    }

    $validated = $request->validate([
        'new_date' => ['required', 'date', 'after_or_equal:today'],
        'new_time' => ['required'],
    ]);

    $newDateTime = Carbon::parse($validated['new_date'] . ' ' . $validated['new_time']);
    if ($newDateTime->greaterThan($originalDateTime->copy()->addWeek())) {
        return back()->with('error', 'Jadwal baru tidak boleh lebih dari 1 minggu dari jadwal asli.');
    }

    // Update reservasi dengan data pengajuan reschedule
    $reservation->update([
        'reschedule_request_date' => $validated['new_date'],
        'reschedule_request_time' => $validated['new_time'],
        'status' => 'reschedule_pending', // Status baru
    ]);

    return redirect()->route('reservations.history')->with('success', 'Pengajuan reschedule Anda telah terkirim dan menunggu konfirmasi admin.');
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