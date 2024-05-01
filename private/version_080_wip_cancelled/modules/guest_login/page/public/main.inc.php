<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.htmlentities($module_information->caption).'</h1>';

if ($configuration[$modul]['enable_gast'])
{
	echo 'Hier k&ouml;nnen Sie sich in ein kostenloses, frei zug&auml;ngliches Personal WebBase-Konto auf diesem
Server einloggen. Dort k&ouml;nnen Sie die vielen M&ouml;glichkeiten von
Personal WebBase beliebig testen. Vielen Dank f&uuml;r das Interesse an Personal WebBase. Klicken Sie auf
&quot;Einloggen&quot;, um Gastzugriff zu erhalten.<br><br>

<form action="index.php" target="_parent" method="POST">
<input type="hidden" name="login_process" value="1">
<input type="hidden" name="wb_user_type" value="0">

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" name="login" value="Einloggen">

</form>
';
}
else
{
	echo '<span class="red">Der Serveradministrator hat den Zugriff auf ein Gastkonto deaktiviert.</span>';
}

echo $footer;

?>