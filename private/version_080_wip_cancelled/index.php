<?php

require 'includes/main.inc.php';
require 'includes/modulinit.inc.php'; // Für Loginanfragen etc.

// Testen, ob Cookies akzeptiert werden
$testCookie = md5(uniqid(mt_rand(), true));
wbSetCookie('cookieAcceptingTest', $testCookie, 0);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">

<html>

<head>
	 <title>ViaThinkSoft Personal WebBase</title>
	 <meta name="robots" content="noindex">
</head>

<frameset rows="72,*" noresize border="0" frameborder="0" framespacing="0">
	<frame src="caption.php" framespacing="0" border="0" frameborder="0" marginheight="0" marginwidth="0" name="Caption" scrolling="no" noresize>
	<frameset cols="200,*" noresize border="0" frameborder="0" framespacing="0" noresize>
		<frameset rows="*,14" noresize border="0" frameborder="0" framespacing="0" noresize>
			<frame src="navigation.php<?php
				if ($_SERVER['QUERY_STRING'] != '') echo '?'.$_SERVER['QUERY_STRING'];
			?>" framespacing="0" frameborder="0" marginheight="0" marginwidth="0" name="Navigation" scrolling="no" noresize>
			<frame src="scrolling.php" framespacing="0" border="0" name="EmptyFrame1" scrolling="no" noresize>
		</frameset>
		<frameset rows="*,14" noresize border="0" frameborder="0" framespacing="0" noresize>
			<frameset cols="*,10" noresize border="0" frameborder="0" framespacing="0" noresize>
				<frame src="empty.php" framespacing="0" frameborder="0" marginheight="5" marginwidth="7" name="Content" scrolling="auto" noresize>
				<frame src="empty.php" framespacing="0" frameborder="0" marginheight="0" marginwidth="0" name="EmptyFrame3" scrolling="no" noresize>
			</frameset>
			<frame src="bottom.php?testCookie=<?php echo $testCookie; ?>" framespacing="0" frameborder="0" marginheight="0" marginwidth="0" name="EmptyFrame2" scrolling="no" noresize>
		</frameset>
	</frameset>
</frameset>

</html>
