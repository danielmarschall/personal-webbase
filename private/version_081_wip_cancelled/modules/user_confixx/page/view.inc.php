<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res = db_query("SELECT `server`, `username`, `password` FROM `".$WBConfig->getMySQLPrefix()."confixx` WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");
$row = db_fetch($res);

?><FORM name="loginform" action="<?php echo $row['server']; ?>login.php" method="POST" target="_top">
<INPUT type="hidden" name="username" value="<?php echo $row['username']; ?>">
<INPUT type="hidden" name="password" value="<?php echo $row['password']; ?>">
</form>

Bitte warten...<br><br>

<script language="JavaScript" type="text/javascript">
<!--
	document.loginform.submit();
// -->
</script><?php

?>