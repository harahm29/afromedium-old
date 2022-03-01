<?php
/* (C) Websplosion LTD., 2001-2014

IMPORTANT: This is a commercial software product
and any kind of using it must agree to the Websplosion's license agreement.
It can be found at http://www.chameleonsocial.com/license.doc

This notice may not be removed from the source code. */

$g['template_options'] = array(
    'set' => 'urban',
    'name' => 'impact_mobile',
    'main_template' => array('impact'),
    'logo_mobile_inner' => 'Y',
    'logo_mobile_svg' => 'Y',
    'logo_mobile_inner_svg' => 'Y',
    'logo_w' => 172,
    'logo_h' => 29,
    'logo_inner_w' => 116,
    'logo_inner_h' => 19,
    'type_payment_plan' => 'impact',
    'type_payment_features' => 'impact',
    'type_payment_module' => 'payment_module_impact_mobile',
    'type_payment_module_credits' => 'payment_module_boost',
    'custom_profile_html' => 'profile_html_urban',
    'profile_photo_main_size' => 'bm',
    'profile_photo_size' => 'mm',
    'profile_video_size' => 'src',
    'pofile_status_empty_title' => 'Y',
    'profile_menu_the_same_user_menu' => 'Y',
    'profile_visitor_charts' => 'Y',
    'profile_visitor_charts_size' => array(1 => 110, 2 => 70, 3 => 85),
    'profile_visitor_no_block_report' => 'Y',
    'not_display_module' => array('profile_view_menu', 'friends_list', 'people_nearby_spotlight', 'profile_menu', 'user_menu'),
    'fields_not_available' => array(541,457),
    'profile_edit_main_location' => 'Y',
    'login_page_template' => 'index.html',
    'register_page_template' => 'register.html',
    'messages_one_chat_page_template' => 'messages_one_chat.html',
    'login_by_name_or_mail' => 'Y',
    'user_menu_type' => 'impact',
    'user_menu_no_profile' => 'Y',
    'hide_profile_settings' => array('set_can_comment_photos', 'color_scheme',
                                     'albums_to_see', 'default_online_view', 'autologin', 'smart_profile',
                                     'sound', 'framework_version', 'set_email_mail',
                                     'wall_like_comment_alert', 'set_notif_gifts', 'interest_alert_options',
                                     'wall_only_post', 'set_who_view_profile'),
    'pofile_status_visitor' => 'Y',
    'is_allow_empty_footer' => 'Y',
    'format_date_months_join' => 'M',
    'private_photo_by_template' => 'Y',
    'no_photo_by_template' => 'Y',
    'usersinfo_per_page' => 12,
    'usersinfo_pages_per_list' => 10,
    'usersinfo_encounters_list' => 10,
    'home_page' => 'profile_view.php',
    'do_not_show_me_in_search' => 'Y',
    'list_users_info_ajax' => 'Y',
    'list_users_info_tmpl' => 'Y',
    'chat_with_popular_users_off' => 'Y',
    'feature_super_powers_allowed' => array('message_read_receipts'),
    'width_captcha' => 131,
    'height_captcha' => 32,
    'ratio_font_captcha' => 1.3,
    'ratio_distance_captcha' => 1.5,
    'color_scheme_svg_footer_file_settings' => array(
        'source_file' => 'images/footer_figure.svg',
        'svg_file_name' => '_footer_figure_',
        'config_option' => 'color_scheme_mobile_footer_color_impact',
    ),
    'private_photo_ext' => 'svg',

    'color_scheme_mobile_main_page_background_image' => '1.jpg',
    'color_scheme_activate' => 'Y',
    'color_scheme_type' => 'impact',

    'parse_banner_block' => array('footer_mobile' => 'content'),

    /*need to check, whether or not */
    'display_info_page_template' => '_profile_info.html',
    'custom_profile_info_html' => 'profile_html_urban',
    'page_upgrade_allowed' => 'Y',
    'number_empty_block_spotlight' => 6,
    'upload_icon_field_i_am_here_to' => 'N',
    'upload_icon_field_orientation' => 'N',
    'order_mobile_user_menu' => 'Y',
    'banner_header_mobile' => 'Y',
    'redirect_user_blocked' => 'Y',

    'access_check_to_profile' => 'Y',
    'encounters_only_public_photos' => 'Y',
    'not_allowed_chat_with_popular_users' => 'Y',
    'near_me_radius' => 25,
    'page_redirect_min_photos_to_use_site' => 'profile_view',
    'allow_like_profile_without_photos' => 'Y',
    'gifts_disabled' => 'Y',
    /*'rtl_style' => 'Y'*/

    'im_send_image' => 'Y'
);

Common::setOptionRuntime('N', 'wall_like_comment_alert');