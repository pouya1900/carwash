<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        "bankable_id",
        "bankable_type",
        "name",
        "card",
        "shaba",
    ];

    public function bankable()
    {
        return $this->morphTo("bankable");
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, "bank_id");
    }

}
