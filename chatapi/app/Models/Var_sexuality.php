<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_sexuality extends Model
{
    use HasFactory;
    protected $table = 'var_sexuality';
     protected $primaryKey = 'id';
     protected $fillable = [
        'title','default'
    ];
}
