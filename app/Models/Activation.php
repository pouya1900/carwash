<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use HasFactory;

    protected $fillable = [
        "mobile",
        "code",
        "attempt",
        "attempt_at",
        "completed_at",
        "expired_at",
    ];
}
