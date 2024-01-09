<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "state_id",
        "status",
    ];

    public function state()
    {
        return $this->belongsTo(State::class, "state_id");
    }

    public function carwashes()
    {
        return $this->hasMany(Carwash::class, "city_id");
    }

}
