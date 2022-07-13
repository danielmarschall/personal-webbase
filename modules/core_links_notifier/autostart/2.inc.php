<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ((isset($_SERVER['HTTP_HOST'])) && (isset($_SERVER['PHP_SELF'])))
{
  if ($force_ssl)
  {
    $iburl = 'https://';
  }
  else
  {
    $iburl = 'http://';
  }
  $iburl .= $_SERVER['HTTP_HOST'];
  $iburl .= dirname_with_pathdelimiter($_SERVER['PHP_SELF']);
}
else
{
  $iburl = '';
}

if (isset($konfiguration[$m2]['ib_system_url']))
{
  if ($konfiguration[$m2]['ib_system_url'] != $iburl)
  {
    ib_change_config('ib_system_url', $iburl, $m2);
  }
}
else
{
  ib_add_config('ib_system_url', $iburl, $m2);
}

?>
