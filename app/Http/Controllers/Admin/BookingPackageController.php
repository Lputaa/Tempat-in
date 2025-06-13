<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;

        // Ambil paket yang hanya dimiliki oleh restoran ini
        $packages = $restaurant->bookingPackages()->paginate(10);

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.packages.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validasi data yang masuk
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|integer|min:0',
    ]);

    // 2. Dapatkan restoran milik admin yang login
    $restaurant = Auth::user()->restaurant;

    // 3. Buat paket baru menggunakan relasi
    // Ini akan otomatis mengisi 'restaurant_id'
    $restaurant->bookingPackages()->create($validated);

    // 4. Redirect ke halaman daftar paket dengan pesan sukses
    return redirect()->route('admin.packages.index')->with('success', 'Paket harga baru berhasil ditambahkan.');
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
   public function edit(BookingPackage $package)
    {
        // Keamanan: Pastikan admin hanya bisa mengedit paket miliknya sendiri
        if ($package->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        // Baris ini mengirimkan data $package ke view
        return view('admin.packages.edit', compact('package'));
    }

/**
 * Memperbarui data paket di database.
 */
public function update(Request $request, BookingPackage $package)
{
    // Keamanan: Cek kepemilikan lagi
    if ($package->restaurant_id !== Auth::user()->restaurant->id) {
        abort(403);
    }

    // Validasi data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|integer|min:0',
    ]);

    $package->update($validated);

    return redirect()->route('admin.packages.index')->with('success', 'Paket harga berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookingPackage $package)
{
    // Keamanan: Cek kepemilikan
    if ($package->restaurant_id !== Auth::user()->restaurant->id) {
        abort(403);
    }

    $package->delete();

    return redirect()->route('admin.packages.index')->with('success', 'Paket harga berhasil dihapus.');
}
}
