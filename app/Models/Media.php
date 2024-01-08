<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    // **************************************** properties ****************************************
    protected $fillable = [
        'title',
        'title_fa',
        'model_type',
        'ext',
        'size',
        'width',
        'height',
        'duration',
        'mediable_type',
        'mediable_id',
    ];

    // **************************************** relations ****************************************
    public function mediable()
    {
        return $this->morphTo('mediable');
    }


}
