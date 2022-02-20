<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'oldpwd\').focus();"', $header);

  if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie das Passwort f&uuml;r den Administrationsbereich &auml;ndern.<br><br>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="action" value="changepwd">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">'; ?>

<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>Aktuelles Passwort:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="password" name="oldpwd" id="oldpwd" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';"></td>
  </tr>
  <tr>
    <td>Neues Passwort:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="password" name="newpwd" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';"></td>
  </tr>
  <tr>
    <td>Wiederholung:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="password" name="newpwd2" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';"></td>
  </tr>
</table><br>

  <input type="button" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
  &nbsp;&nbsp;&nbsp;
  <input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

  </form>

  <?php

echo $footer;

?>