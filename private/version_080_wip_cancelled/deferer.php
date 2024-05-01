<?php

if (!isset($_GET['target'])) {
	die('Fehlendes Argument: target');
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<title>Weiterleitung</title>
	<!-- <meta http-equiv="refresh" content="0; URL=<?php echo $_GET['target'];  ?>"> -->
	<meta name="robots" content="noindex">
</head>

<body>
	<h1>Bitte warten...</h1>

	<p>Sie werden weitergeleitet zu: <a href="<?php echo $_GET['target'];  ?>"><?php echo $_GET['target'];  ?></a></p>

	<script language ="JavaScript">
	<!--
		window.location.replace("<?php echo $_GET['target']; ?>");
	// -->
	</script>
</body>

</html>
