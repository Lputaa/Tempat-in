<?php

namespace App\Models;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Reservation extends Model
{
protected $fillable = [
    'user_id',
    'name',
    'description',
    'address',
    'phone_number',
    'opening_time',
    'closing_time',
    'is_active',
    'profile_image_path' // <-- PASTIKAN INI ADA
];
    protected $guarded = [];

public function user()
{
    return $this->belongsTo(User::class);
}

public function restaurant()
{
    return $this->belongsTo(Restaurant::class);
}

public function menuItems(): BelongsToMany
{
    return $this->belongsToMany(MenuItem::class)
                ->withPivot('quantity', 'price'); // Penting: agar kita bisa akses jumlah & harga
}

}
