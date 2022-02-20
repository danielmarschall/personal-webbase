<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'f_username\').focus();"', $header);

  echo '<h1>Benutzer bearbeiten</h1>';

  $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '".db_escape($id)."'");
  $row = db_fetch($res);

  $f_username = (isset($row['username'])) ? $row['username'] : '';
  $f_email = (isset($row['email'])) ? $row['email'] : '';
  $f_gesperrt = (isset($row['gesperrt'])) ? $row['gesperrt'] : '';
  $f_personenname = (isset($row['personenname'])) ? $row['personenname'] : '';
  $f_passwort = '';
  $f_created = (isset($row['created_database'])) ? $row['created_database'] : '';
  $f_creator_ip = (isset($row['creator_ip'])) ? $row['creator_ip'] : '';
  $f_lastlogin = (isset($row['last_login'])) ? $row['last_login'] : '';

echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="edit">
<input type="hidden" name="id" value="'.$id.'">

<table cellspacing="0" cellpadding="0" border="0">
<tr>
  <td colspan="2"><b>Benutzerinformationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Benutzername:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="f_username" id="f_username" value="'.$f_username.'" size="50"></td>
</tr>
<tr>
  <td valign="top">E-Mail-Adresse:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="f_email" value="'.$f_email.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Gesperrt:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="checkbox" name="f_gesperrt"';
if ($f_gesperrt) echo ' checked';
echo'> Ja</td>
</tr>
<tr>
  <td valign="top">Personenname:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="f_personenname" value="'.$f_personenname.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Passwort ersetzen:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="checkbox" name="f_neupwd"> <input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="f_passwort" value="'.$f_passwort.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Datenbank erstellt<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">'.de_convertmysqldatetime($f_created).'</td>
</tr>
<tr>
  <td valign="top">&Uuml;ber IP<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">';

  if ($f_creator_ip == '')
    echo 'Unbekannt!';
  else
    echo '<a href="http://www.ripe.net/fcgi-bin/whois?form_type=simple&amp;full_query_string=&amp;searchtext='.$f_creator_ip.'&amp;submit.x=0&amp;submit.y=0" target="_blank">'.$f_creator_ip.'</a> (DNS: '.@gethostbyaddr($f_creator_ip).')';

  echo '</td>
</tr>
<tr>
  <td valign="top">Letzter Login<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">'.de_convertmysqldatetime($f_lastlogin).'</td>
</tr>
</table><br>
<a href="javascript:document.mainform.submit();">&Auml;nderungen durchf&uuml;hren</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>

</form>';

  echo $footer;

?>