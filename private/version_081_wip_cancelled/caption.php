<?php

require 'includes/main.inc.php';
require 'includes/modulinit.inc.php'; // Für $design_ordner

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	 <title>ViaThinkSoft Personal WebBase</title>
	 <link href="style.css.php" rel="stylesheet" type="text/css">
	 <meta name="robots" content="noindex">
</head>

<body onload="framefertig()" class="margin_top">

<script language="JavaScript" type="text/javascript">
<!--
	function framefertig()
	{
		fertig = "1";
	}
// -->
</script>

<table cellspacing="0" cellpadding="0" border="0" width="100%" style="height:100%">
<tr>
<td align="left" valign="middle" width="100%">

<table cellspacing="0" cellpadding="0" border="0">
<tr>
<td valign="bottom" align="left">

<table cellspacing="0" cellpadding="0" border="0">
<tr class="row_top">
<td><img src="designs/spacer.gif" alt="" width="3" height="52"></td>
<td><img src="<?php

echo $design_ordner;

if (file_exists($design_ordner.'images/logo.png'))
{
	echo 'images/logo.png';
}
else if (file_exists($design_ordner.'images/logo.gif'))
{
	echo 'images/logo.gif';
}

?>" alt="ViaThinkSoft Personal WebBase" width="210" height="52"></td>
<td><img src="designs/spacer.gif" alt="" width="3" height="52"></td>
</tr>
</table>

</td>
<td><img src="designs/spacer.gif" alt="" width="7" height="1"></td>
<td valign="bottom" align="left" width="100%">

<table cellspacing="0" cellpadding="0" border="0">
<tr class="row_top">
<td><img src="designs/spacer.gif" alt="" width="4" height="52"></td>
<td valign="bottom"><img src="designs/spacer.gif" alt="" height="4" width="1"><br><span id="ueberschrift" style="font-size:1.4em"></span><br><img src="designs/spacer.gif" alt="" height="4" width="1"><br><img src="designs/spacer.gif" alt="" width="210" height="1"></td>
<td><img src="designs/spacer.gif" alt="" width="4" height="52"></td>
</tr>
</table>

</td></tr>
</table>

</td>
<td valign="middle" align="right">

<table cellspacing="0" cellpadding="0" border="0">
<tr class="row_top">
<td><img src="designs/spacer.gif" alt="" width="8" height="52"></td>
<td align="right"><?php

$zeile = $_SERVER['HTTP_HOST'].' ['.$_SERVER['SERVER_ADDR'].']';

echo '<div style="white-space:nowrap;font-size:1.4em">'.$zeile.'</div>';
echo '<div style="white-space:nowrap;font-size:1.2em">Version '.$WBConfig->getRevision().' ('.$WBConfig->getRevDatum().')</div>';

?></td>
<td><img src="designs/spacer.gif" alt="" width="8" height="52"></td>
</tr>
</table>

</td>
</tr>
</table>

</body>

</html>
