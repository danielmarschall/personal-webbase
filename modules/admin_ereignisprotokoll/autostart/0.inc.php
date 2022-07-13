<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function fehler_melden($modul, $message)
{
  global $mysql_zugangsdaten;

  $res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."ereignisprotokoll` WHERE `modul` = '".db_escape($modul)."' AND `message` = '".db_escape($message)."'", false);
  if (db_num($res) > 0)
  {
    $row = db_fetch($res);
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."ereignisprotokoll` SET `vorkommen` = `vorkommen` + 1 WHERE `id` = '".$row['id']."'", false);
  }
  else
  {
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."ereignisprotokoll` (`datetime`, `modul`, `message`, `vorkommen`) VALUES (NOW(), '".db_escape($modul)."', '".db_escape($message)."', '1')", false);
  }
}

?>
