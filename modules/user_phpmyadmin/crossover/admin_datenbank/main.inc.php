<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo '<li>';
if (file_exists('modules/'.wb_dir_escape($m2).'/system/ver.html'))
{
  $handle = @fopen('modules/'.wb_dir_escape($m2).'/system/ver.html', 'r');
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
  echo '<font color="#FF0000">Unbekanntes System von '.my_htmlentities($m2).' aufrufen';
}

echo ' <a href="javascript:open_url(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($m2).'&amp;seite=view\');">&ouml;ffnen</a></li>';

?>
