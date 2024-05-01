<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$update_checkurl = decode_critical_html_characters($update_checkurl);

if (!url_protokoll_vorhanden($update_checkurl))
{
	$update_checkurl = 'http://'.$update_checkurl;
}

wb_redirect_now($update_checkurl);

?>