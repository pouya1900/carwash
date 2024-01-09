<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        "bank_id",
        "carwash_id",
        "total",
        "status",
        "message",
    ];

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, "bank_id");
    }

}
