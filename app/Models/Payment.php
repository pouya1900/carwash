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
}
