<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_eye extends Model
{
    use HasFactory;
    protected $table = 'var_eye';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];
}
