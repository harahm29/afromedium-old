<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_weight extends Model
{
    use HasFactory;
    protected $table = 'var_weight';
     protected $primaryKey = 'id';
     protected $fillable = [
        'title','value_kg'
    ];
}
