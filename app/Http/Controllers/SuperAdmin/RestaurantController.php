<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Menampilkan daftar semua restoran di platform.
     */
    public function index()
    {
        $restaurants = Restaurant::with('user') // Eager load 'user' untuk menampilkan nama pemilik
                                ->latest()
                                ->paginate(15);

        return view('superadmin.restaurants.index', compact('restaurants'));
        
    }

    public function update(Request $request, Restaurant $restaurant)
{
    // Logikanya sederhana: balik nilainya. Jika true jadi false, jika false jadi true.
    $restaurant->update([
        'is_active' => !$restaurant->is_active
    ]);

    $newStatus = $restaurant->is_active ? 'diaktifkan' : 'dinonaktifkan';

    return redirect()->back()->with('success', "Restoran '{$restaurant->name}' berhasil $newStatus.");
}
    public function destroy(Restaurant $restaurant)
    {

        // 2. Hapus semua data yang terikat pada restoran ini
        //    (seperti menu dan reservasi) untuk menghindari 'data yatim'.
        $restaurant->menuItems()->delete();
        $restaurant->reservations()->delete();

        // 3. Setelah semua data terkait bersih, hapus restoran itu sendiri
        $restaurant->delete();

        return redirect()->route('superadmin.restaurants.show')->with('success', "Restoran '{$restaurant->name}' dan semua datanya telah berhasil dihapus.");
    }
}