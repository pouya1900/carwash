<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = [
        "mobile",
        "first_name",
        "last_name",
        "role_id",
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function messages()
    {
        return $this->hasMany(Ticket_message::class, 'admin_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function hasPermission($permission)
    {
        if (is_array($permission)) {
            if (empty($permission = $this->role->permissions()->whereIn('name', $permission)->first())) {
                return false;
            }

            return $permission;
        }

        if (empty($permission = $this->role->permissions()->where('name', $permission)->first())) {
            return false;
        }

        return $permission;
    }

    public function isSuperAdmin()
    {
        if ($this->role->name == "super") {
            return true;
        }
        return false;
    }

    public function getAvatarAttribute()
    {
        $image = $this->media()->where('model_type', 'avatar')
            ->first();

        if (!empty($image)) {
            $path = Storage::disk("assetsStorage")->url('') . 'avatar/';
            return ["path" => $path . $image->title, "model" => $image];

        }
        $path = Storage::disk("assetsStorage")->url('') . 'siteContent/';

        return ["path" => $path . "ic_no_avatar.png", "model" => null];
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }


}
