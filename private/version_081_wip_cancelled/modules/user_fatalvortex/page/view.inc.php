<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

	$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."fatalvortex` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	$row = db_fetch($res);

	echo $header.'Bitte warten...

<form action="https://enter.the.fatal-vortex.de/user_login.fv" method="post" name="loginfrm">
	<input type="hidden" name="login" value="'.$row['username'].'">
	<input type="hidden" name="password" value="'.$row['password'].'">
</form>

<script language="JavaScript" type="text/javascript">
<!--
	document.loginfrm.submit();
// -->
</script>'.$footer;

?>