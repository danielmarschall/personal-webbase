<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."fatalvortex` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
  $row = db_fetch($res);

  echo $header.'Bitte warten...

<form action="http://www.fatal-vortex.de/component/option,com_fatalvortexlogin/" method="post" name="loginfrm">
  <input type="hidden" name="login" value="'.$row['benutzername'].'">
  <input type="hidden" name="password" value="'.$row['passwort'].'">
  <input type="hidden" name="task" value="login">
  <input type="hidden" name="lang" value="germani">
  <input type="hidden" name="return" value="/index.php">
</form>

<script language="JavaScript" type="text/javascript">
<!--
  document.loginfrm.submit();
// -->
</script>'.$footer;

?>