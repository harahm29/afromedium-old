<?php
/* (C) Websplosion LTD., 2001-2014

IMPORTANT: This is a commercial software product
and any kind of using it must agree to the Websplosion's license agreement.
It can be found at http://www.chameleonsocial.com/license.doc

This notice may not be removed from the source code. */

include("./_include/core/main_start.php");
require_once("./_include/current/groups/group_member_list.php");

$page = new CGroupsGroupMemberList("", $g['tmpl']['dir_tmpl_main'] . "_groups_group_member_list.html");
$page->m_need_container = false;

include("./_include/core/main_close.php");