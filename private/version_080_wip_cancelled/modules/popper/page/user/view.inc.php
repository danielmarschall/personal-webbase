<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

?><html>
<body>

<form method="post" name="loginForm" action="modules/<?php echo $modul; ?>/system/index.php">
	<input type="hidden" name="user_id" value="<?php echo $id; ?>">
	<input type="hidden" name="login" value="Login">
</FORM>

Bitte warten...<br><br>

<script language="JavaScript" type="text/javascript">
<!--
	document.loginForm.submit();
// -->
</script>

</body>

</html>