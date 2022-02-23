<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

    if ($modulueberschrift == '') $modulueberschrift = $modul;
    echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo 'Hier sind alle Benutzer aufgelistet.<br><br>';

    gfx_begintable();
    gfx_tablecontent('', '<b>Benutzername</b>', '', '<b>E-Mail-Adresse</b>', '100', '<b>Datens&auml;tze</b>', '100', '<b>Ordner</b>', '100', '<b>Aktionen</b>', '100', '', '100', '');

    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` ORDER BY `id`");
    $eintrag = false;
    while ($row = db_fetch($res))
    {
      if (($konfiguration['main_gastzugang']['enable_gast'] == '1') && ($row['username'] == $konfiguration['main_gastzugang']['gast_username']) && ($row['passwort'] == md5($konfiguration['main_gastzugang']['gast_passwort']))) // TODO: use sha3 hash, salted and peppered
        $status = ' (Gast)';
      else
        $status = '';
      if ($row['gesperrt'])
        $sperr = 'Entsperren';
      else
        $sperr = 'Sperren';

      $count_ds = 0;
	  $count_o = 0;

	  foreach ($tabellen as $m1 => $m2)
	  {
        if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$m2]['user']))
        {
	      $res2 = db_query("SELECT COUNT(`id`) AS `cid` FROM `".$mysql_zugangsdaten['praefix']."$m2` WHERE `user` = '".$row['id']."'");
	      $row2 = db_fetch($res2);
	      if ($m2 == 'ordner')
	        $count_o += $row2['cid'];
	      else
	 	    $count_ds += $row2['cid'];
	 	}
	  }

	  unset($m1);
	  unset($m2);

	  if ($row['email'] != '')
	    $maila = '<a href="mailto:'.$row['email'].'" class="menu">'.$row['email'].'</a>';
	  else
	    $maila = 'Unbekannt';

      gfx_tablecontent('', $row['username'].$status, '', $maila, '', $count_ds , '', $count_o, '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=kraftsetzung&amp;aktion=lock&amp;id='.urlencode($row['id']).'" class="menu">'.$sperr.'</a>', '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=edit&amp;id='.urlencode($row['id']).'" class="menu">Bearbeiten</a>', '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=kraftsetzung&amp;aktion=del&amp;id='.urlencode($row['id']).'\');" class="menu">L&ouml;schen</a>');

      $eintrag = true;
    }

    if (!$eintrag)
      gfx_tablecontent('', 'Keine Benutzer vorhanden!', '', '', '', '', '', '', '', '', '', '', '', '');
    gfx_endtable();

    echo $footer;

?>
