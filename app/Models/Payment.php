<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "reservation_id",
        "user_id",
        "wallet",
        "cash",
        "total",
        "coupon_code",
        "status",
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, "reservation_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

}
