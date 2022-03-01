<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_drinking extends Model
{
    use HasFactory;
    protected $table = 'var_drinking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];
}
