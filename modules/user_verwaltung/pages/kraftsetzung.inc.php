<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type == 0)
{
  die($header.'Keine Zugriffsberechtigung'.$footer);
}
else if ($wb_user_type == 1)
{
  if ($ib_user_passwort != $pwd)
  {
    die($header.'<h1>Verwaltung</h1>Das Passwort zur Verifizierung ist nicht korrekt.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
  }
  else
  {
    if ($aktion == 'pwd_aendern')
    {
      if ($newpwd1 != $newpwd2)
      {
        die($header.'<h1>Verwaltung</h1>Die 2 Passw&ouml;rter stimmen nicht &uuml;berein.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
      }
      else
      {
        if ($newpwd1 == '')
        {
          die($header.'<h1>Verwaltung</h1>Sie m&uuml;ssen ein Passwort eingeben.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
        }
        else
        {
          db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `passwort` = '".md5($newpwd1)."' WHERE `username` = '".db_escape($ib_user_username)."'");// TODO: use sha3 hash, salted and peppered
          $_SESSION['ib_user_passwort'] = $newpwd1;
          if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul).'&fertig=1');
        }
      }
    }

    if ($aktion == 'acc_dele')
    {
      if ($konfiguration[$modul]['allow_user_selfdelete'] == 1)
      {
        if (strtoupper($sic) != 'OK')
        {
          die($header.'<h1>Verwaltung</h1>Zum L&ouml;schen m&uuml;ssen Sie die Sicherheitsfrage beantworten.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
        }
        else
        {
          /* foreach ($tabellen as $m1 => $m2)
          {
            db_query("DELETE FROM `".$mysql_zugangsdaten['praefix'].db_escape($m2)."` WHERE `user` = '".$benutzer['id']."'");
            if (db_affected_rows() > 0)
              db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix'].db_escape($m2)."`");
          }

          unset($m1);
          unset($m2); */

          db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".db_escape($ib_user_username)."'");
          if (db_affected_rows() > 0)
            db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."users`");

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
        die($header.'<h1>Verwaltung</h1>Der Administrator hat Selbstl&ouml;schungen deaktiviert.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
      }
    }
  }
}
else if ($wb_user_type == 2)
{
  if ($aktion == 'changekonfig')
  {
    if ((!isset($userselfdel)) || (($userselfdel == '') || (($userselfdel != '') && ($userselfdel != '1')))) $userselfdel = 0;

    ib_change_config('allow_user_selfdelete', $userselfdel, $modul);

      if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
  if (!isset($vonseite)) $vonseite = 'inhalt';

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.urlencode($vonseite).'&modul='.urlencode($vonmodul));
  }
}

?>
