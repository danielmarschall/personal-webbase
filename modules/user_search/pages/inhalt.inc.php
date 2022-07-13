<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

  if (!isset($suchbegriff)) $suchbegriff = '';

  echo 'Hier k&ouml;nnen Sie Ihre Personal WebBase-Datenbank durchsuchen.
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

      if (file_exists('modules/'.wb_dir_escape($row['modul']).'/var.inc.php'))
        include 'modules/'.wb_dir_escape($row['modul']).'/var.inc.php';

      $modulueberschrift_a = $modulueberschrift;

      if (($wb_user_type >= $modulrechte) && ((file_exists('modules/'.wb_dir_escape($row['modul']).'/pages/edit.inc.php')) || (file_exists('modules/'.wb_dir_escape($row['modul']).'/pages/view.inc.php'))))
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

          if (file_exists('modules/'.wb_dir_escape($row['modul']).'/images/menu/32.png'))
            $g = 'modules/'.wb_dir_escape($row['modul']).'/images/menu/32.png';
          else if (file_exists('modules/'.wb_dir_escape($row['modul']).'/images/menu/32.gif'))
            $g = 'modules/'.wb_dir_escape($row['modul']).'/images/menu/32.gif';
          else
            $g = 'design/spacer.gif';

		  if (file_exists('modules/'.wb_dir_escape($row['modul']).'/images/menu/16.png'))
		    $k = 'modules/'.wb_dir_escape($row['modul']).'/images/menu/16.png';
          else if (file_exists('modules/'.wb_dir_escape($row['modul']).'/images/menu/16.gif'))
		    $k = 'modules/'.wb_dir_escape($row['modul']).'/images/menu/16.gif';
		  else
		  {
		    if (file_exists('modules/'.wb_dir_escape($modul).'/item.gif'))
              $k = 'modules/'.wb_dir_escape($modul).'/item.gif';
		    else if (file_exists('modules/'.wb_dir_escape($modul).'/item.png'))
              $k = 'modules/'.wb_dir_escape($modul).'/item.png';
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

	        if (file_exists('modules/'.wb_dir_escape($row4['kategorie']).'/var.inc.php'))
              include 'modules/'.wb_dir_escape($row4['kategorie']).'/var.inc.php';

            $modulueberschrift_b = $modulueberschrift;

            if (file_exists('modules/'.wb_dir_escape($row4['kategorie']).'/pages/inhalt.inc.php'))
              $a = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($row4['kategorie']).'#ordner'.$row2['id'].'\', \''.$modulueberschrift_a.'\', \''.$g.'\');" class="menu">&Ouml;ffnen</a>';

            if (file_exists('modules/'.wb_dir_escape($row4['kategorie']).'/pages/inhalt.inc.php'))
              $c = '<a href="'.oop_link_to_modul($row4['kategorie']).'" class="menu">'.$modulueberschrift_b.'</a> ('.$modulueberschrift_a.')';
            else
              $c = $modulueberschrift_b.' ('.$modulueberschrift_a.')';
          }
          else
          {
            if (file_exists('modules/'.wb_dir_escape($row['modul']).'/pages/view.inc.php'))
              $a = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=view&amp;modul='.urlencode($row['modul']).'&amp;id='.urlencode($row2['id']).'\', \''.$modulueberschrift_a.'\', \''.$g.'\');" class="menu">&Ouml;ffnen</a>';

            if (file_exists('modules/'.wb_dir_escape($row['modul']).'/pages/edit.inc.php'))
              $b = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($row['modul']).'&amp;aktion=edit&amp;id='.urlencode($row2['id']).'\', \''.$modulueberschrift_a.'\', \''.$g.'\');" class="menu">Bearbeiten</a>';

            if (file_exists('modules/'.wb_dir_escape($row['modul']).'/pages/inhalt.inc.php'))
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
