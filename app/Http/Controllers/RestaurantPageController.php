<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Carbon\Carbon;

class RestaurantPageController extends Controller
{
    /**
     * Menampilkan daftar semua restoran kepada pengguna.
     */
    public function index()
{
    $restaurants = Restaurant::where('is_active', true)->orderBy('name')->paginate(9);

    // DIUBAH AGAR SESUAI DENGAN NAMA FILE ANDA
    return view('user.dashboard', compact('restaurants'));
}
    /**
     * Menampilkan detail satu restoran (akan kita isi nanti).
     */
     public function show(Restaurant $restaurant)
    {
        if (!$restaurant->is_active) {
            abort(404);
        }

        // --- DATA YANG SUDAH ADA ---
        $menuGrouped = $restaurant->menuItems()->get()->groupBy('category');
        $bookingPackages = $restaurant->bookingPackages()->get();

        // --- LOGIKA BARU ---
        
        // 1. Ambil semua meja milik restoran ini
        $tables = $restaurant->tables()->orderBy('name')->get();

        // 2. Buat daftar slot waktu per 30 menit dari jam buka hingga jam tutup
        $timeSlots = [];
        $openingTime = Carbon::parse($restaurant->opening_time);
        $closingTime = Carbon::parse($restaurant->closing_time);

        // Loop dari jam buka hingga 1 jam sebelum tutup (asumsi durasi booking 1 jam)
        while ($openingTime < $closingTime) {
            $timeSlots[] = $openingTime->format('H:i');
            $openingTime->addMinutes(30);
        }
        
        // --- KIRIM SEMUA DATA KE VIEW ---
        return view('user.restaurants.show', [
            'restaurant' => $restaurant,
            'menuGrouped' => $menuGrouped,
            'bookingPackages' => $bookingPackages,
            'tables' => $tables,           // <-- Data meja
            'timeSlots' => $timeSlots,   // <-- Data slot waktu
        ]);
    }

}