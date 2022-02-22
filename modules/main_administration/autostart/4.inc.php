<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Sicherheitsabschnitt

$ary = explode('/', $_SERVER['PHP_SELF']);

if (($konfiguration['main_administration']['admin_pwd'] == '') && ($ary[count($ary)-1] != 'style.css.php'))
{
  $fehler = '';
  if (isset($_REQUEST['setapwd']) && ($_REQUEST['setapwd'] == '1'))
  {
    if ($apw1 == '')
      $fehler .= '<font color="#FF0000">Fehler: Es muss ein Passwort angegeben werden!</font><br><br>';

    if ($apw1 != $apw2)
      $fehler .= '<font color="#FF0000">Fehler: Die beiden Passw&ouml;rter sind verschieden!</font><br><br>';

    if (($validuser != $mysql_zugangsdaten['username']) || ($validpass != $mysql_zugangsdaten['passwort']))
      $fehler .= '<font color="#FF0000">Fehler: Die MySQL-Validierungsdaten sind falsch!</font><br><br>';

    if ($fehler == '')
    {
      ib_change_config('admin_pwd', md5($apw1), 'main_administration');// TODO: use sha3 hash, salted and peppered
      if (!headers_sent()) header('location:'.$_SERVER['PHP_SELF']);
    }
  }
  die($header.'<h1>Aktivierung von Personal WebBase</h1>Personal WebBase nutzt derzeit noch das Administratorpasswort, das bei der Auslieferung gesetzt wurde. Sie <u>m&uuml;ssen</u> ein eigenes Administratorpasswort eingeben!<br><br>
  Bitte loggen Sie sich danach in den Administrationsbereich ein, um ggf. die Konfigurationswerte anzupassen.<br><br><form action="'.$_SERVER['PHP_SELF'].'" method="POST">
  <input type="hidden" name="setapwd" value="1">
  <table cellpadding="0" cellspacing="0" border="0">
  <tr><td width="225">Administratorpasswort festlegen auf:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" name="apw1" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
  <tr><td>Eingabe wiederholen:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" name="apw2" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
  </table><br>Damit Personal WebBase sicherstellen kann, dass Sie derjenige sind, der Personal WebBase auch installiert hat, geben Sie bitte jetzt noch die MySQL-Zugangsdaten ein, das Sie in der Konfigurationsdatei <code>includes/config.inc.php</code> bei <code>$mysql_zugangsdaten[\'username\']</code> und <code>$mysql_zugangsdaten[\'passwort\']</code> eingetragen haben.<br><br>
  <table cellpadding="0" cellspacing="0" border="0">
  <tr><td width="225">MySQL-Benutzername:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="text" name="validuser" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
  <tr><td width="225">MySQL-Passwort:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" name="validpass" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
  <tr><td colspan="2"><br><input type="submit" value="Festlegen" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';"></td></tr>
  </table><br>'.$fehler.'
  </form>'.$footer);
}

?>
