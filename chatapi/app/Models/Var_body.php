<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_body extends Model
{
    use HasFactory;
    protected $table = 'var_body';
     protected $primaryKey = 'id';
     protected $fillable = [
        'title'
    ];
}
