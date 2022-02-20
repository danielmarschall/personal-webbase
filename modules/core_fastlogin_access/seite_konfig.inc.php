<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

echo $header;

  if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie die Schnellanmeldung konfigurieren.<br><br>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="changekonfig">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

if ($konfiguration[$modul]['enabled'])
  $zus = ' checked';
else
  $zus = '';

 ?>

<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>Schnellanmeldung aktivieren:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="checkbox" name="sa_enabled" value="1"<?php echo $zus; ?>></td>
  </tr>
</table><br>

  <input type="button" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
  &nbsp;&nbsp;&nbsp;
  <input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

  </form>

  <script language="JavaScript" type="text/javascript">
  <!--
    document.mainform.sa_enabled.focus();
  // -->
</script><?php

echo $footer;

?>