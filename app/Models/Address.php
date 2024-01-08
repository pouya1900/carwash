<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "state",
        "city",
        "area",
        "block",
        "street",
        "lat",
        "long",
        "description",
        "pluck",
        "floor",
    ];
}
