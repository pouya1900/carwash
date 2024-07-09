<?php

namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
    ];

    public function models()
    {
        return $this->hasMany(Car_model::class, "brand_id");
    }

    public function cars()
    {
        return $this->hasMany(Car::class, "brand_id");
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getLogoAttribute()
    {
        $image = $this->media()->where('model_type', 'brandLogo')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'brandLogo/';

            $image_model = Helper::getImageModel($path, $image->title);

            return ["paths" => $image_model, "model" => $image];
        }

        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';
        $image_model = Helper::getImageModel($path, "ic_no_product.png", 1);

        return ["paths" => $image_model, "model" => null];

    }

    public function types()
    {
        return $this->belongsToMany(Type::class, "type_brand", "brand_id", "type_id");
    }

    public function getTypeTextAttribute()
    {
        $types = $this->types;

        $text = "";
        foreach ($types as $key => $type) {
            if ($key > 0) {
                $text .= ", ";
            }
            $text .= $type->title;
        }

        return $text;

    }
}
