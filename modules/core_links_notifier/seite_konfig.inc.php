<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  echo $header;

  if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="action" value="changekonfig">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">'; ?>

<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>IB-System-URL:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><?php echo '<a href="'.$konfiguration[$modul]['ib_system_url'].'" target="_blank">'.$konfiguration[$modul]['ib_system_url'].'</a>' ?> (automatisch ermittelt)</td>
  </tr>
</table><br>

  <input type="button" onclick="document.location.href='<?PHP echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">

  </form>

<?php

      echo $footer;

?>