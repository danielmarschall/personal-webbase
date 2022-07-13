<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'wipe')
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll`");
  if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
}

if ($aktion == 'delete')
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll` WHERE `id` = '".db_escape($id)."'");
  if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
}

?>
