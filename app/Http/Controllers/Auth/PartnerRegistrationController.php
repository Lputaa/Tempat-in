<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class PartnerRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.partner-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validasi data user
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Validasi data restoran
            'restaurant_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            // ... validasi lain untuk restoran jika perlu
        ]);

        // Gunakan transaksi database untuk memastikan keduanya berhasil dibuat
        DB::transaction(function () use ($request) {
            // 1. Buat User dengan role 'admin'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);

            // 2. Buat Restoran dan hubungkan dengan user baru
            $user->restaurant()->create([
                'name' => $request->restaurant_name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'is_active' => false, // PENTING: Restoran baru tidak aktif, menunggu persetujuan Super Admin
            ]);

            // 3. Kirim email verifikasi & login-kan user
            event(new Registered($user));
            Auth::login($user);
        });

        // Arahkan ke dashboard admin dengan pesan khusus
        return redirect()->route('admin.dashboard')->with('status', 'Pendaftaran berhasil! Restoran Anda sedang menunggu persetujuan dari Super Admin.');
    }
}