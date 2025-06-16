<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory; // <-- 2. TAMBAHKAN BARIS INI

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    protected $guarded = []; // Mengizinkan semua atribut untuk diisi (alternatif dari $fillable)

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}
public function menuItems()
{
    return $this->hasMany(MenuItem::class);
}

 public function bookingPackages(): HasMany
    {
        return $this->hasMany(BookingPackage::class);
    }
// Tambahkan method ini di dalam class Restaurant
public function reservations()
{
    return $this->hasMany(Reservation::class);
}
public function tables(): HasMany
{
    return $this->hasMany(Table::class);
}


}
