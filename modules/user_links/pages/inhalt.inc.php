<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if (function_exists('show_modul_search'))
    echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);
  else
    echo $header;

  if ($modulueberschrift == '') $modulueberschrift = $modul;

  if ((!isset($onlyupdates)) || (!$onlyupdates))
  {
    echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

    if (function_exists('show_modul_search')) show_modul_search($modul, $seite);

    wb_draw_table_begin();

    // wb_draw_table_content('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
    gfx_zeichneordner($modul, $mysql_zugangsdaten['praefix'].'links', 'ORDER BY `name`');
    wb_draw_table_end();
    echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=new">Einen neuen Link hinzuf&uuml;gen</a>';
    echo '<br><a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_ordner&amp;aktion=new&amp;kategorie='.urlencode($modul).'">Einen neuen Ordner hinzuf&uuml;gen</a>';
  }
  else
  {
    echo '<h1>'.my_htmlentities($modulueberschrift).' (nur Updates)</h1>';
    wb_draw_table_begin();

    // wb_draw_table_content('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
    gfx_zeichneitems_filter($modul, $mysql_zugangsdaten['praefix'].'links', "WHERE `update_enabled` = '1' AND `user` = '".$benutzer['id']."' ORDER BY `name`");
    wb_draw_table_end();
  }

  echo $footer;

?>
