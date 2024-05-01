<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res = db_query("SELECT `html_code` FROM `".$WBConfig->getMySQLPrefix()."html` WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");
$row = db_fetch($res);

echo executable_html_code($row['html_code']);

?>