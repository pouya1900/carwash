<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time_table extends Model
{
    use HasFactory;

    protected $fillable = [
        "carwash_id",
        "reservation_id",
        "start",
        "end",
        "label",
    ];

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, 'carwash_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

}
