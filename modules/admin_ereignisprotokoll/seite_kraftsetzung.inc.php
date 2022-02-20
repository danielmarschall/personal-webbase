<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($aktion == 'wipe')
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll`");
  if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
}

if ($aktion == 'delete')
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll` WHERE `id` = '".db_escape($id)."'");
  if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
}

?>