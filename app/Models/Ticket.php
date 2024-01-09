<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        "ticketable_type",
        "ticketable_id",
        "title",
        "status",
    ];


    public function ticketable()
    {
        return $this->morphTo('ticketable');
    }

    public function messages()
    {
        return $this->hasMany(Ticket_message::class, 'ticket_id');
    }

}
