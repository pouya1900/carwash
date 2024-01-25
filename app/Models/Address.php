<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "state_id",
        "city_id",
        "area",
        "block",
        "street",
        "lat",
        "long",
        "description",
        "pluck",
        "floor",
        "is_default",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }

    public function state()
    {
        return $this->belongsTo(State::class, "state_id");
    }


}
