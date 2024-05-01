<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$url = decode_critical_html_characters($url);

if (!url_protokoll_vorhanden($url))
{
	$url = 'http://'.$url;
}

wb_redirect_now($url);

?>