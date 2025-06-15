<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant; // <-- Import model Restaurant

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
        // Pastikan restoran yang diakses aktif
        if (!$restaurant->is_active) {
            abort(404);
        }

        // Ambil item menu dan kelompokkan berdasarkan kategori
        $menuGrouped = $restaurant->menuItems()->get()->groupBy('category');
        
        // AMBIL DATA PAKET HARGA (INI BAGIAN YANG HILANG)
        $bookingPackages = $restaurant->bookingPackages()->get();

        // Kirim semua data yang diperlukan ke view
        return view('user.restaurants.show', [
            'restaurant' => $restaurant,
            'menuGrouped' => $menuGrouped,
            'bookingPackages' => $bookingPackages // <-- KIRIM DATA PAKET
        ]);
    }

}