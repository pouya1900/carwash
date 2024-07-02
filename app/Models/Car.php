<?php

namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "type_id",
        "brand_id",
        "model_id",
        "color_id",
        "year",
        "is_default",
        "plate1",
        "plate2",
        "region",
        "index",
        "symbol",
        "custom",
        "plate_type",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function type()
    {
        return $this->belongsTo(Type::class, "type_id");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }

    public function model()
    {
        return $this->belongsTo(Car_model::class, "model_id");
    }

    public function color()
    {
        return $this->belongsTo(Color::class, "color_id");
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getImageAttribute()
    {
        $image = $this->media()->where('model_type', 'carImage')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'carImage/';

            $image_model = Helper::getImageModel($path, $image->title);

            return ["paths" => $image_model, "model" => $image];
        }

        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';
        $image_model = Helper::getImageModel($path, "ic_no_product.png", 1);

        return ["paths" => $image_model, "model" => null];

    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, "car_id");
    }

    public function getPlateAttribute()
    {
        if ($this->plate_type == "standard") {
            return $this->region . " " . $this->index . " " . $this->plate1 . " " . $this->symbol . " " . $this->plate2;
        }
        if ($this->plate_type == "motor") {
            return $this->region . " " . $this->plate1 . " " . $this->plate2;
        }
        if ($this->plate_type == "free") {
            return $this->region . " " . $this->plate1;
        }
        return $this->custom;
    }

}
