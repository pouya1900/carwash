<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        "carwash_id",
        "base_id",
        "items",
        "time",
        "status",
        "price",
        "discount",
    ];

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

    public function base()
    {
        return $this->belongsTo(Base_service::class, "base_id");
    }

}
