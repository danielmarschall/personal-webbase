<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

  echo '<h1>Systemcheck</h1>';

  echo '<table cellspacing="0" cellpadding="0" border="0" width="100%">';

  foreach ($module as $m1 => $m2)
  {
    if (file_exists('modules/'.wb_dir_escape($m2).'/crossover/admin_systemcheck/main.inc.php'))
    {
      echo '<tr>';

      echo '<td align="center" valign="top">';

      if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.png'))
        echo '<img src="modules/'.wb_dir_escape($m2).'/images/menu/32.png" alt="" width="32" height="32">';
      else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.gif'))
        echo '<img src="modules/'.wb_dir_escape($m2).'/images/menu/32.gif" alt="" width="32" height="32">';
      else
        echo '<img src="design/spacer.gif" alt="" width="32" height="32">';

      echo '</td><td><img src="design/spacer.gif" alt="" width="10" height="1"></td><td width="100%" valign="top" align="left">';

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

      $meldung = '';
      include 'modules/'.wb_dir_escape($m2).'/crossover/admin_systemcheck/main.inc.php';
      if ($meldung == '')
        echo '<b>'.$m2.'</b> gab keine R&uuml;ckmeldung.';
      else
        echo '<b>'.$m2.'</b> hat folgende Nachricht zur&uuml;ckgegeben:<br><br><code>'.$meldung.'</code>';

      echo '</td></tr><tr><td colspan="3">&nbsp;</td></tr>';
    }
  }

  unset($m1);
  unset($m2);

  echo '<tr><td colspan="3">Der Systemcheck ist beendet.</td></tr></table>';

  echo $footer;

?>
