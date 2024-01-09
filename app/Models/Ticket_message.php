<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_message extends Model
{
    use HasFactory;

    protected $fillable = [
        "ticket_id",
        "admin_id",
        "sender",
        "text",
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'admin_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

}
