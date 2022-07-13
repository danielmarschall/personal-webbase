<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
    echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo 'Hier sind alle Datenbanken der Module aufgelistet.<br><br>';

    gfx_begintable();
    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."module` ORDER BY `id`");
    gfx_tablecontent('', '<b>Tabellenname</b>', '', '<b>Modul</b>', '', '<b>Datens&auml;tze</b>', '', '<b>Aktionen</b>');
    while ($row = db_fetch($res))
    {
      if (isset($only) && ($row['modul'] == $only))
      {
	    $s1 = '<font color="#FF0000">';
	    $s2 = '</font>';
	  }
	  else
	  {
        $s1 = '';
        $s2 = '';
      }
      $ars = db_query("SELECT COUNT(*) AS `ct` FROM `".$mysql_zugangsdaten['praefix'].$row['table']."`");
      $arw = db_fetch($ars);
      if (!is_dir('modules/'.wb_dir_escape($row['modul'])))
      {
        $z = ' (Nicht mehr installiert)';
        $x = 'Tabelle entfernen';
      }
      else
      {
        $z = '';
        $x = 'Tabelle neu anlegen';
      }
      gfx_tablecontent('', $s1.$mysql_zugangsdaten['praefix'].$row['table'].$s2, '', $s1.$row['modul'].$z.$s2, '', $s1.$arw['ct'].$s2, '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.urlencode($modul).'&amp;aktion=delete&amp;id='.urlencode($row['id']).'\');" class="menu">'.$x.'</a>');
    }
    gfx_endtable();

    echo '<b>Schnittstellen</b><ul>';
    $welchegefunden = false;
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

	  // Damit die Modulseiten auch auf ihre eigenen Modulvariablen zugreifen können, var.inc.php einbinden
	  if (file_exists('modules/'.wb_dir_escape($m2).'/var.inc.php'))
	    include('modules/'.wb_dir_escape($m2).'/var.inc.php');

	  // Nun die Modulcrons laden
	  if (file_exists('modules/'.wb_dir_escape($m2).'/crossover/'.wb_dir_escape($modul).'/main.inc.php'))
	  {
	    include('modules/'.wb_dir_escape($m2).'/crossover/'.wb_dir_escape($modul).'/main.inc.php');
	    $welchegefunden = true;
	  }
    }

    unset($m1);
	unset($m2);

    if (!$welchegefunden)
      echo '<li>Keine gefunden!</li>';
    echo '</ul>';

    if ((isset($vonmodul)) && (isset($vonseite)) && ($vonmodul != '') && ($vonseite != ''))
      echo '<input type="button" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($vonmodul).'&amp;seite='.urlencode($vonseite).'\';" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck">';

    echo '<br>';

    echo $footer;

?>
