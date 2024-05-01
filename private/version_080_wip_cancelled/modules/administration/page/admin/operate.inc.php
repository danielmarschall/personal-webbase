<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'changepwd')
{
	if ($configuration[$modul]['admin_pwd'] != md5($oldpwd))
	{
		die($header.'<h1>'.htmlentities($module_information->caption).'</h1>Das eingegebene aktuelle Passwort ist nicht korrekt!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul='.$modul.'">Zur&uuml;ck zur Eingabe</a>'.$footer);
	}

	if ($newpwd != $newpwd2)
	{
		die($header.'<h1>'.htmlentities($module_information->caption).'</h1>Die beiden neuen Passw&ouml;rter sind nicht gleich!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul='.$modul.'">Zur&uuml;ck zur Eingabe</a>'.$footer);
	}

	wb_change_config('admin_pwd', md5($newpwd), $modul);
	$_SESSION['wb_user_password'] = $newpwd;

	// die($header.'<h1>'.htmlentities($module_information->caption).'</h1>Das &Auml;ndern des Passwortes war erfolgreich!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul='.$modul.'">Zur&uuml;ck zur Eingabe</a>'.$footer);

	echo '<script language="JavaScript" type="text/javascript">
				<!--

				parent.location.href = \'index.php\';

				// -->
</script>';
}

?>