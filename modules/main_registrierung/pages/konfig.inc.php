<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  echo $header;

    if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie Konfigurationen des Modules vornehmen.<br><br>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="changekonfig">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

if ($konfiguration[$modul]['enable_userreg'] == '1')
  $zus = 'checked';
else
  $zus = '';

?>

<input type="checkbox" name="allowuserreg" value="1"<?php echo $zus; ?>> Benutzerregistrierung zulassen<br><br>

Sperrdauer nach Registrierung: <input type="text" name="sperrdauer" value="<?php echo $konfiguration[$modul]['sperrdauer']; ?>" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" size="5"> Minuten<br><br>

  <input type="button" onclick="document.location.href='<?PHP echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
  &nbsp;&nbsp;&nbsp;
  <input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

  </form>

<?php

      echo $footer;

?>
