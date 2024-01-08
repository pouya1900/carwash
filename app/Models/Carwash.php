<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carwash extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "lat",
        "long",
        'uuid',
        'platform',
        'model',
        'os',
        'mobile',
        "address",
        "city",
        "state",
        "product_count",
        "payment",
        "status",
        "type",
    ];
}
