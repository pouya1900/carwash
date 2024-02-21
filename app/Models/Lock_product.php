<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lock_product extends Model
{
    use HasFactory;

    protected $fillable = [
        "carwash_id",
        "product_id",
        "title",
        "description",
        "price",
    ];

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

    public function reservations()
    {
        return $this->morphToMany(Reservation::class, "reservationable", 'reservationable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
