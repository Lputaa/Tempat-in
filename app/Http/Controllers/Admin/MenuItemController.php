<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem; // Jangan lupa import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Dapatkan restoran milik pengguna yang sedang login.
        $restaurant = Auth::user()->restaurant;

        // 2. Jika karena suatu hal restoran tidak ditemukan, kembalikan ke dashboard.
        if (!$restaurant) {
            return redirect()->route('admin.dashboard')->with('error', 'Profil restoran tidak ditemukan.');
        }

        // 3. Ambil semua item menu yang berelasi dengan restoran tersebut.
        $menuItems = $restaurant->menuItems()->latest()->get(); // ->latest() untuk mengurutkan dari yang terbaru

        // 4. Kirim data ke view yang sudah Anda tentukan.
        return view('admin.restaurant.menu', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Sesuai konvensi Anda, kita akan membuat view di folder admin/restaurant
    return view('admin.restaurant.menu_create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // 1. Validasi input dari form.
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|integer|min:0',
        'category' => 'required|string|in:Makanan Utama,Minuman,Cemilan,Hidangan Penutup',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
    ]);

    // 2. Dapatkan restoran milik user yang sedang login.
    $restaurant = Auth::user()->restaurant;

    // 3. Simpan path gambar jika ada file yang di-upload.
    if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('menu_images', 'public');
        $validated['image_path'] = $path;
    }

    // 4. Buat item menu baru menggunakan relasi.
    // Ini secara otomatis akan mengisi 'restaurant_id'.
    $restaurant->menuItems()->create($validated);

    // 5. Kembalikan ke halaman daftar menu dengan pesan sukses.
    return redirect()->route('admin.menu-items.index')
                ->with('success', 'Item menu baru berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
{
    // Keamanan: Pastikan item menu ini milik restoran admin yang login
    if ($menuItem->restaurant_id !== Auth::user()->restaurant->id) {
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }

    return view('admin.restaurant.menu_edit', compact('menuItem'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, MenuItem $menuItem)
{
    // Keamanan: Pastikan item menu ini milik restoran admin yang login
    if ($menuItem->restaurant_id !== Auth::user()->restaurant->id) {
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }

    // 1. Validasi (sama seperti store)
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|integer|min:0',
        'category' => 'required|string|in:Makanan Utama,Minuman,Cemilan,Hidangan Penutup',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2. Handle update gambar jika ada file baru
    if ($request->hasFile('image_path')) {
        // Hapus gambar lama jika ada, untuk menghemat space
        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }
        // Simpan gambar baru dan update path di data tervalidasi
        $path = $request->file('image_path')->store('menu_images', 'public');
        $validated['image_path'] = $path;
    }

    // 3. Update data item menu
    $menuItem->update($validated);

    // 4. Kembalikan ke halaman daftar menu dengan pesan sukses
    return redirect()->route('admin.menu-items.index')
                     ->with('success', 'Item menu berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
{
    // 1. Keamanan: Pastikan item menu ini milik restoran admin yang login
    if ($menuItem->restaurant_id !== Auth::user()->restaurant->id) {
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }

    // 2. Best Practice: Hapus file gambar terkait dari storage
    //    untuk mencegah file sampah menumpuk di server.
    if ($menuItem->image_path) {
        Storage::disk('public')->delete($menuItem->image_path);
    }

    // 3. Hapus data item menu dari database
    $menuItem->delete();

    // 4. Kembalikan ke halaman daftar menu dengan pesan sukses
    return redirect()->route('admin.menu-items.index')
                     ->with('success', 'Item menu telah berhasil dihapus.');
}
}
