<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if (function_exists('show_modul_search'))
    echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);
  else
    echo $header;

  if ($modulueberschrift == '') $modulueberschrift = $modul;
  echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

  if (decoct(@fileperms('modules/'.$modul.'/system/tmp/')) != 40777)
    echo '<font color="#FF0000"><b>Die Funktionalit&auml;t dieses Modules k&ouml;nnte beeintr&auml;chtigt sein, da der Administrator folgendes Verzeichnis nicht schreibbar (CHMOD 0777) gemacht hat:</b><br>modules/'.$modul.'/system/tmp/</font><br><br>';

  if (function_exists('show_modul_search')) show_modul_search($modul, $seite);

  gfx_begintable();

  // gfx_tablecontent('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
  gfx_zeichneordner($modul, $mysql_zugangsdaten['praefix'].'popper_konten', 'ORDER BY `name`');
  gfx_endtable();
  echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=new">Neues Postfach hinzuf&uuml;gen</a>';
  echo '<br><a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_ordner&amp;aktion=new&amp;kategorie='.$modul.'">Einen neuen Ordner hinzuf&uuml;gen</a>';

  echo '<br><br>Es wird folgende Websoftware verwendet: ';
  if (file_exists('modules/'.$modul.'/system/ver.html'))
  {
    $handle = @fopen('modules/'.$modul.'/system/ver.html', 'r');
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
    echo '<font color="#FF0000">modules/'.$modul.'/system/ver.html wurde nicht gefunden!</font>';
  }
  echo '<br><br>';

  echo $footer;

?>
