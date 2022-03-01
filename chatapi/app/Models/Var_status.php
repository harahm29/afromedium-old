<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_status extends Model
{
    use HasFactory;
     protected $table = 'var_status';
     protected $primaryKey = 'id';
     protected $fillable = [
        'title'
    ];

   
}
