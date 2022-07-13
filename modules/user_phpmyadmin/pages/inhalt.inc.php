<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if (function_exists('show_modul_search'))
    echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);
  else
    echo $header;

  if ($modulueberschrift == '') $modulueberschrift = $modul;
  echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
  if (function_exists('show_modul_search')) show_modul_search($modul, $seite);
  wb_draw_table_begin();

  // wb_draw_table_content('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
  gfx_zeichneordner($modul, $mysql_zugangsdaten['praefix'].'phpmyadmin', 'ORDER BY id');
  wb_draw_table_end();
  echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=new">Einen neuen Server hinzuf&uuml;gen</a>';
  echo '<br><a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_ordner&amp;aktion=new&amp;kategorie='.urlencode($modul).'">Einen neuen Ordner hinzuf&uuml;gen</a>';

  echo '<br><br>Es wird folgende Websoftware verwendet: ';
  if (file_exists('modules/'.wb_dir_escape($modul).'/system/ver.html'))
  {
    $handle = @fopen('modules/'.wb_dir_escape($modul).'/system/ver.html', 'r');
    $buffer = '';
    while (!@feof($handle))
    {
      $buffer .= @fgets($handle, 4096);
    }
    echo $buffer;
    @fclose($handle);
  }
  else
  {
    echo '<font color="#FF0000">modules/'.wb_dir_escape($modul).'/system/ver.html wurde nicht gefunden!</font>';
  }
  echo '<br><br>';

  echo $footer;

?>
