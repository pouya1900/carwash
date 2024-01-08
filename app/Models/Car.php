<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable=[
        "user_id",
        "type_id",
        "brand_id",
        "model_id",
        "color_id",
        "year",
    ];
}
