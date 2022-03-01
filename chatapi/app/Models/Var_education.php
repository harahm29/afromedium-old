<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_education extends Model
{
    use HasFactory;
    protected $table = 'var_education';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];
}
