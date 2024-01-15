<?php

namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "carwash_id",
        "category_id",
        "title",
        "description",
        "price",
    ];

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getLogoAttribute()
    {
        $image = $this->media()->where('model_type', 'productLogo')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'productLogo/';

            $image_model = Helper::getImageModel($path, $image->title);
            return ["paths" => $image_model, "model" => $image];
        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';
        $image_model = Helper::getImageModel($path, "ic_no_product.png", 1);

        return ["paths" => $image_model, "model" => null];
    }

    public function getImagesAttribute()
    {
        $images = $this->media()->where('model_type', 'productImages')
            ->get();

        $exist_images = [];
        if (!empty($images) && $images->count()) {
            foreach ($images as $image) {
                $path = Storage::disk("assetsStorage")->url('') . 'productImages/';

                $image_model = Helper::getImageModel($path, $image->title);
                $exist_images[] = ["paths" => $image_model, "model" => $image];
            }
        }

        return $exist_images;
    }


    public function likes()
    {
        return $this->morphMany(Like::class, "likeable");
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, "bookmarkable");
    }

    public function scores()
    {
        return $this->morphMany(Score::class, "scorable");
    }

    public function getIsBestSellerAttribute()
    {
        $lock_products = Lock_product::selectRaw("count(*) as count , product_id")->orderBy("count", "desc")->groupBy("product_id")->limit(5)->get();

        $z = $lock_products->filter(function ($item) {
            return $item->product_id == $this->id;
        })->first();

        return $z ? 1 : 0;
    }

    public function getIsRatedAttribute()
    {
        $top_score_products = Score::selectRaw("avg(rate) as avg , scorable_id")->where("scorable_type", Product::class)->orderBy("avg", "desc")->groupBy("scorable_id")->limit(5)->get();
        $z = $top_score_products->filter(function ($item) {
            return $item->scorable_id == $this->id;
        })->first();

        return $z ? 1 : 0;
    }

}
