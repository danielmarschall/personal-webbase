<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type == 0)
{
  die($header.'Diese Funktion ist im Gastzugang nicht verf&uuml;gbar.'.$footer);
}

if (($konfiguration['core_fastlogin_access']['enabled']) && (isset($benutzer['fastlogin_secret'])) && ($benutzer['fastlogin_secret'] != ''))
{
  if (!headers_sent()) header("Pragma: public");
  if (!headers_sent()) header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  if (!headers_sent()) header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  if (!headers_sent()) header("Cache-Control: private",false);
  if (!headers_sent()) header("Content-type: application/octet-stream");
  if (!headers_sent()) header("Content-Disposition: attachment; filename=\"Personal WebBase-Direktzugang.url\"");
  if (!headers_sent()) header("Content-Transfer-Encoding: binary");

  $secret_key  = $ib_user_username."\n";
  $secret_key .= special_hash($ib_user_username)."\n";
  $secret_key .= $ib_user_passwort."\n";
  $secret_key .= special_hash($ib_user_passwort);
  $secret_key  = ib_encrypt($secret_key, $benutzer['fastlogin_secret']);

  if ($force_ssl)
    $ibs_prae = 'https://';
  else
    $ibs_prae = 'http://';

  $ibs  = $ibs_prae;
  $ibs .= $_SERVER['HTTP_HOST'];
  $ibs .= $_SERVER['PHP_SELF'];

  $inh = $ibs.'?modul=core_fastlogin_access&seite=run&secretkey='.urlencode($secret_key)."\r\n";

  echo "[InternetShortcut]\r\nURL=$inh";

  if (file_exists('favicon.ico'))
  {
    $ibs2  = $ibs_prae;
    $ibs2 .= $_SERVER['HTTP_HOST'];
    $ibs2 .= dirname_with_pathdelimiter($_SERVER['PHP_SELF']);

    echo "IconFile=$ibs2favicon.ico\r\nIconIndex=1\r\n";
  }
}
else
{
  die($header.'Die Schnellanmeldung ist deaktiviert.'.$footer);
}

?>
