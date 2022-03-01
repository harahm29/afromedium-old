<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Var_family extends Model
{
    use HasFactory;
    protected $table = 'var_family';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];
}
