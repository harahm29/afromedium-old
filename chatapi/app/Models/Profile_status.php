<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_status extends Model
{
    use HasFactory;
     protected $table = 'profile_status';
     //protected $primaryKey = 'user_id';
     protected $fillable = [
        'user_id', 'status', 'date'
    ];
}
