<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'passwort\').focus();"', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
    echo 'Bitte geben Sie das Passwort von Ihrem IronBASE-Serversystem ein, um die
Kunden und die Konfiguration des Servers zu bearbeiten.<br><br>

<form action="index.php" target="_parent" method="POST" name="frm">
<input type="hidden" name="login_process" value="1">
<input type="hidden" name="ib_user_type" value="2">

<table cellspacing="0" cellpadding="2" border="0">';
echo '<tr>
  <td>Passwort:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="ib_user_passwort" id="passwort" value=""></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" name="login" value="Einloggen">

</form>';

  echo $footer;

?>