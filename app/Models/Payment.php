<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "online",
        "wallet",
        "cash",
        "total",
        "coupon_code",
        "coupon_value",
        "status",
        "ref_id",
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, "payment_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

}
