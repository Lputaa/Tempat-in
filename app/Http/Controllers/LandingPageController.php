<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant; // <-- Pastikan model ini di-import

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page).
     */
    public function index()
    {
        // 1. Ambil 6 restoran terbaru yang statusnya aktif untuk ditampilkan di carousel
        $featuredRestaurants = Restaurant::where('is_active', true)->latest()->take(6)->get();

        // 2. Kirim data tersebut ke view menggunakan 'compact'
        return view('landing', compact('featuredRestaurants'));
    }
}