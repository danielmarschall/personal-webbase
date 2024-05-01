<?php

require 'includes/main.inc.php';

// Ist das Testcookie "Angekommen"?

if ((isset($_COOKIE['cookieAcceptingTest'])) &&
	($_COOKIE['cookieAcceptingTest'] == $_GET['testCookie'])) {
	// Ja: Cookie wieder entfernen, Seite weiter laden
	wbUnsetCookie('cookieAcceptingTest');
	$insert = '';
} else {
	// Nein: Fehler!
	$insert = '<script language="JavaScript">
	<!--
		parent.location.href = "cookie_failure.php";
	// -->
	</script>';
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	 <title>ViaThinkSoft Personal WebBase</title>
	 <link href="style.css.php" rel="stylesheet" type="text/css">
	 <meta name="robots" content="noindex">
</head>

<body class="margin_bottom">

<?php echo $insert; ?>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
<td align="right" valign="top"><img src="designs/spacer.gif" width="1" height="2" alt=""><br></td>
<td align="right" valign="top" width="100%"><a class="bottom_mini" href="index.php" target="_blank">Fenster duplizieren</a></td>
</tr>
</table>

</body>

</html>

