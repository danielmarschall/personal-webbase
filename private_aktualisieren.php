<?php

die('Funktion zur Laufzeit gesperrt!');

require 'includes/main.inc.php';

/* --------------------------- */

$ary = array();
$i = 0;
$v = 'modules/';
$verz = opendir($v);

while ($file = readdir($verz))
{
  if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
  {
    $i++;
    $ary[$i] = $file;
  }
}

closedir($verz);
sort($ary);

foreach ($ary as $m1 => $m2)
{
  if (file_exists('modules/'.wb_dir_escape($m2).'/var.inc.php'))
  {
    ob_start();
    readfile('modules/'.wb_dir_escape($m2).'/var.inc.php');
    $buffer = ob_get_contents();
    ob_end_clean();

    $ary = explode("\n", $buffer);

    foreach ($ary as $a1 => $a2)
    {
      $bry = explode(' = ', $a2);

      if ($bry[0] == '$version')
      {
        $buffer = str_replace('$version = '.$bry[1], '$version = \''.date('Y-m-d').'\';', $buffer);
      }
    }

    $handle = fopen('modules/'.wb_dir_escape($m2).'/var.inc.php', 'w');
    fwrite($handle, $buffer);
    fclose($handle);
  }
}
unset($m1);
unset($m2);

/* --------------------------- */

$ary = array();
$i = 0;
$v = 'design/';
$verz = opendir($v);

while ($file = readdir($verz))
{
  if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
  {
    $i++;
    $ary[$i] = $file;
  }
}

closedir($verz);
sort($ary);

foreach ($ary as $m1 => $m2)
{
  if (file_exists('design/'.wb_dir_escape($m2).'/var.inc.php'))
  {
    ob_start();
    readfile('design/'.wb_dir_escape($m2).'/var.inc.php');
    $buffer = ob_get_contents();
    ob_end_clean();

    $ary = explode("\n", $buffer);

    foreach ($ary as $a1 => $a2)
    {
      $bry = explode(' = ', $a2);

      if ($bry[0] == '$version')
      {
        $buffer = str_replace('$version = '.$bry[1], '$version = \''.date('Y-m-d').'\';', $buffer);
      }
    }

    $handle = fopen('design/'.wb_dir_escape($m2).'/var.inc.php', 'w');
    fwrite($handle, $buffer);
    fclose($handle);
  }
}
unset($m1);
unset($m2);

/* --------------------------- */

if (file_exists('includes/rev.inc.php'))
{
  ob_start();
  readfile('includes/rev.inc.php');
  $buffer = ob_get_contents();
  ob_end_clean();

  $ary = explode("\n", $buffer);

  foreach ($ary as $a1 => $a2)
  {
    $bry = explode(' = ', $a2);

    if ($bry[0] == '$rev_datum')
    {
      $buffer = str_replace('$rev_datum = '.$bry[1], '$rev_datum = \''.date('d.m.Y').'\';', $buffer);
    }
  }

  unset($a1);
  unset($a2);

  $handle = fopen('includes/rev.inc.php', 'w');
  fwrite($handle, $buffer);
  fclose($handle);
}

die('Die Datumsangaben aller Module/Designs und die Revisionsinformation wurden aktualisiert.');

?>
