<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'delete')
  {
    $res = db_query("SELECT `table`, `modul` FROM `".$mysql_zugangsdaten['praefix']."module` WHERE `id` = '".db_escape($id)."'");
    $row = db_fetch($res);

    if (is_dir('modules/'.wb_dir_escape($row['modul'])))
    {
      db_query("TRUNCATE TABLE `".$mysql_zugangsdaten['praefix'].$row['table']."`");
    }
    else
    {
      db_query("DROP TABLE `".$mysql_zugangsdaten['praefix'].$row['table']."`");
    }

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
  }

?>
