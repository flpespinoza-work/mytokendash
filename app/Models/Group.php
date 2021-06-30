<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subgroups()
    {
        return $this->hasMany(SubGroup::class);
    }

    public function stores()
    {
        return $this->hasManyThrough(Store::class, SubGroup::class, 'group_id', 'subgroup_id', 'id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
              ->where('name', 'like', '%' . $search . '%');
    }

}
