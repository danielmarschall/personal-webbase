<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  if ($aktion == 'send')
  {
    $nachricht = "Diese Nachricht wird Ihnen von dem Administrator des Servers \"".$_SERVER['HTTP_HOST']."\", beidem Sie sich ein IronBASE-Konto eingerichtet haben, gesendet. Es handelt sich hierbei um ein Rundschreiben, das an alle nicht gesperrten Benutzer des IronBASE-Servers gerichtet ist. Bitte melden Sie Spam dem zustängigen Verwalter.\n\n-----------------------------------------\n\n".utf8_decode(undo_transamp_replace_spitze_klammern($message));

    $res = db_query("SELECT `email` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `email` != '' AND `gesperrt` = '0'");
    $betreff = 'IronBASE Rundschreiben';

    $header = '';
	if (($konfiguration['main_ueber']['admin_mail'] != '') && (check_email($konfiguration['main_ueber']['admin_mail'])))
	{
	  $header .= 'From: ' . $konfiguration['main_ueber']['admin_mail'] . "\r\n";
	  $header .= 'Reply-To: ' . $konfiguration['main_ueber']['admin_mail'] . "\r\n";
	  $header .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
    }
    $header .= 'X-Mailer: PHP/' . phpversion();

    while ($row = db_fetch($res))
    {
      if (isset($row['email']) && ($row['email'] != '') && (check_email($row['email'])))
      {
        if ((!@mail($row['email'], $betreff, $nachricht, $header) && (function_exists('fehler_melden'))))
        {
          fehler_melden($modul, '<b>Mail-Senden fehlgeschlagen!</b><br><br>Das Senden einer E-Mail mit dem Betreff &quot;'.$betreff.'&quot; an &quot;'.$row['email'].'&quot; ist fehlgeschlagen!');
        }
      }
    }
    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
  }

?>