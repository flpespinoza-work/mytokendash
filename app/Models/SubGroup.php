<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stores()
    {
        return $this->hasMany(Store::class, 'subgroup_id', 'id');
    }
}
