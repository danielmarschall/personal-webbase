<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (($konfiguration[$m2]['enable_gast'] == '1') && ($konfiguration[$m2]['wipe_gastkonto']))
{
  $rs = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".$konfiguration[$m2]['gast_username']."' AND MD5('".$konfiguration[$m2]['gast_passwort']."') = `passwort`");

  if (db_num($rs) == 1)
  {
    $rw = db_fetch($rs);
    $my_id = $rw['id'];

    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."konfig` WHERE `name` = 'last_wipe' AND CONCAT(`wert`, ' ', '".$konfiguration[$m2]['wipe_uhrzeit']."') <= DATE_SUB(NOW(), INTERVAL 1 DAY) AND `modul` = '".db_escape($m2)."'");
    if (db_num($res) > 0)
    {
      // Für was den ganzen Fetz? Wenn PHP und MySQL Zeit verschieden sind (z.B. auf unterschiedliche Server verteilt), gäbe es Probleme!
      $rs = db_query("SELECT NOW()");
      $rw = db_fetch($rs);
      $ary = explode(' ', $rw[0]);
      $dat = $ary[0];

      ib_change_config('last_wipe', $dat, $m2);

      foreach($tabellen as $m1 => $m2)
      {
        if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$m2]['user']))
          db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."$m2` WHERE `user` = '$my_id'");
      }

      unset($m1);
	  unset($m2);
    }
  }
}

?>