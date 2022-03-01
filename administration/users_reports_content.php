<?php
/* (C) Websplosion LTD., 2001-2014

IMPORTANT: This is a commercial software product
and any kind of using it must agree to the Websplosion's license agreement.
It can be found at http://www.chameleonsocial.com/license.doc

This notice may not be removed from the source code. */

include('../_include/core/administration_start.php');

class CUsersReports extends CHtmlList
{
	function action()
	{
		global $p;

        $cmd = get_param('cmd');

        if ($cmd) {
            $del = get_param('delete');
            $rid = get_param('report_id');
            $pid = get_param('photo_id');
            $uid = get_param('user_id');

            function deleteReport($del){
                $listUsersReport = explode(',', $del);
                foreach ($listUsersReport as $rid) {
                    $where = 'id = ' . to_sql($rid);
                    $report = DB::select('users_reports', $where);
                    $usersToReport = array();
                    if ($report && isset($report[0])) {
                        $report = $report[0];
                        $wherePhoto = '`photo_id` = ' . to_sql($report['photo_id']);
                        $usersToReport = DB::field('photo', 'users_reports', $wherePhoto);
                        DB::delete('users_reports', $where);
                    }
                    if ($usersToReport && isset($usersToReport[0])) {
                        $usersToReport = $usersToReport[0];
                        $usersToReport = explode(',', $usersToReport);
                        unset_from_array($report['user_from'], $usersToReport);
                        DB::update('photo', array('users_reports' => implode(',', $usersToReport)), $wherePhoto);
                    }
                }
            }

            if ($cmd == 'delete_report' && $rid){
                deleteReport($rid);
                redirect("{$p}?action=delete");
            }elseif ($cmd == 'delete_photo' && $pid && $uid){
                CProfilePhoto::deletePhoto($pid, false, $uid, true);
                $reports = DB::field('users_reports', 'id', '`photo_id` = ' . to_sql($pid));
                if ($reports) {
                    deleteReport(implode(',', $reports));
                }
                redirect("{$p}?action=delete");
            }elseif ($cmd == 'delete_video' && $pid && $uid){
                require_once("../_include/current/vids/includes.php");
                CVidsTools::delVideoById($pid, true);
                $reports = DB::field('users_reports', 'id', 'video = 1 AND `photo_id` = ' . to_sql($pid));
                if ($reports) {
                    deleteReport(implode(',', $reports));
                }
                redirect("{$p}?action=delete");
            }elseif ($cmd == 'ban' && $uid) {
                $sql = 'UPDATE `user`
                           SET `ban_global` = 1 - `ban_global`
                         WHERE `user_id` = '. to_sql($uid, 'Number');
                DB::execute($sql);
                redirect();
            }
        }
	}
	function init()
	{
		global $g;

        $this->m_on_page = 20;
		$this->m_on_bar = 10;

		$this->m_sql_count = "SELECT COUNT(UR.id) FROM users_reports AS UR " . $this->m_sql_from_add;
		$this->m_sql = "SELECT UR.*, UF.name AS name_from, UT.name AS name_to, UT.ban_global AS ban_to, UT.gender AS gender_to
                          FROM users_reports AS UR
                          JOIN user AS UF ON UF.user_id = UR.user_from
                          JOIN user AS UT ON UT.user_id = UR.user_to" . $this->m_sql_from_add;

        $this->m_field['id'] = array("id", null);
        $this->m_field['date'] = array("date", null);
        $this->m_field['user_from'] = array("user_from", null);
        $this->m_field['user_to'] = array("user_to", null);
        $this->m_field['msg'] = array("msg", null);
        $this->m_field['ban_to'] = array("ban_to", null);
        $this->m_field['name_from'] = array("name_from", null);
        $this->m_field['name_to'] = array("name_to", null);
        $this->m_field['photo_id'] = array("photo_id", null);
        $this->m_field['video'] = array("video", null);

        $this->m_sql_where = "UR.photo_id != 0 AND UR.group_id = 0";
		$this->m_sql_order = "id";
		#$this->m_debug = "Y";
	}

    function onPostParse(&$html)
	{
        if ($this->m_total != 0) {
            $html->parse('no_delete');
        }
	}

	function onItem(&$html, $row, $i, $last)
	{
		global $g;

        if($row['ban_to']){
			$this->m_field['ban_to'][1] = l('unban_user');
		} else {
			$this->m_field['ban_to'][1] = l('ban_user');
		}
        $this->m_field['msg'][1] = nl2br($row['msg']);

        if($row['video']) {
            $video = DB::row('SELECT * FROM vids_video WHERE id = ' . to_sql($row['photo_id']), DB_MAX_INDEX);
            if($video) {
                $html->setvar('video_id', $row['photo_id']);
                $html->setvar('video_url', User::getVideoFile($video, 'b', ''));
                $html->parse('video_url', false);
                $html->clean('photo_url');
            }

            $cmd = 'delete_video';

        } else {
            $photo = DB::select('photo', 'photo_id = ' . to_sql($row['photo_id'], 'Number'));
            $photoUrl = l('no_photo');
            if (isset($photo[0])) {
                $photoUrl = User::photoFileCheck($photo[0], 'r', $row['gender_to']);
                $html->setvar('photo_url', $photoUrl);
                $html->clean('no_photo_url');
                $html->parse('photo_url', false);
            } else {
                $html->clean('photo_url');
                $html->parse('no_photo_url', false);
            }

            $html->clean('video_url');

            $cmd = 'delete_photo';
        }

        $html->setvar('cmd', $cmd);

		parent::onItem($html, $row, $i, $last);
	}
}

$page = new CUsersReports('main', $g['tmpl']['dir_tmpl_administration'] . 'users_reports_content.html');
$header = new CAdminHeader('header', $g['tmpl']['dir_tmpl_administration'] . '_header.html');
$page->add($header);
$footer = new CAdminFooter('footer', $g['tmpl']['dir_tmpl_administration'] . '_footer.html');
$page->add($footer);

$page->add(new CAdminPageMenuBlock());

include('../_include/core/administration_close.php');