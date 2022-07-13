<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type < 2) die('Keine Zugriffsberechtigung');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'admin_mail\').focus();"', $header);

    if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="action" value="changekonfig">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">'; ?>

<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>Admin-Mailadresse:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="text" size="30" name="admin_mail" id="admin_mail" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $konfiguration[$modul]['admin_mail']; ?>"></td>
  </tr>
</table><br>

  <input type="button" onclick="document.location.href='<?PHP echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
  &nbsp;&nbsp;&nbsp;
  <input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

  </form>

<?php

      echo $footer;

?>
