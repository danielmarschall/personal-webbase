<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

echo '<b>Anmerkung:</b> Ereignismeldungen werden von den Modulen eingetragen. Dies funktioniert jedoch nur, wenn kein Fehler in der MySQL-Datenbank besteht!<br><br>';

wb_draw_table_begin();

wb_draw_table_content('75', '<b>Zeitpunkt</b>', '130', '<b>Modul</b>', '', '<b>Ereignismeldung</b>', '', '<b>Folgefehler</b>', '', '<b>L&ouml;schen</b>');

$gefunden = false;
$res = db_query("SELECT `id`, `datetime`, `module`, `message`, `appearances` FROM `".$WBConfig->getMySQLPrefix()."recent_events` ORDER BY `datetime` ASC");
while ($row = db_fetch($res))
{
	$gefunden = true;
	wb_draw_table_content('', $row['datetime'], '', $row['module'], '', $row['message'], '75', ($row['appearances']-1), '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=delete&amp;id='.$row['id'].'\');" class="menu">L&ouml;schen</a>');
}

if (!$gefunden) {
	wb_draw_table_content('', '', '', '', '', 'Keine Ereignisse gefunden!', '', '', '', '');
}

wb_draw_table_end();

if ($gefunden)
	echo '<center><a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=wipe\');">Alle Ereignismeldungen l&ouml;schen</a></center><br>';

echo $footer;

?>