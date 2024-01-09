<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "type_id",
        "brand_id",
        "model_id",
        "color_id",
        "year",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function type()
    {
        return $this->belongsTo(Type::class, "type_id");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }

    public function model()
    {
        return $this->belongsTo(Car_model::class, "model_id");
    }

    public function color()
    {
        return $this->belongsTo(Color::class, "color_id");
    }

}
