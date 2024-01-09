<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
    ];

    public function models()
    {
        return $this->hasMany(Car_model::class, "brand_id");
    }

    public function cars()
    {
        return $this->hasMany(Car::class, "brand_id");
    }

}
