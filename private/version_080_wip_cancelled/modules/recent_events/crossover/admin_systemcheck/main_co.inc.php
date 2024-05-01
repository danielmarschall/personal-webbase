<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."recent_events`");
if (db_num($res) > 0)
{
	$meldung .= '<span class="red">Es befinden sich Meldungen im <a href="'.oop_link_to_modul($m2, 'main').'">Ereignisprotokoll</a>. M&ouml;glicherwei&szlig;e sind Fehler im System aufgetreten. Sie sollten diese Meldungen &uuml;berpr&uuml;fen.</span>';
}

?>