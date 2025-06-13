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

    // Ambil semua item menu milik restoran ini
    // dan kelompokkan berdasarkan kategori untuk tampilan yang lebih rapi
    $menuGrouped = $restaurant->menuItems()->get()->groupBy('category');

    // Kirim data restoran dan menu yang sudah dikelompokkan ke view
    return view('user.restaurants.show', [
            'restaurant' => $restaurant,
            'menuGrouped' => $menuGrouped
        ]);
}
}