<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_name',
        'contact_phone'
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
              ->where('name', 'like', '%' . $search . '%');
    }

}
