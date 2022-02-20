<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ob_start();
phpinfo();
$inhalt = ob_get_contents();
ob_end_clean();

$inhalt = str_replace('<!DOCTYPE', '<!-- <!DOCTYPE', $inhalt);
$inhalt = str_replace('<body>', '<body> -->', $inhalt);
$inhalt = str_replace('</body></html>', '<!-- </body></html> -->', $inhalt);

$php_style = zwischen_str($inhalt, '<style', '</style>');

echo str_replace('</head>', $php_style.'</head>', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

$inhalt = str_replace('<a href="http://www.php.net/">', '<a href="http://www.php.net/" target="_blank">', $inhalt);
$inhalt = str_replace('<a href="http://www.zend.com/">', '<a href="http://www.zend.com/" target="_blank">', $inhalt);
$inhalt = str_replace('ä', '&auml;', $inhalt);
$inhalt = str_replace('ö', '&ouml;', $inhalt);
$inhalt = str_replace('ü', '&uuml;', $inhalt);
$inhalt = str_replace('Ä', '&Auml;', $inhalt);
$inhalt = str_replace('Ö', '&Ouml;', $inhalt);
$inhalt = str_replace('Ü', '&Uuml;', $inhalt);
$inhalt = str_replace('ß', '&szlig;', $inhalt);

if (strpos($inhalt, '">PHP Credits</a></h1>') !== false)
{
  $zw_links = zwischen_str($inhalt, '<h1><a href="', '">PHP Credits</a></h1>', false);

  $protokoll = $force_ssl ? 'https' : 'http';
  $credits_links = $protokoll.'://'.$_SERVER["HTTP_HOST"].$zw_links;

  $credit_inhalt = my_get_contents($credits_links);

  $credit_inhalt = str_replace('<!DOCTYPE', '<!-- <!DOCTYPE', $credit_inhalt);
  $credit_inhalt = str_replace('<body>', '<body> -->', $credit_inhalt);
  $credit_inhalt = str_replace('</body></html>', '<!-- </body></html> -->', $credit_inhalt);

  $credit_inhalt = str_replace('ä', '&auml;', $credit_inhalt);
  $credit_inhalt = str_replace('ö', '&ouml;', $credit_inhalt);
  $credit_inhalt = str_replace('ü', '&uuml;', $credit_inhalt);
  $credit_inhalt = str_replace('Ä', '&Auml;', $credit_inhalt);
  $credit_inhalt = str_replace('Ö', '&Ouml;', $credit_inhalt);
  $credit_inhalt = str_replace('Ü', '&Uuml;', $credit_inhalt);
  $credit_inhalt = str_replace('ß', '&szlig;', $credit_inhalt);

  echo str_replace('<h1><a href="'.$zw_links.'">PHP Credits</a></h1>', $credit_inhalt, $inhalt);
}
else
{
  echo $inhalt;
}

echo $footer;

?>