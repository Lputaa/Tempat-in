<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered; // <-- Tambahkan ini
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            default:
                return redirect()->route('user.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}

public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * GANTI METHOD LAMA ANDA DENGAN INI
     */
    public function register(Request $request)
    {
        // 1. Validasi input (sedikit disempurnakan)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // 2. Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // 3. (BAGIAN PENTING) Picu event untuk mengirim email verifikasi
        event(new Registered($user));

        // 4. (SANGAT DIREKOMENDASIKAN) Login-kan user secara otomatis
        Auth::login($user);

        // 5. Arahkan ke dashboard. Laravel akan otomatis mencegat
        //    dan mengarahkan ke halaman 'verify-email' jika email belum terverifikasi.
        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
