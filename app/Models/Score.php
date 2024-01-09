<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        "reservation_id",
        "carwash_id",
        "rate",
        "comment",
        "reply",

    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, "reservation_id");
    }

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

}
