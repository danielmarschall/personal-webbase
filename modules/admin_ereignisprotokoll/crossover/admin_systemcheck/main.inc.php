<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

$meldung = '';

$res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll`");
if (db_num($res) > 0)
{
  $meldung .= '<font color="#FF0000">Es befinden sich Meldungen im <a href="'.oop_link_to_modul($m2, 'inhalt').'">Ereignisprotokoll</a>. M&ouml;glicherwei&szlig;e sind Fehler im System aufgetreten. Sie sollten diese Meldungen &uuml;berpr&uuml;fen.</font>';
}

?>