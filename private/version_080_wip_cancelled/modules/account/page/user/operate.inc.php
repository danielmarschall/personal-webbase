<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type == 0)
{
	die($header.'Funktionalit&auml;t nur f&uuml;r registrierte Benutzer.'.$footer);
}
else if ($wb_user_type == 1)
{
	if ($wb_user_password != $pwd)
	{
		die($header.'<h1>Verwaltung</h1>Das Passwort zur Verifizierung ist nicht korrekt.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
	}
	else
	{
		if ($aktion == 'pwd_aendern')
		{
			if ($newpwd1 != $newpwd2)
			{
				die($header.'<h1>Verwaltung</h1>Die 2 Passw&ouml;rter stimmen nicht &uuml;berein.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
			}
			else
			{
				if ($newpwd1 == '')
				{
					die($header.'<h1>Verwaltung</h1>Sie m&uuml;ssen ein Passwort eingeben.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
				}
				else
				{
					db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `password` = '".md5($newpwd1)."' WHERE `username` = '".db_escape($wb_user_username)."'");
					$_SESSION['wb_user_password'] = $newpwd1;
					wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul.'&fertig=1');
				}
			}
		}

		if ($aktion == 'acc_dele')
		{
			if ($configuration[$modul]['allow_user_selfdelete'] == 1)
			{
				if (strtoupper($sic) != 'OK')
				{
					die($header.'<h1>Verwaltung</h1>Zum L&ouml;schen m&uuml;ssen Sie die Sicherheitsfrage beantworten.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
				}
				else
				{
					/* foreach ($tables_modules as $m1 => $m2)
					{
						db_query("DELETE FROM `$m1` WHERE `user_cnid` = '".$benutzer['id']."'");
						if (db_affected_rows() > 0)
							db_query("OPTIMIZE TABLE `$m1`");
					}

					unset($m1);
					unset($m2); */

					db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".db_escape($wb_user_username)."'");
					if (db_affected_rows() > 0)
						db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."users`");

					@session_unset();
					@session_destroy();
					echo '<html><script type="text/javascript" language="JavaScript">
					<!--
						parent.location.href=\'index.php\';
						// -->
					 </script></html>';
				}
			}
			else
			{
				die($header.'<h1>Verwaltung</h1>Der Administrator hat Selbstl&ouml;schungen deaktiviert.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
			}
		}
	}
}

?>