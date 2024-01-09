<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "status",
    ];

    public function cities()
    {
        return $this->hasMany(City::class, "state_id");
    }

    public function carwashes()
    {
        return $this->hasMany(Carwash::class, "state_id");
    }


}
