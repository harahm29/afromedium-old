<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    use HasFactory;
     protected $table = 'userinfo';
     protected $primaryKey = 'user_id';
     protected $fillable = [
        'user_id', 'headline', 'essay', 'height', 'weight', 'body', 'drinking', 'ethnicity', 'eye', 'religion', 'family', 'hair', 'income', 'career', 'smoking', 'status', 'age_preference', 'appearance', 'first_date', 'humor', 'level_of_faith', 'live_where', 'living_with', 'spending_habits', 'user_editor_xml', 'about_me', 'interested_in', 'interests', 'sexuality', 'star_sign', 'education', 'user_search_filters', 'state_filter_search', 'user_search_filters_mobile', 'your_private_note', 'blogs_filters', 'videos_filters', 'videos_pages_filters', 'videos_groups_filters', 'photos_filters', 'photos_pages_filters', 'photos_groups_filters', 'groups_filters', 'pages_filters', 'create_task_user_id'
    ];

    public function statusa(){
        return $this->hasOne('App\Models\Var_status','id','status');
    }

    public function sexualitys(){
        return $this->hasOne('App\Models\Var_sexuality','id','sexuality');
    }

    public function weights(){
        return $this->hasOne('App\Models\Var_weight','id','weight');
    }

    public function bodys(){
        return $this->hasOne('App\Models\Var_body','id','body');
    }
     
    public function hairs(){
        return $this->hasOne('App\Models\Var_hair','id','hair');
    }
    public function eyes(){
        return $this->hasOne('App\Models\Var_eye','id','eye');
    }
    public function familys(){
        return $this->hasOne('App\Models\Var_family','id','family');
    }
    public function smokings(){
        return $this->hasOne('App\Models\Var_smoking','id','smoking');
    }
    public function drinkings(){
        return $this->hasOne('App\Models\Var_drinking','id','drinking');
    }

    public function educations(){
        return $this->hasOne('App\Models\Var_education','id','education');
    }
    
    
}
