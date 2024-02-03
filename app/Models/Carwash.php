<?php

namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Carwash extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "title",
        "lat",
        "long",
        'uuid',
        'platform',
        'model',
        'os',
        'mobile',
        "address",
        "city_id",
        "state_id",
        "product_count",
        "payment",
        "status",
        "type",
        "certified",
        "promoted",
        "message",
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function banks()
    {
        return $this->hasMany(Bank::class, "carwash_id");
    }

    public function products()
    {
        return $this->hasMany(Product::class, "carwash_id");
    }

    public function services()
    {
        return $this->hasMany(Service::class, "carwash_id");
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class, "carwash_id");
    }

    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }

    public function state()
    {
        return $this->belongsTo(State::class, "state_id");
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getLogoAttribute()
    {
        $image = $this->media()->where('model_type', 'carwashLogo')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'carwashLogo/';

            $image_model = Helper::getImageModel($path, $image->title);
            return ["paths" => $image_model, "model" => $image];
        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';
        $image_model = Helper::getImageModel($path, "ic_no_avatar.png", 1);

        return ["paths" => $image_model, "model" => null];
    }

    public function getImagesAttribute()
    {
        $images = $this->media()->where('model_type', 'carwashImages')
            ->get();

        $exist_images = [];
        if (!empty($images) && $images->count()) {
            foreach ($images as $image) {
                $path = Storage::disk("assetsStorage")->url('') . 'carwashImages/';

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


    public function times()
    {
        return $this->hasMany(Time_table::class, 'carwash_id');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, "carwash_id");
    }

    public function getRateAttribute()
    {
        return $this->scores()->average("rate");
    }

}
