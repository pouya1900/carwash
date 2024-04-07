<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    protected $fillable = [
        "reservation_id",
        "carwash_id",
        "total",
        "paid",
        "commission",
        "balance",
    ];

    public function reserve(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Reservation::class, "reservation_id");
    }

    public function carwash(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

}
