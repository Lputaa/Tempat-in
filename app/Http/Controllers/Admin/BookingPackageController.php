<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('package_images', 'public');
        }

        Auth::user()->restaurant->bookingPackages()->create($validated);

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
        if ($package->restaurant_id !== Auth::user()->restaurant->id) { abort(403); }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada
            if ($package->image_path) {
                Storage::disk('public')->delete($package->image_path);
            }
            // Simpan gambar baru
            $validated['image_path'] = $request->file('image_path')->store('package_images', 'public');
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket harga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookingPackage $package)
    {
        if ($package->restaurant_id !== Auth::user()->restaurant->id) { abort(403); }

        // Hapus gambar dari storage sebelum menghapus data
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Paket harga berhasil dihapus.');
    }
}
