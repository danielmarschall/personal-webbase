<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

function set_searchable($mod, $tab, $sta)
{
  global $mysql_zugangsdaten, $datenbanktabellen;

  if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'module']['is_searchable']))
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."module` SET `is_searchable` = '$sta' WHERE `modul` = '$mod' AND `table` = '$tab'");
}

function is_searchable($tab)
{
  global $mysql_zugangsdaten, $datenbanktabellen;

  if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'module']['is_searchable']))
  {
    $rs = db_query("SELECT `is_searchable` FROM `".$mysql_zugangsdaten['praefix']."module` WHERE `table` = '$tab'");
    $rw = db_fetch($rs);
    return $rw['is_searchable'];
  }
  else
  {
    return false;
  }
}

?>