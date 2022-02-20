<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changepwd')
  {
    if ($konfiguration[$modul]['admin_pwd'] != md5($oldpwd))
    {
      die($header.'<h1>'.my_htmlentities($modulueberschrift).'</h1>Das eingegebene aktuelle Passwort ist nicht korrekt!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul='.$modul.'">Zur&uuml;ck zur Eingabe</a>'.$footer);
    }

    if ($newpwd != $newpwd2)
    {
      die($header.'<h1>'.my_htmlentities($modulueberschrift).'</h1>Die beiden neuen Passw&ouml;rter sind nicht gleich!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul='.$modul.'">Zur&uuml;ck zur Eingabe</a>'.$footer);
    }

    ib_change_config('admin_pwd', md5($newpwd), $modul);
    $_SESSION['ib_user_passwort'] = $newpwd;

    // die($header.'<h1>'.my_htmlentities($modulueberschrift).'</h1>Das &Auml;ndern des Passwortes war erfolgreich!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul='.$modul.'">Zur&uuml;ck zur Eingabe</a>'.$footer);

    echo '<script language="JavaScript" type="text/javascript">
		  <!--

		  parent.location.href = \'index.php\';

		  // -->
  </script>';
  }

?>
