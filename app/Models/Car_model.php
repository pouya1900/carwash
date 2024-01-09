<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_model extends Model
{
    use HasFactory;

    protected $fillable = [
        "brand_id",
        "title",
        "description",
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }

}
