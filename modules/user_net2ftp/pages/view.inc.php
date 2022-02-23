<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res = db_query("SELECT `port`, `server`, `username`, `passwort`, `startverzeichnis` FROM `".$mysql_zugangsdaten['praefix']."net2ftp` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
$row = db_fetch($res);

?><html>

<body>

<form name="LoginForm" id="LoginForm" action="modules/<?php echo $modul; ?>/system/" method="post">
  <input type="hidden" name="ftpserver" value="<?php echo $row['server']; ?>">
  <input type="hidden" name="ftpserverport" value="<?php echo $row['port']; ?>">
  <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
  <input type="hidden" name="password" value="<?php echo $row['passwort']; ?>">
  <input type="hidden" name="directory" value="<?php echo $row['startverzeichnis']; ?>">
  <input type="hidden" name="state" value="browse">
  <input type="hidden" name="state2" value="main">
  <input type="hidden" name="cookieset" value="yes">
  <input type="hidden" name="ftpmode" value="binary">
  <input type="hidden" name="skin" value="blue">
  <input type="hidden" name="language" value="de">
  <input type="hidden" name="login" value="">
</form>

Bitte warten...<br><br>

<script language="JavaScript" type="text/javascript">
<!--
  document.LoginForm.submit();
// -->
</script>

</body>

</html>
