<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        "carwash_id",
        "user_id",
        "status",
        "price",
        "address_id",
        "car_id",
        "type_id",
        "payment_id",
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, "payment_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id");
    }

    public function services()
    {
        return $this->morphedByMany(Lock_service::class, "reservationable", 'reservationable');
    }

    public function products()
    {
        return $this->morphedByMany(Lock_product::class, "reservationable", 'reservationable')->withPivot("quantity");
    }

    public function carwash()
    {
        return $this->belongsTo(Carwash::class, "carwash_id");
    }

    public function score()
    {
        return $this->hasOne(Score::class, "reservation_id");
    }

    public function car()
    {
        return $this->belongsTo(Car::class, "car_id");
    }

    public function type()
    {
        return $this->belongsTo(Type::class, "type_id");
    }

    public function time()
    {
        return $this->hasOne(Time_table::class, "reservation_id");
    }

}
