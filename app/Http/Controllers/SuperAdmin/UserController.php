<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user, kecuali superadmin itu sendiri, lalu paginasi
        $users = User::where('role', '!=', 'superadmin')->latest()->paginate(15);
        return view('superadmin.users.index', compact('users'));
    }

       public function create()
    {
        return view('superadmin.users.create');
    }

        public function edit(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin', // Otomatis set sebagai admin
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'Akun admin baru berhasil dibuat.');
    }
    public function destroy(User $user)
    {
        // Logika Pengaman: Jangan hapus user jika dia adalah seorang admin
        // yang masih memiliki restoran terdaftar.
        if ($user->role === 'admin' && $user->restaurant) {
            return redirect()->back()->with('error', "Tidak dapat menghapus admin '{$user->name}' karena ia masih terhubung dengan sebuah restoran.");
        }   

        // Hapus pengguna dari database
        $user->delete();

        return redirect()->route('superadmin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}