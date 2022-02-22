<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

  $my_str = '';
  $res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."users`");
  while ($row = db_fetch($res))
    $my_str .= "'".$row['id']."', ";
  $my_str = substr($my_str, 0, strlen($my_str)-2);

	$count_ds = 0;
	$count_o = 0;

	foreach ($tabellen as $m1 => $m2)
	{
      if (($my_str != '') && (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$m2]['user'])))
      {
	    $res = db_query("SELECT COUNT(`id`) AS `cid` FROM `".$mysql_zugangsdaten['praefix']."$m2` WHERE `user` IN ($my_str)");
	    $row = db_fetch($res);
	    if ($m2 == 'ordner')
	      $count_o += $row['cid'];
	    else
	      $count_ds += $row['cid'];
	  }
	}

	unset($m1);
	unset($m2);

    if ($modulueberschrift == '') $modulueberschrift = $modul;
    echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

    echo '<span style="font-size:1.2em"><b>Serverdaten</b></span><br><br>';
    gfx_begintable();
	gfx_tablecontent('40%', '<b>Anmeldeserver</b>', '60%', $mysql_zugangsdaten['server']);

	if ($konfiguration['main_ueber']['admin_mail'] != '')
	  $addr = '<a href="mailto:'.$konfiguration['main_ueber']['admin_mail'].'" class="menu">'.$konfiguration['main_ueber']['admin_mail'].'</a>';
    else
	  $addr = 'Keine angegeben';

	gfx_tablecontent('40%', '<b>Administrator E-Mail-Adresse</b>', '60%', $addr.' (<a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul=main_ueber&amp;vonmodul='.urlencode($modul).'&amp;vonseite='.urlencode($seite).'" class="menu">&Auml;ndern</a>)');

	$rs = db_query("SELECT NOW()");
	$rw = db_fetch($rs);

	if (date('Y-m-d H:i:s') != $rw[0])
    {
      // Kann vorkommen, wenn MySQL-Server sich auf einem anderen System befindet
	  gfx_tablecontent('40%', '<b>PHP-Zeit</b>', '60%', de_convertmysqldatetime(date('Y-m-d, H:i:s'), true));
	  gfx_tablecontent('40%', '<b>MySQL-Zeit</b>', '60%', de_convertmysqldatetime($rw[0], true));
	}
	else
	  gfx_tablecontent('40%', '<b>Serverzeit</b>', '60%', de_convertmysqldatetime(date('Y-m-d, H:i:s'), true));

    gfx_endtable();

    echo '<span style="font-size:1.2em"><b>Datenbankstatistik</b></span><br><br>';
    gfx_begintable();

	gfx_tablecontent('40%', '<b>Letzter Login</b>', '60%', de_convertmysqldatetime($_SESSION['last_login']));

    if ($_SESSION['last_login_ip'] == '')
      $ueip = 'Unbekannt';
    else
      $ueip = '<a href="http://www.ripe.net/fcgi-bin/whois?form_type=simple&amp;full_query_string=&amp;searchtext='.urlencode($_SESSION['last_login_ip']).'&amp;submit.x=0&amp;submit.y=0" target="_blank" class="menu">'.$_SESSION['last_login_ip'].'</a> (DNS: '.@gethostbyaddr($_SESSION['last_login_ip']).')';

	gfx_tablecontent('40%', '<b>&Uuml;ber IP</b>', '60%', $ueip);
	gfx_tablecontent('40%', '<b>Benutzer-Datens&auml;tze der Datenbank</b>', '60%', $count_ds);
	gfx_tablecontent('40%', '<b>Benutzer-Ordner der Datenbank</b>', '60%', $count_o);
	gfx_tablecontent('40%', '<b>Installierte Module</b>', '60%', count($module).' (<a href="'.oop_link_to_modul('admin_module').'" class="menu">Verwalten</a>)');
    gfx_tablecontent('40%', '<b>Angelegte Tabellen</b>', '60%', count($tabellen).' (<a href="'.oop_link_to_modul('admin_datenbank').'" class="menu">Verwalten</a>)');
	gfx_endtable();

    echo '<span style="font-size:1.2em"><b>Installierte Module</b></span><br><br>';

	    $i = -1;
	    foreach ($module as $m1 => $m2)
	    {
	      if (file_exists('modules/'.wb_dir_escape($m2).'/seite_inhalt.inc.php'))
	      {
	        $titel = $m2;

            $modulueberschrift = '';
            $modulsekpos = '';
            $modulpos = '';
            $modulrechte = '';
            $autor = '';
            $version = '';
            $menuevisible = '';
            $license = '';
            $deaktiviere_zugangspruefung = 0;

	        if (file_exists('modules/'.wb_dir_escape($m2).'/var.inc.php'))
	        {
	          include('modules/'.wb_dir_escape($m2).'/var.inc.php');
	          $titel = $modulueberschrift;
	        }

	        if (($modulrechte == 2) && ($menuevisible) && ($modul != $m2))
	        {
	          $i++;

	          if ($i == 0)
	          echo '<center><table cellspacing="6" cellpadding="6" border="0" width="90%"><tr>';

	          if (($i % 7 == 0) && ($i != 0))
	          echo '</tr><tr>';

	          echo '<td valign="middle" align="center" width="14%">';

	          if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.png'))
	            $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.png';
	          else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.gif'))
	            $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.gif';
	          else
	            $g = 'design/spacer.gif';

              echo '<a href="'.oop_link_to_modul($m2).'" class="menu">';
              echo '<img src="'.$g.'" border="0" width="32" height="32" alt="">';
	          echo '<br>'.my_htmlentities($modulueberschrift).'</a></td>';
	        }
	      }
	    }

	    unset($m1);
		unset($m2);

	    if ($i > -1)
	    {
	      $i++;
	      for (;$i%7<>0;$i++)
	      {
	        echo '<td valign="middle" align="center"><img src="design/spacer.gif" width="32" height="32" alt=""></td>';
	      }
	      echo '</tr></table><br></center>';
	    }
	    else
      echo 'Keine entsprechenden Module gefunden!<br><br>';

	echo $footer;

?>
