<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

  if (!isset($suchbegriff)) $suchbegriff = '';

  echo 'Hier k&ouml;nnen Sie Ihre IronBASE-Datenbank durchsuchen.
  Bitte beachten Sie, dass nur Datenbankeintr&auml;ge von Modulen gefunden werden
  k&ouml;nnen, die von den Entwicklern mit einer Suchschnittstelle ausgestattet wurden.
  Es werden in der Regel nur die Datens&auml;tze durchsucht, keine Systeme von Drittanbietern
  (z.B. Posteinfach oder Inhalte von Datenbanken/FTP-Servern etc).<br><br>

<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="modul" value="'.$modul.'">
Suchbegriff:<br><input type="text" name="suchbegriff" value="'.$suchbegriff.'" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" size="50">
<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Suchen">
</form>';

  if ($suchbegriff != '')
  {
    echo '<b>Suchergebnisse f&uuml;r &quot;'.$suchbegriff.'&quot;:</b><br><br>';
    gfx_begintable();
    $etwas_gefunden = false;
    gfx_tablecontent('30', '', '', '<b>Modul</b>', '', '<b>ID</b>', '', '<b>Titel</b>', '', '', '', '');
    $res = db_query("SELECT `modul`, `table` FROM `".$mysql_zugangsdaten['praefix']."module` WHERE `is_searchable` = '1'");
    while ($row = db_fetch($res))
    {
      $modulueberschrift = $row['modul'];
      $modulsekpos = '';
      $modulpos = '';
      $modulrechte = '';
      $autor = '';
      $version = '';
      $menuevisible = '';
      $license = '';
      $deaktiviere_zugangspruefung = 0;

      if (file_exists('modules/'.$row['modul'].'/var.inc.php'))
        include 'modules/'.$row['modul'].'/var.inc.php';

      $modulueberschrift_a = $modulueberschrift;

      if (($ib_user_type >= $modulrechte) && ((file_exists('modules/'.$row['modul'].'/seite_edit.inc.php')) || (file_exists('modules/'.$row['modul'].'/seite_view.inc.php'))))
      {
        $que = generate_search_query($row['table'], 0, $suchbegriff);
        $res2 = db_query($que);

        while ($row2 = db_fetch($res2))
        {
          if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$row['table']]['name']))
          {
            $res3 = db_query("SELECT `name` FROM `".$mysql_zugangsdaten['praefix'].db_escape($row['table'])."` WHERE `id` = '".$row2['id']."'");
            $row3 = db_fetch($res3);
            if ($row3['name'] != '')
              $titel = $row3['name'];
            else
              $titel = '<i>Keine Angabe</i>';
          }
          else
            $titel = '<i>Keine Modulbetitelung</i>';

          $etwas_gefunden = true;

          if (file_exists('modules/'.$row['modul'].'/gross.gif'))
            $g = 'modules/'.$row['modul'].'/gross.gif';
          else if (file_exists('modules/'.$row['modul'].'/gross.png'))
            $g = 'modules/'.$row['modul'].'/gross.png';
          else
            $g = 'design/spacer.gif';

          if (file_exists('modules/'.$row['modul'].'/klein.gif'))
		    $k = 'modules/'.$row['modul'].'/klein.gif';
		  else if (file_exists('modules/'.$row['modul'].'/klein.png'))
		    $k = 'modules/'.$row['modul'].'/klein.png';
		  else
		  {
		    if (file_exists('modules/'.$modul.'/item.gif'))
              $k = 'modules/'.$modul.'/item.gif';
		    else if (file_exists('modules/'.$modul.'/item.png'))
              $k = 'modules/'.$modul.'/item.png';
		    else
              $k = 'design/spacer.gif';
          }

          $a = '';
          $b = '';

          if ($row['modul'] == 'user_ordner')
          {
            $res4 = db_query("SELECT `kategorie` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".$row2['id']."'");
            $row4 = db_fetch($res4);

            $modulueberschrift = $row4['kategorie'];
			$modulsekpos = '';
			$modulpos = '';
			$modulrechte = '';
			$autor = '';
			$version = '';
			$menuevisible = '';
			$license = '';
			$deaktiviere_zugangspruefung = 0;

	        if (file_exists('modules/'.$row4['kategorie'].'/var.inc.php'))
              include 'modules/'.$row4['kategorie'].'/var.inc.php';

            $modulueberschrift_b = $modulueberschrift;

            if (file_exists('modules/'.$row4['kategorie'].'/seite_inhalt.inc.php'))
              $a = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$row4['kategorie'].'#ordner'.$row2['id'].'\', \''.$modulueberschrift_a.'\', \''.$g.'\');" class="menu">&Ouml;ffnen</a>';

            if (file_exists('modules/'.$row4['kategorie'].'/seite_inhalt.inc.php'))
              $c = '<a href="'.oop_link_to_modul($row4['kategorie']).'" class="menu">'.$modulueberschrift_b.'</a> ('.$modulueberschrift_a.')';
            else
              $c = $modulueberschrift_b.' ('.$modulueberschrift_a.')';
          }
          else
          {
            if (file_exists('modules/'.$row['modul'].'/seite_view.inc.php'))
              $a = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=view&amp;modul='.$row['modul'].'&amp;id='.$row2['id'].'\', \''.$modulueberschrift_a.'\', \''.$g.'\');" class="menu">&Ouml;ffnen</a>';

            if (file_exists('modules/'.$row['modul'].'/seite_edit.inc.php'))
              $b = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$row['modul'].'&amp;aktion=edit&amp;id='.$row2['id'].'\', \''.$modulueberschrift_a.'\', \''.$g.'\');" class="menu">Bearbeiten</a>';

            if (file_exists('modules/'.$row['modul'].'/seite_inhalt.inc.php'))
              $c = '<a href="'.oop_link_to_modul($row['modul']).'" class="menu">'.$modulueberschrift_a.'</a>';
            else
              $c = $modulueberschrift_a;
          }

          gfx_tablecontent('', '<img src="'.$k.'" alt="" width="16" height="16">', '', $c, '', $row2['id'], '', $titel, '100', $a, '100', $b);
        }
      }
    }
    if (!$etwas_gefunden)
      gfx_tablecontent('', 'Kein Datensatz gefunden!', '', '', '', '', '', '', '', '', '', '');
    gfx_endtable();
  }

  echo $footer;

?>