<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        "reservation_id",
        "scorable_id",
        "scorable_type",
        "rate",
        "comment",
        "reply",

    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, "reservation_id");
    }

    public function scorable()
    {
        return $this->morphTo("scorable");
    }

}
