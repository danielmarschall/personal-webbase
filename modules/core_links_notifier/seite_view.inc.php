<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!isset($skey)) $skey = '';

$skey_decoded = ib_decrypt($skey, '@ibs');

$skey_ary = explode('@', $skey_decoded);
$id = $skey_ary[0];

$res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."links` WHERE `id` = '".db_escape($id)."'");
$row = db_fetch($res);
$lid = $row['user'];

$res2 = db_query("SELECT `passwort` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '$lid'");
$row2 = db_fetch($res2);
$erw = md5($row2['passwort']);

if ($erw == $skey_ary[1])
{
  $modulueberschrift = '';
  $modulsekpos = '';
  $modulpos = '';
  $modulrechte = '';
  $autor = '';
  $version = '';
  $menuevisible = '';
  $license = '';
  $deaktiviere_zugangspruefung = 0;

  $benutzer['id'] = $lid;

  if (file_exists('modules/user_links/var.inc.php'))
    include 'modules/user_links/var.inc.php';

  if (file_exists('modules/user_links/seite_view.inc.php'))
    include 'modules/user_links/seite_view.inc.php';
}
else
{
  echo $header.'Sicherheitsschl&uuml;ssel fehlerhaft.'.$footer;
}

?>
