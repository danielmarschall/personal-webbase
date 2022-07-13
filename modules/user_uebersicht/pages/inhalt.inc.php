<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

	$count_ds = 0;
	$count_o = 0;

	foreach ($tabellen as $m1 => $m2)
	{
      if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$m2]['user']))
      {
	    $res = db_query("SELECT COUNT(`id`) AS `cid` FROM `".$mysql_zugangsdaten['praefix']."$m2` WHERE `user` = '".$benutzer['id']."'");
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

    echo '<span style="font-size:1.2em"><b>Kundendaten</b></span><br><br>';
    wb_draw_table_begin();
	wb_draw_table_content('40%', '<b>Kontoname</b>', '60%', $ib_user_username);
	wb_draw_table_content('40%', '<b>Anmeldeserver</b>', '60%', $mysql_zugangsdaten['server']);
	wb_draw_table_content('40%', '<b>Eigent&uuml;mer</b>', '60%', $benutzer['personenname']);

	if ($benutzer['email'] != '')
	  $addr = '<a href="mailto:'.$benutzer['email'].'" class="menu">'.$benutzer['email'].'</a>';
	else
	  $addr = 'Keine angegeben';

	wb_draw_table_content('40%', '<b>E-Mail-Adresse</b>', '60%', $addr);
    wb_draw_table_end();
    echo '<span style="font-size:1.2em"><b>Datenbankereignisse</b></span><br><br>';
    wb_draw_table_begin();

    foreach ($module as $m1 => $m2)
    {
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
        include 'modules/'.wb_dir_escape($m2).'/var.inc.php';

      if (file_exists('modules/'.wb_dir_escape($m2).'/crossover/'.wb_dir_escape($modul).'/main.inc.php'))
        include 'modules/'.wb_dir_escape($m2).'/crossover/'.wb_dir_escape($modul).'/main.inc.php';
    }

    unset($m1);
	unset($m2);

    wb_draw_table_end();
    echo '<span style="font-size:1.2em"><b>Datenbankstatistik</b></span><br><br>';
    wb_draw_table_begin();
	wb_draw_table_content('40%', '<b>Erstellung der Datenbank</b>', '60%', de_convertmysqldatetime($benutzer['created_database']));

	wb_draw_table_content('40%', '<b>Letzter Login</b>', '60%', de_convertmysqldatetime($_SESSION['last_login']));

    if ($_SESSION['last_login_ip'] == '')
      $ueip = 'Unbekannt';
    else
      $ueip = '<a href="http://www.ripe.net/fcgi-bin/whois?form_type=simple&amp;full_query_string=&amp;searchtext='.urlencode($_SESSION['last_login_ip']).'&amp;submit.x=0&amp;submit.y=0" target="_blank" class="menu">'.$_SESSION['last_login_ip'].'</a> (DNS: '.@gethostbyaddr($_SESSION['last_login_ip']).')';

	wb_draw_table_content('40%', '<b>&Uuml;ber IP</b>', '60%', $ueip);
	wb_draw_table_content('40%', '<b>Datens&auml;tze der Datenbank</b>', '60%', $count_ds);
	wb_draw_table_content('40%', '<b>Ordner der Datenbank</b>', '60%', $count_o);
	wb_draw_table_end();

    echo '<span style="font-size:1.2em"><b>Installierte Module</b></span><br><br>';

	    $i = -1;
	    foreach ($module as $m1 => $m2)
	    {
	      if (file_exists('modules/'.wb_dir_escape($m2).'/pages/inhalt.inc.php'))
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

	        if (($modulrechte == 0) && ($menuevisible) && ($modul != $m2))
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
