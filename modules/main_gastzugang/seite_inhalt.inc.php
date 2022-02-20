<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
    if ($konfiguration[$modul]['enable_gast'])
	{
      echo 'Hier k&ouml;nnen Sie sich in ein kostenloses, frei zug&auml;ngliches IronBASE-Konto auf diesem
Server einloggen. Dort k&ouml;nnen Sie die vielen M&ouml;glichkeiten von
IronBASE beliebig testen. Vielen Dank f&uuml;r das Interesse an IronBASE. Klicken Sie auf
&quot;Einloggen&quot;, um Gastzugriff zu erhalten.<br><br>

<form action="index.php" target="_parent" method="POST">
<input type="hidden" name="login_process" value="1">
<input type="hidden" name="ib_user_type" value="0">

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" name="login" value="Einloggen">

</form>
';
	}
	else
	{
	  echo '<font color="#FF0000">Der Serveradministrator hat den Zugriff auf ein Gastkonto deaktiviert.</font>';
	}

	  echo $footer;

?>