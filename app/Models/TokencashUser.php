<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokencashUser extends Model
{
    use HasFactory;

    protected $connection = 'tokencash';
    protected $table = 'cat_dbm_nodos_usuarios';
}
