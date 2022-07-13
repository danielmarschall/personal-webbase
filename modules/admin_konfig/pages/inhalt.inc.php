<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

    echo 'Folgende Module enthalten eine designte Konfigurationsm&ouml;glichkeit:<br><br>';

    $i = -1;
    foreach ($module as $m1 => $m2)
    {
      if (file_exists('modules/'.wb_dir_escape($m2).'/pages/konfig.inc.php'))
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

        $i++;

        if ($i == 0)
          echo '<center><table cellspacing="6" cellpadding="6" border="0"><tr>';

        if (($i % 5 == 0) && ($i != 0))
          echo '</tr><tr>';

        echo '<td valign="middle" align="center">';
        echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul='.urlencode($m2).'&amp;vonmodul='.urlencode($modul).'&amp;vonseite='.urlencode($seite).'" class="menu">';
        if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.png'))
          echo '<img src="modules/'.wb_dir_escape($m2).'/images/menu/32.png" border="0" width="32" height="32" alt="">';
        else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.gif'))
          echo '<img src="modules/'.wb_dir_escape($m2).'/images/menu/32.gif" border="0" width="32" height="32" alt="">';
        else
          echo '<img src="design/spacer.gif" border="0" width="32" height="32" alt="">';
        echo '<br>'.my_htmlentities($titel).'</a></td>';
      }
    }

    unset($m1);
	unset($m2);

    if ($i > -1)
    {
      $i++;
      for (;$i%5<>0;$i++)
      {
        echo '<td valign="middle" align="center"><img src="design/spacer.gif" width="32" height="32" alt=""></td>';
      }
      echo '</tr></table><br></center>';
    }
    else
    {
      echo 'Keine entsprechenden Module gefunden!<br><br>';
	}

      echo $footer;

?>
