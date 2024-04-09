<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "email",
        "address",
        "phone",
        "service_commission",
        "product_count",
    ];


    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getLogoAttribute()
    {
        $image = $this->media()->where('model_type', 'logo')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'logo/';
            return ["path" => $path . $image->title, "model" => $image];

        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';

        return ["path" => $path . "logo_test.png", "model" => null];

    }

    public function getIconAttribute()
    {
        $image = $this->media()->where('model_type', 'icon')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'icon/';
            return ["path" => $path . $image->title, "model" => $image];
        }

        return ["path" => "", "model" => null];
    }


}
