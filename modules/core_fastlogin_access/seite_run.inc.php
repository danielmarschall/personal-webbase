<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (!isset($secretkey)) $secretkey = '';

if (!$konfiguration[$modul]['enabled'])
{
  echo $header;
  echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
  echo 'Der Administrator hat die Schnellanmeldung deaktiviert.';
  echo $footer;
}
else
{
  $erfolg = 0;

  $res = db_query("SELECT `username`, `passwort`, `fastlogin_secret`, `last_login`, `last_login_ip` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `gesperrt` = '0' AND `fastlogin_secret` != ''");
  while ($row = db_fetch($res))
  {
    // Gastzugang verbieten. Es wird nicht geprüft, ob Gastaccount aktiviert ist oder nicht. (siehe user_login)
    if (($row['username'] != $konfiguration['main_gastzugang']['gast_username']) && ($row['passwort'] != md5($konfiguration['main_gastzugang']['gast_passwort'])))
    {
      $dec = ib_decrypt($secretkey, $row['fastlogin_secret']);
      $ary = explode("\n", $dec);

      if ((count($ary) == 4))
      {
        if ((    $ary[0]  == $row['username']) && ($ary[1] == special_hash($ary[0])) &&
            (md5($ary[2]) == $row['passwort']) && ($ary[3] == special_hash($ary[2]))    )
        {
          $erfolg = 1;
          break;
        }
      }
    }
  }

  if ($erfolg)
  {
    // @session_unset();
    // @session_destroy();

    $_SESSION['ib_user_type'] = '1';
    $_SESSION['ib_user_username'] = $ary[0];
    $_SESSION['ib_user_passwort'] = $ary[2];

    $rs = db_query("SELECT NOW()");
    $rw = db_fetch($rs);

    $_SESSION['last_login'] = $row['last_login'];
    $_SESSION['last_login_ip'] = $row['last_login_ip'];
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `last_login` = '".$rw[0]."', `last_login_ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `username` = '".db_escape($ary[0])."'");

    header('location: index.php');
  }
  else
  {
    echo $header;
    echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
    echo 'Authentifizierung war nicht erfolgreich! M&ouml;glichweise ist die Schnellanmelde-URL abgelaufen.';
    echo $footer;
  }
}

?>
