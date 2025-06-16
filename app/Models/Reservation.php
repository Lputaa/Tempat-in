<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    /**
     * TAMBAHKAN BARIS INI.
     * Ini memberitahu Laravel untuk mengizinkan SEMUA kolom diisi.
     * Ini adalah cara termudah selama masa pengembangan.
     */
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class)
                    ->withPivot('quantity', 'price');
    }
    public function table(): BelongsTo
{
    return $this->belongsTo(Table::class);
}
}