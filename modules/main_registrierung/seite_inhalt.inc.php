<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'rusername\').focus();"', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

$res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `creator_ip` = '".$_SERVER['REMOTE_ADDR']."' AND `created_database` >= DATE_SUB(NOW(), INTERVAL ".db_escape($konfiguration[$modul]['sperrdauer'])." MINUTE)");
if (db_num($res))
  die($footer.'<font color="#FF0000">Sie k&ouml;nnen mit dieser IP-Adresse nur jede '.$konfiguration[$modul]['sperrdauer'].' Minuten ein neues Konto er&ouml;ffnen!</font>'.$header);

if ($konfiguration[$modul]['enable_userreg'])
{
  $ok = true;
  if (isset($reg) && ($reg == '1'))
  {
    $ok = false;
    if (($rusername == '') || ($rpersonenname == '') || ($rpasswort == '') || ($rpasswort2 == ''))
    {
      echo '<font color="#FF0000"><b>Fehler:</b> Sie m&uuml;ssen die erforderlichen Fehler ausf&uuml;llen, um sich zu registrieren.</font><br><br>';
      $ok = true;
    }
    else
    {
      if ($rpasswort != $rpasswort2)
      {
         echo '<font color="#FF0000"><b>Fehler:</b> Die zwei Passw&ouml;rter stimmen nicht &uuml;berein.</font><br><br>';
	     $ok = true;
      }
      else
      {
        $res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".db_escape($rusername)."'");
        if (db_num($res) > 0)
        {
          echo '<font color="#FF0000"><b>Fehler:</b> Der Benutzername &quot;'.$rusername.'&quot; ist bereits vergeben.</font><br><br>';
          $ok = true;
        }
        else
        {
          db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."users` (`username`, `personenname`, `passwort`, `email`, `created_database`, `creator_ip`) VALUES ('".db_escape($rusername)."', '".db_escape($rpersonenname)."', '".md5($rpasswort)."', '".db_escape($remail)."', NOW(), '".$_SERVER["REMOTE_ADDR"]."')"); // TODO: use sha3 hash, salted and peppered
          echo '<b>Sie haben Ihr Konto auf diesem Personal WebBase-Server erfolgreich registriert.</b><br><br>Das Konto ist sofort verwendbar. Wir w&uuml;nschen Ihnen viel Freude mit Personal WebBase!';
        }
      }
    }
  }
  if ($ok)
  {

    if (!isset($rusername)) $rusername = '';
    if (!isset($rpersonenname)) $rpersonenname = '';
    if (!isset($rpasswort)) $rpasswort = '';
    if (!isset($rpasswort2)) $rpasswort2 = '';
    if (!isset($remail)) $remail = '';

    echo '<b>Hier k&ouml;nnen Sie sich ein Konto auf diesem Personal WebBase-Server errichten.</b><br><br>

Die Angabe einer E-Mail-Adresse ist optional.<br><br>

<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="frm">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="reg" value="1">

<table cellspacing="0" cellpadding="2" border="0">
<tr>
  <td>Benutzername:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rusername" id="rusername" value="'.$rusername.'"></td>
</tr>
<tr>
  <td>Personenname:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rpersonenname" value="'.$rpersonenname.'"></td>
</tr>
<tr>
  <td>Passwort:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rpasswort" value="'.$rpasswort.'"></td>
</tr>
<tr>
  <td>Wiederholung:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rpasswort2" value="'.$rpasswort2.'"></td>
</tr>
<tr>
  <td>E-Mail-Adresse:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="remail" value="'.$remail.'"></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Registrieren">

</form>';
  }
}
else
{
  echo '<font color="#FF0000">Das Registrieren bei Personal WebBase wurde von dem Administrator nicht aktiviert.</font>';
}

  echo $footer;

?>
