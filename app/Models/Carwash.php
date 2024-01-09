<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

}
