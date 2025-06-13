<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    // ... metode lain (index, create, store, show, destroy)
    
    public function edit(Restaurant $restaurant)
    {
        // Pastikan admin yang login hanya bisa mengedit restorannya sendiri
        if (Auth::user()->restaurant->id !== $restaurant->id) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        return view('admin.restaurant.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        // Pastikan admin yang login hanya bisa mengupdate restorannya sendiri
        if (Auth::user()->restaurant->id !== $restaurant->id) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        // --- Validasi Data (Sangat Penting!) ---
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'profile_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // --- Logika Update Data ---
        $restaurant->update($validated);

        // --- Logika Handle File Upload (Jika ada file baru) ---
        if ($request->hasFile('profile_image_path')) {
            // Hapus file lama jika ada (opsional tapi best practice)
            // if ($restaurant->profile_image_path) { Storage::delete($restaurant->profile_image_path); }
            
            $path = $request->file('profile_image_path')->store('restaurant_images', 'public');
            $restaurant->update(['profile_image_path' => $path]);
        }

        return redirect()->route('admin.restaurant.edit', $restaurant->id)
                         ->with('success', 'Profil restoran berhasil diperbarui.');
    }
}