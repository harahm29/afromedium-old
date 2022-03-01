<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Im_msg extends Model
{
    use HasFactory;
    protected $table = 'im_msg';
    protected $primaryKey = 'id';
    protected $fillable = ['from_user', 'from_group_id', 'to_user', 'to_group_id', 'group_id', 'name', 'msg', 'ip', 'is_new', 'system', 'system_type', 'from_user_deleted', 'to_user_deleted', 'msg_translation', 'send', 'audio_message_id', 'msg_hash', 'assign_user', 'reply', 'assign_time', 'bron' ];


    public function to_users()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'to_user');
    }
    public function from_users()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'from_user');
    }
    public function admin()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'from_user');
    }
    public function profilem()
    {
        return $this->hasOne('App\Models\Photo', 'user_id', 'from_user');
    }

}
