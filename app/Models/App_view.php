<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class App_view extends Model
{
    use HasFactory;

    protected $fillable = [
        "type_id",
        "title",
        "title_color",
        "description",
        "description_color",
        "background_color",
        "action",
        "action_color",
        "order",
        "need_space",
        "status",
    ];


    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function carwashes()
    {
        return $this->morphedByMany(Carwash::class, 'viewable', 'app_viewable', 'view_id');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'viewable', 'app_viewable', 'view_id');

    }

    public function type()
    {
        return $this->belongsTo(App_view_type::class, 'type_id');
    }

    public function getBackgroundAttribute()
    {
        $image = $this->media()->where('model_type', 'viewBackground')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'viewBackground/';
            return ["path" => $path . $image->title, "model" => $image];
        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';

        return ["path" => $path . "ic_no_product_logo.png", "model" => null];
    }

}
