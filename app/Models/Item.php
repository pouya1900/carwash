<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, "service_item", "item_id", "service_id");
    }
}
