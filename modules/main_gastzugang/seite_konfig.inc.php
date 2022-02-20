<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

echo $header;

  if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie den Gastzugang konfigurieren.<br><br>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="changekonfig">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

if ($konfiguration[$modul]['enable_gast'])
  $zus = ' checked';
else
  $zus = '';

if ($konfiguration[$modul]['wipe_gastkonto'])
  $zus2 = ' checked';
else
  $zus2 = '';

 ?>

<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>Gastzugang aktivieren:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="checkbox" name="gastaktivierung" value="1"<?php echo $zus; ?>></td>
  </tr>
  <tr>
    <td>Gast-Benutzername:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="text" name="gastuser" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $konfiguration[$modul]['gast_username']; ?>"></td>
  </tr>
  <tr>
    <td>Gast-Passwort:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="text" name="gastpassword" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $konfiguration[$modul]['gast_passwort']; ?>"></td>
  </tr>
  <tr>
    <td>T&auml;gliche Datenleerung:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="checkbox" name="wipe_gastkonto" value="1"<?php echo $zus2; ?>></td>
  </tr>
  <tr>
  <?php
    $ary = explode(':', $konfiguration[$modul]['wipe_uhrzeit']);
  ?>
    <td>Uhrzeit der Datenleerung:</td>
    <td><img src="design/spacer.gif" width="15" height="1" alt=""></td>
    <td><input type="text" name="wipe_uhrzeit1" size="3" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $ary[0]; ?>">
    : <input type="text" name="wipe_uhrzeit2" size="3" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $ary[1]; ?>">
    : <input type="text" name="wipe_uhrzeit3" size="3" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $ary[2]; ?>"> Uhr</td>
  </tr>
</table><br>

  <input type="button" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
  &nbsp;&nbsp;&nbsp;
  <input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

  </form>

  <script language="JavaScript" type="text/javascript">
  <!--
    document.mainform.gastaktivierung.focus();
  // -->
</script><?php

echo $footer;

?>
