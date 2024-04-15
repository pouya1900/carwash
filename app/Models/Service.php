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
        "is_main",
    ];

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

    public function base()
    {
        return $this->belongsTo(Base_service::class, "base_id");
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, "service_item", "service_id", "item_id");
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, "service_type", "service_id", "type_id");
    }

    public function getItemTextAttribute()
    {
        $text = "";

        foreach ($this->items as $key => $item) {
            $text .= $item->title;
            if ($key < $this->items->count() - 1)
                $text .= "، ";
        }
        return $text;
    }

}
