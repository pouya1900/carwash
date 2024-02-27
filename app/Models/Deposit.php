<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        "bank_id",
        "depositable_id",
        "depositable_type",
        "total",
        "status",
        "message",
    ];

    public function depositable()
    {
        return $this->morphTo("depositable");
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, "bank_id");
    }

}
