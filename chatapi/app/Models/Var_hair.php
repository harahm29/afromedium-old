<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_hair extends Model
{
    use HasFactory;
     protected $table = 'var_hair';
     protected $primaryKey = 'id';
     protected $fillable = [
        'title'
    ];
}
