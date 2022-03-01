<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_smoking extends Model
{
    use HasFactory;
    protected $table = 'var_smoking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];
}
