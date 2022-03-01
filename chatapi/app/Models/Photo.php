<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
     protected $table = 'photo';
     protected $primaryKey = 'photo_id';
     protected $fillable = [
         'photo_id', 'user_id', 'group_id', 'group_page', 'group_private', 'date', 'photo_name', 'description', 'visible', 'nudity', 'default', 'default_group', 'private', 'votes', 'rating', 'average', 'wall_id', 'published', 'users_reports', 'version', 'width', 'height', 'count_comments_all', 'count_comments', 'count_comments_replies', 'count_views', 'hide_header', 'like', 'dislike'
    ];
}
