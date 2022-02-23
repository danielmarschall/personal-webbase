<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

echo '<b>Information</b><br><br>

Um schneller auf Ihre Personal WebBase-Datenbank zugreifen zu k&ouml;nnen,
haben Sie hier die M&ouml;glichkeit, eine Schnellanmeldungs-URL anzulegen.
Es handelt sich hierbei um eine lange URL, die in verschl&uuml;sselter Form
Ihre Zugangsdaten enth&auml;lt und Ihnen das Einloggen erleichert. Sie k&ouml;nnen
diese URL dann in Ihre Favoritenleiste oder in eine Desktop- bzw. Startmen&uuml;-Verkn&uuml;pfung
einspeichern.<br><br>

Bitte beachten Sie, dass Sie diese URL niemals auf einem fremden PC aufrufen d&uuml;rfen,
da diese sich nach dem Anklicken in den Browserverlauf des Computers einspeichert und einer
Dritten Person m&ouml;glicherweise den Zugriff auf Ihre Daten erm&ouml;glicht.<br><br>

Sollte die URL versehentlich an Dritte Personen gelangt sein, m&uuml;ssen Sie dringenst Ihr
Personal WebBase-Passwort &auml;ndern bzw. eine neue Schnellanmelde-URL einrichten. Dadurch
verliert Ihre alte Schnellanmelde-URL ihre G&uuml;ltigkeit.<br><br>

Aktivieren Sie diese Funktionalit&auml;t daher nur, wenn Sie die Schnellanmelde-URL tats&auml;chlich nutzen.<br><br>

<b>Aktueller Status</b><br><br>';

if ($ib_user_type == 0)
{
  echo '<font color="#FF0000">Diese Funktion ist im Gastzugang nicht verf&uuml;gbar.</font>';
}
else
{
  if (!$konfiguration['core_fastlogin_access']['enabled'])
  {
    echo '<font color="#FF0000">Der Administrator hat die Schnellanmeldung deaktiviert.</font>';
  }
  else
  {
    echo '<table cellspacing="0" cellpadding="0" border="0">
<tr>
  <td valign="top">Status:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">';

    if ((isset($benutzer['fastlogin_secret'])) && ($benutzer['fastlogin_secret'] != ''))
    {
      $secret_key  = $ib_user_username."\n";
      $secret_key .= special_hash($ib_user_username)."\n";
      $secret_key .= $ib_user_passwort."\n";
      $secret_key .= special_hash($ib_user_passwort);
      $secret_key  = ib_encrypt($secret_key, $benutzer['fastlogin_secret']);

      echo 'Aktiviert (<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=kraftsetzung&aktion=deactivate">deaktivieren</a>)<br><br>';

      $ibs = '';
      if ($force_ssl)
        $ibs = 'https://';
      else
        $ibs = 'http://';
      $ibs .= $_SERVER['HTTP_HOST'];
      $ibs .= $_SERVER['PHP_SELF'];

      echo '</td></tr><tr>
  <td valign="top">Anmelde-URL:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">';

      $inh = $ibs.'?modul=core_fastlogin_access&seite=run&secretkey='.urlencode($secret_key);

      echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" size="85" value="'.$inh.'" readonly><br>';
      echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=kraftsetzung&aktion=activate">Neue Schnellanmelde-URL einrichten</a><br>';
      echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=export">Als Internet-Verkn&uuml;pfung herunterladen</a><br><br>';

      echo '</td></tr><tr>
  <td valign="top">Hinweis:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">Kopieren Sie diese URL in die Zwischenablage mittels <b>Strg+A</b>, gefolgt von <b>Strg+C</b>. Zum Einf&uuml;gen verwenden Sie <b>Strg+V</b>.';
    }
    else
    {
      echo 'Deaktiviert (<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=kraftsetzung&aktion=activate">aktivieren</a>)';
    }

    echo '</td>
</tr>
</table>';
  }
}

echo $footer;

?>
