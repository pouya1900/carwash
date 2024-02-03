<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base_service extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "items",
    ];

    public function services()
    {
        return $this->hasMany(Service::class, "base_id");
    }

}
