<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res = db_query("SELECT `hcode` FROM `".$mysql_zugangsdaten['praefix']."html` WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");
$row = db_fetch($res);

echo ausfuehrbarer_html_code($row['hcode']);

?>
