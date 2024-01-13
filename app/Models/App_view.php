<?php

namespace App\Models;

use App\Helper;
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


            $image_model = Helper::getImageModel($path, $image->title);

            return ["paths" => $image_model, "model" => $image];
        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';

        $image_model = Helper::getImageModel($path, "ic_no_product.png",1);
        return ["paths" => $image_model, "model" => null];

    }

}
