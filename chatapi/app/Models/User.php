<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Userinfo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
         'partner', 'gold_days', 'role', 'name', 'name_seo', 'gender', 'orientation', 'p_orientation', 'relation', 'couple', 'couple_id', 'mail', 'change_mail', 'password', 'avatar', 'is_photo', 'is_photo_public', 'record', 'record_id', 'country_id', 'state_id', 'city_id', 'country', 'state', 'city', 'zip', 'birth', 'p_age_from', 'p_age_to', 'horoscope', 'p_horoscope', 'active', 'active_code', 'hide_time', 'register', 'last_visit', 'rating', 'new_mails', 'new_interests', 'new_views', 'total_views', 'last_ip', 'set_email_mail', 'set_email_interest', 'type', 'city_money', 'forum_n_messages', 'sound', 'blog_visits', 'blog_comments', 'blog_posts', 'vid_visits', 'vid_comments', 'vid_videos', 'vid_videos_pages', 'vid_videos_groups', 'moderator_photo', 'moderator_vids_video', 'moderator_texts', 'moderator_profiles', 'facebook_id', 'google_plus_id', 'linkedin_id', 'twitter_id', 'vk_id', 'default_online_view', 'albums_to_see', 'wall_like_comment_alert', 'use_as_online', 'isMobile', 'couple_from', 'couple_to', 'state_narrow_box', 'match_mail', 'lang', 'smart_profile', 'wall_only_post', 'review_link', 'color_scheme', 'ban_mails', 'is_online_users_im', 'ban_time', 'ban_time_release', 'i_am_here_to', 'profile_bg', 'set_who_view_profile', 'set_can_comment_photos', 'set_notif_profile_visitors', 'set_notif_gifts', 'set_notif_voted_photos', 'set_notif_push_notifications', 'set_hide_my_presence', 'set_do_not_show_me_visitors', 'rated_photos', 'last_photo_visible_rated', 'popularity', 'credits', 'date_search', 'date_encounters', 'sp_sending_messages_per_day', 'profile_bg_video', 'set_notif_mutual_attraction', 'set_notif_want_to_meet_you', 'set_notif_new_msg', 'set_notif_new_comments', 'ban_global', 'password_reminder', 'payment_day', 'payment_hour', 'wall_mode', 'users_reports', 'translation_off', 'timezone', 'video_greeting', 'admin', 'auth_key', 'last_broadcast', 'hide_ads', 'im_reply_new_contact_rate', 'welcoming_message_notify', 'geo_position_lat', 'geo_position_long', 'geo_position_age', 'geo_position_city_id', 'geo_position_state_id', 'geo_position_country_id', 'geo_position_city', 'geo_position_state', 'geo_position_country', 'set_notif_show_my_age', 'wall_post_access','user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function profile()
    {
        return $this->hasOne('App\Models\Photo', 'user_id', 'user_id');
    }
    // public function status1()
    // {
    //     return $this->hasOne('App\Models\Profile_status', 'user_id', 'user_id');
    // }
    public function uinfo(){
        return $this->hasOne('App\Models\Userinfo', 'user_id', 'user_id')->with(['statusa','sexualitys','weights',
            'bodys','hairs','eyes','familys','smokings','drinkings','educations']); 

    }

   


}
