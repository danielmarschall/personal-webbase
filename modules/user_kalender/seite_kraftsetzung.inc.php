<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  if ($aktion == 'edit')
  {
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."kalender` SET `name` = '".db_escape($name)."', `start_date` = '".$datum3.'-'.$datum2.'-'.$datum1."', `start_time` = '".$zeit1.':'.$zeit2.':00'."', `kommentare` = '".db_escape($kommentare)."' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=auflistung&modul='.$modul);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
  }

  if ($aktion == 'new')
  {
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."kalender` (`name`, `start_date`, `start_time`, `kommentare`, `user`) VALUES ('".db_escape($name)."', '".$datum3.'-'.$datum2.'-'.$datum1."', '".$zeit1.':'.$zeit2.':00'."', '".db_escape($kommentare)."', '".$benutzer['id']."')");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=auflistung&modul='.$modul);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&herkunft='.$herkunft.'&modul='.$modul.'&aktion=new&danach='.$danach);
  }

  if ($aktion == 'delete')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."kalender` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."kalender`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.$zurueck.'&modul='.$modul);
  }

?>