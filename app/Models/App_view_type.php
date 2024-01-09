<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_view_type extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "title_fa",
        "content",
    ];

    public function app_views()
    {
        return $this->hasMany(App_view::class, 'type_id');
    }

}
