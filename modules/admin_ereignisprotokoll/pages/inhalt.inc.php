<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

  if ($modulueberschrift == '') $modulueberschrift = $modul;

  echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

  echo '<b>Anmerkung:</b> Ereignismeldungen werden von den Modulen eingetragen. Dies funktioniert jedoch nur, wenn kein Fehler in der MySQL-Datenbank besteht!<br><br>';

  wb_draw_table_begin();

  wb_draw_table_content('75', '<b>Zeitpunkt</b>', '130', '<b>Modul</b>', '', '<b>Ereignismeldung</b>', '', '<b>Folgefehler</b>', '', '<b>L&ouml;schen</b>');

  $gefunden = false;
  $res = db_query("SELECT `id`, `datetime`, `modul`, `message`, `vorkommen` FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll` ORDER BY `datetime` ASC");
  while ($row = db_fetch($res))
  {
    $gefunden = true;
    wb_draw_table_content('', $row['datetime'], '', $row['modul'], '', $row['message'], '75', ($row['vorkommen']-1), '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=kraftsetzung&amp;aktion=delete&amp;id='.urlencode($row['id']).'\');" class="menu">L&ouml;schen</a>');
  }

  if (!$gefunden)
    wb_draw_table_content('', 'Keine Ereignisse gefunden!', '', '', '', '', '', '', '', '');

  wb_draw_table_end();

  if ($gefunden)
    echo '<center><a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=kraftsetzung&amp;aktion=wipe\');">Alle Ereignismeldungen l&ouml;schen</a></center><br>';

  echo $footer;

?>
