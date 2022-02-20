<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res4 = db_query("SELECT `email` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '".db_escape($inp_user)."' AND `gesperrt` = '0'");
$row4 = db_fetch($res4);
$email = $row4['email'];

if (($email != '') && (check_email($email)))
{
  // E-Mail senden

  $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."links` WHERE `id` = '".$row3['id']."'");
  $row = db_fetch($res);
  $lid = $row['user'];

  $res2 = db_query("SELECT `passwort`, `username` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '$lid'");
  $row2 = db_fetch($res2);
  $erw = md5($row2['passwort']);

  $skey = ib_encrypt($row3['id'].'@'.$erw, '@ibs');

  $betreff    = 'Personal WebBase - Linkaktualisierung!';
  $nachricht  = "Sehr geehrter Personal WebBase-Nutzer\n\n";
  $nachricht .= "Das Personal WebBase-System hat soeben festgestellt, dass die Webseite \"".utf8_decode($row3['name'])."\", die Sie beobachten, sich ver�ndert hat.\n\n";
  $nachricht .= "Klicken Sie auf folgenden Link, um die Webseite zu �ffnen und den Inhalt mit dem Personal WebBase-Datenbankeintrag neu zu synchronisieren:\n\n";
  $nachricht .= $konfiguration[$x2]['ib_system_url']."modulseite.php?modul=$x2&seite=view&skey=".urlencode($skey)."\n\n";
  $nachricht .= "Durch das Anklicken des Links wird der Personal WebBase-Datenbankeintrag mit dem neuen Webseiteninhalt synchronisert. Sie erhalten diese E-Mail-Benachrichtigung danach erneut, sobald sich die Webseite ein weiteres Mal �ndert.\n\n";
  $nachricht .= "Der Link ist so lange g�ltig, bis der dazugeh�rige Datenbankeintrag auf dem Personal WebBase-System gel�scht wird oder Sie Ihr Passwort �ndern bzw. Ihr Benutzerkonto l�schen.\n\n";
  $nachricht .= "Wenn Sie keine automatische Synchronisierung w�nschen, k�nnen Sie die Webseite auch direkt aufrufen. Bitte beachten Sie, dass Sie diese E-Mail dann erst wieder erhalten, nachdem Sie die Webseite �ber Personal WebBase aufgerufen und somit synchronisiert haben.\n\n";
  $nachricht .= "Direkte URL: ".$row3['url']."\n";

  if ($row3['url'] != $update_checkurl)
  {
    $nachricht .= "Pr�fungs-URL: ".$update_checkurl."\n";
  }

  $nachricht .= "\nWenn Sie diese E-Mail-Benachrichtung zu h�ufig erhalten, enth�lt die Webseite m�glicherweise dynamische Elemente wie z.B. einen Benutzerz�hler enthalten, die sich bei jedem Seitenaufruf ver�ndern. F�hren Sie in diesem Fall ein Parsing-Check durch und flankieren Sie die f�r Sie relevanten Seiteninhalte oder deaktivieren Sie den Update-Service f�r diese Webseite.\n\n";
  $nachricht .= "Diese Nachricht wurde automatisch generiert und ist an den Benutzer \"".utf8_decode($row2['username'])."\" auf dem Server ".$konfiguration[$x2]['ib_system_url']." adressiert.";

  $header = '';
  if (($konfiguration['main_ueber']['admin_mail'] != '') && (check_email($konfiguration['main_ueber']['admin_mail'])))
  {
    $header .= 'From: ' . $konfiguration['main_ueber']['admin_mail'] . "\n";
    $header .= 'Reply-To: ' . $konfiguration['main_ueber']['admin_mail'] . "\n";
  }
  $header .= 'X-Mailer: PHP/' . phpversion();

  if ((!@mail($email, $betreff, $nachricht, $header)) && (function_exists('fehler_melden')))
  {
    fehler_melden($m2, '<b>Mail-Senden fehlgeschlagen!</b><br><br>Das Senden einer E-Mail mit dem Betreff &quot;'.$betreff.'&quot; an &quot;'.$email.'&quot; ist fehlgeschlagen!');
  }
}

?>
