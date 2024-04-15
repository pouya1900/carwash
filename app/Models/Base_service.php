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
    ];

    public function services()
    {
        return $this->hasMany(Service::class, "base_id");
    }

    public function getDescriptionTextAttribute()
    {
        $text = "";
        $description = json_decode($this->description, true);
        foreach ($description as $key => $item) {
            $text .= $item;
            if ($key < count($description) - 1)
                $text .= "، ";
        }

        return $text;
    }

}
