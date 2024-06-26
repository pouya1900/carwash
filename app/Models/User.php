<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'uuid',
        'platform',
        'model',
        'os',
        'mobile',
        'email',
        'language',
        'balance',
        'gift_balance',
        'firebase_token',
        'lat',
        'long',
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
        return $this->hasMany(Reservation::class, "user_id");
    }

    public function cars()
    {
        return $this->hasMany(Car::class, "user_id");
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, "user_id");
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, "user_id");
    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, "user_id");
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, "user_id");
    }

    public function getAvatarAttribute()
    {
        $image = $this->media()->where('model_type', 'avatar')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'avatar/';

            $image_model = Helper::getImageModel($path, $image->title);
            return ["paths" => $image_model, "model" => $image];
        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';
        $image_model = Helper::getImageModel($path, "ic_no_avatar.png", 1);

        return ["paths" => $image_model, "model" => null];
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class, "user_id");
    }

    public function deposits()
    {
        return $this->morphMany(Deposit::class, "depositable");
    }

    public function banks()
    {
        return $this->morphMany(Bank::class, "bankable");
    }

}
