<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'username\').focus();"', $header);

echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>

<form action="index.php" target="_parent" method="POST" name="frm">
<input type="hidden" name="login_process" value="1">
<input type="hidden" name="ib_user_type" value="1">

<b>Bitte loggen Sie sich ein.</b><br><br>

<table cellspacing="0" cellpadding="2" border="0">';
echo '<tr>
  <td>Benutzerkennung:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="ib_user_username" id="username" value=""></td>
</tr>
<tr>
  <td>Passwort:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="ib_user_passwort" value=""></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" name="login" value="Einloggen">

</form>';

  echo $footer;

?>
