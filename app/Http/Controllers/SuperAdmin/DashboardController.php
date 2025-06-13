<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $restaurantCount = Restaurant::count();
        $reservationCount = Reservation::count();

        return view('superadmin.dashboard', compact('userCount', 'restaurantCount', 'reservationCount'));
    }
}