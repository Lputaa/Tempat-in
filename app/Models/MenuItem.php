<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MenuItem extends Model
{

    protected $guarded = [];
    public function restaurant()
{
    return $this->belongsTo(Restaurant::class);
}

public function reservations(): BelongsToMany
{
    return $this->belongsToMany(Reservation::class)
                ->withPivot('quantity', 'price');
}
}
