<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if (isset($_POST['sent']) && ($_POST['sent'] == '1'))
  {
    echo $header;
if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

    if ($mailaddr == '')
    {
      echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="mailaddr" value="'.$mailaddr.'">
<input type="hidden" name="sent" value="0">

Sie m&uuml;ssen eine E-Mail-Adresse angeben! Bei Accounts ohne E-Mail-Adresse kann diese Technik der Passwortgeneration nicht durchgef&uuml;hrt werden. Wenden Sie sich in diesem Fall an den Administrator.<br><br>

      <input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck"></form>';
    }
    else
    {
      $res = db_query("SELECT `username`, `id` FROM ".$mysql_zugangsdaten['praefix']."users WHERE `email` = '".db_escape($mailaddr)."'");
      if (db_num($res) == 0)
      {
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="mailaddr" value="'.$mailaddr.'">
<input type="hidden" name="sent" value="0">

Zu der angegebenen E-Mail-Adresse existiert kein Benutzer.<br><br>

        <input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck"></form>';
      }
      else
      {
        $res = db_query("SELECT `id`, `username`, `new_password` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `email` = '".db_escape($mailaddr)."'");
        while ($row = db_fetch($res))
        {
          $un = $row['username'];
          $id = $row['id'];

          if ($row['new_password'] != '')
          {
            $pw = $row['new_password'];
          }
          else
          {
            $pw = zufall(10);
            db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `new_password` = '".db_escape($pw)."' WHERE `id` = '".db_escape($id)."'");
          }
          $ac = md5(md5($pw));

          if (array_key_exists("HTTPS", $_SERVER) && $_SERVER("HTTPS") == 'on')
            $protokoll = 'https';
          else
            $protokoll = 'http';

          // In der E-Mail keine HTML-Sonderzeichenkonvertierung
          $mail = "Jemand hat Personal WebBase auf dem Server \"".$_SERVER['HTTP_HOST']."\" angewiesen, ein neues Passwort für die Konten, die auf die E-Mail-Adresse $mailaddr registriert sind, zu generieren. Wenn Sie mehrere Konten besitzen, aber nur das Passwort eines Kontos vergessen haben, bearbeiten Sie nur die relevanten Aktivierungs-E-Mails. Diese E-Mail behandelt das Konto $un.\n\nHier sind Ihre neuen Zugangsdaten:\n\nBenutzername: $un\nPasswort: $pw\n\nBitte beachten Sie, dass diese Änderungen erst gültig werden, wenn Sie folgenden Aktivierungslink anklicken:\n$protokoll://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?modul=$modul&seite=activate&id=$id&code=$ac\n\nWenn Sie kein neues Passwort angefordert haben, dann ignorieren Sie diese E-Mail einfach.";

          $betreff = 'Personal WebBase Passwortgenerierung';

          $header = '';
		  if (($konfiguration['main_ueber']['admin_mail'] != '') && (check_email($konfiguration['main_ueber']['admin_mail'])))
		  {
		    $header .= 'From: ' . $konfiguration['main_ueber']['admin_mail'] . "\r\n";
		    $header .= 'Reply-To: ' . $konfiguration['main_ueber']['admin_mail'] . "\r\n";
		  }
		  $header .= 'X-Mailer: PHP/' . phpversion();

          if (@mail($mailaddr, $betreff, $mail, $header))
          {
            echo 'Ihnen wurde ein neues Passwort per E-Mail zugeschickt.<br><br>Pr&uuml;fen Sie nun Ihr E-Mail-Postfach und aktivieren Sie das neue Passwort mit dem Aktivierungslink, der ebenfalls in der E-Mail enthalten ist.';
          }
          else
          {
            if (function_exists('fehler_melden'))
            {
              fehler_melden($modul, '<b>Mail-Senden fehlgeschlagen!</b><br><br>Das Senden einer E-Mail mit dem Betreff &quot;'.$betreff.'&quot; an &quot;'.$mailaddr.'&quot; ist fehlgeschlagen!');
            }

            echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="mailaddr" value="'.$mailaddr.'">
<input type="hidden" name="sent" value="0">

<font color="#FF0000">Es trat ein Fehler beim E-Mail-Versand auf. Informieren Sie den Administrator &uuml;ber dieses Problem.</font><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck"></form>';
          }
        }
      }
    }
  }
  else
  {

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'mailaddr\').focus();"', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
  echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

echo 'Geben Sie hier Ihre E-Mail-Adresse ein, die Sie bei der Registrierung bei Personal WebBase angegeben haben.
Wenn Sie keine E-Mail-Adresse angegeben haben, k&ouml;nnen Sie kein neues Passwort &uuml;ber dieses
Formular generieren. Kontaktieren Sie in diesem Fall den Administrator.<br><br>

<form method="POST" action="'.$_SERVER['PHP_SELF'].'" name="frm">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="sent" value="1">

E-Mail-Adresse: <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="mailaddr" id="mailaddr" value=""><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Weiter">

</form>';

  }

  echo $footer;
?>
