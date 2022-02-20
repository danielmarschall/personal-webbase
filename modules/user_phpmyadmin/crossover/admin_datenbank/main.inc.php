<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

echo '<li>';
if (file_exists('modules/'.$m2.'/system/ver.html'))
{
  $handle = @fopen('modules/'.$m2.'/system/ver.html', 'r');
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
  echo '<font color="#FF0000">Unbekanntes System von '.$m2.' aufrufen';
}

echo ' <a href="javascript:open_url(\''.$_SERVER['PHP_SELF'].'?modul='.$m2.'&amp;seite=view\');">&ouml;ffnen</a></li>';

?>