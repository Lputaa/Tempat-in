<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\RestaurantPageController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\BookingPackageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\ReservationEditController;
use App\Http\Controllers\Auth\PartnerRegistrationController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\RestaurantController as SuperAdminRestaurantController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // Arahkan ke dashboard setelah berhasil verifikasi
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi baru telah dikirim ke email Anda!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('join-partner', [PartnerRegistrationController::class, 'create'])->name('partner.register.form');
Route::post('join-partner', [PartnerRegistrationController::class, 'store'])->name('partner.register.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Untuk USER
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [RestaurantPageController::class, 'index'])->name('user.dashboard');

    Route::get('/restaurants', [RestaurantPageController::class, 'index'])->name('restaurants.index');

    Route::get('/restaurants/{restaurant}', [RestaurantPageController::class, 'show'])->name('restaurants.show');

    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'history'])->name('reservations.history');
    Route::delete('/my-reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});

// Untuk ADMIN RESTORAN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $restaurant = auth()->user()->restaurant;
        return view('admin.dashboard', compact('restaurant'));
    })->name('dashboard');
    Route::resource('restaurant', RestaurantController::class)->except(['index', 'show', 'destroy']);
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('reservations', ReservationEditController::class)->only(['index', 'update', 'destroy']);
    Route::resource('packages', BookingPackageController::class);
    
});

// Untuk SUPERADMIN
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Pastikan baris ini menyertakan 'create' dan 'store'
    Route::resource('users', SuperAdminUserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    
    Route::resource('restaurants', SuperAdminRestaurantController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});
