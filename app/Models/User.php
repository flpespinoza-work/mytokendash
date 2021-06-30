<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subgroups()
    {
        return $this->belongsToMany(SubGroup::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
              ->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('phone_number', 'like', '%' . $search . '%');
    }

    public function getProfileImageAttribute()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=fef8f3&background=ed7338';
    }

    public function getLastLoginAtAttribute($value)
    {
        if($value !== null)
        {
            return Carbon::parse($value)->diffForHumans();
        }

        return 'Sin actividad';
    }

    public function getPhoneNumberAttribute($value)
    {
        if(!empty($value) && $value !== NULL)
        {
            return $value;
        }

        return 'N/A';
    }


}
