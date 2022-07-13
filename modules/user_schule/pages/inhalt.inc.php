<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if (function_exists('show_modul_search'))
    echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);
  else
    echo $header;

  if ($modulueberschrift == '') $modulueberschrift = $modul;
  echo '<h1>'.my_htmlentities($modulueberschrift).' - Jahrg&auml;nge</h1>';
  if (function_exists('show_modul_search')) show_modul_search($modul, $seite);
  gfx_begintable();
  // gfx_tablecontent('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
  gfx_zeichneordner($modul, $mysql_zugangsdaten['praefix'].'schule_jahrgaenge', 'ORDER BY `jahr`');
  gfx_endtable();
  echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=new">Neuen Jahrgang hinzuf&uuml;gen</a>';
  echo '<br><a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_ordner&amp;aktion=new&amp;kategorie='.urlencode($modul).'">Einen neuen Ordner hinzuf&uuml;gen</a>';

  echo $footer;

?>
