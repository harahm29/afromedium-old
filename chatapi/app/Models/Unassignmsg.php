<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unassignmsg extends Model
{
    use HasFactory;
    protected $table = 'unassign_messages';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'msg_id', 'notify', 'time','reply'];

    public function msg()
    {
        return $this->hasOne('App\Models\Im_msg', 'id', 'msg_id');
    }
}
