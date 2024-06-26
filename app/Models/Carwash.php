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
        "balance",
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

    public function reservations()
    {
        return $this->hasMany(Reservation::class, "carwash_id");
    }

    public function banks()
    {
        return $this->morphMany(Bank::class, "bankable");
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

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class, "city_id");
    }

    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class, "state_id");
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function getLogoAttribute(): array
    {
        $image = $this->media()->where('model_type', 'carwashLogo')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'carwashLogo/';

            $image_model = Helper::getImageModel($path, $image->title);
            return ["paths" => $image_model, "model" => $image];
        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';
        $image_model = Helper::getImageModel($path, "your_logo.png", 1);

        return ["paths" => $image_model, "model" => null];
    }

    public function getImagesAttribute(): array
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

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, "likeable");
    }

    public function bookmarks(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Bookmark::class, "bookmarkable");
    }

    public function scores(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Score::class, "scorable");
    }


    public function times(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Time_table::class, 'carwash_id');
    }

    public function discounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Discount::class, "carwash_id");
    }

    public function getRateAttribute()
    {
        return $this->scores()->average("rate");
    }

    public function deposits(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Deposit::class, "depositable");
    }

    public function releases(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Release::class, "carwash_id");
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

}
