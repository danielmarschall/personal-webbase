<?php

require 'includes/main.inc.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
   <title>ViaThinkSoft Personal WebBase</title>
   <link href="style.css.php" rel="stylesheet" type="text/css">

   <style type="text/css">
     body
     {
       margin-left:7;
       margin-top:5;
       margin-right:10;
       margin-bottom:5;
     }
  </style>
</head>

<body onload="framefertig()" class="dark2">

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
<tr class="row_tab">
<td><img src="design/spacer.gif" alt="" width="3" height="52"></td>
<td><img src="<?php echo $design_ordner; ?>logo.gif" alt="Personal WebBase - Webinterface" width="210" height="52"></td>
<td><img src="design/spacer.gif" alt="" width="3" height="52"></td>
</tr>
</table>

</td>
<td><img src="design/spacer.gif" alt="" width="7" height="1"></td>
<td valign="bottom" align="left" width="100%">

<table cellspacing="0" cellpadding="0" border="0">
<tr class="row_tab">
<td><img src="design/spacer.gif" alt="" width="4" height="52"></td>
<td valign="bottom"><img src="design/spacer.gif" alt="" height="4" width="1"><br><span id="ueberschrift" style="font-size:1.4em"></span><br><img src="design/spacer.gif" alt="" height="4" width="1"><br><img src="design/spacer.gif" alt="" width="210" height="1"></td>
<td><img src="design/spacer.gif" alt="" width="4" height="52"></td>
</tr>
</table>

</td></tr>
</table>

</td>
<td valign="middle" align="right">

<table cellspacing="0" cellpadding="0" border="0">
<tr class="row_tab">
<td><img src="design/spacer.gif" alt="" width="8" height="52"></td>
<td align="right"><?php

$zeile = $_SERVER["HTTP_HOST"].' ['.$_SERVER["SERVER_ADDR"].']';

echo '<span style="font-size:1.4em">'.$zeile.'</span><br>';
echo '<span style="font-size:1.2em">Version '.$revision.' ('.$rev_datum.')</span>';

?><br>
<img src="design/spacer.gif" alt="" width="<?php

$brei = strlen($zeile)*9;

if ($brei < 200)
  echo '200';
else
  echo $brei;

?>" height="1"></td>
<td><img src="design/spacer.gif" alt="" width="8" height="52"></td>
</tr>
</table>

</td>
</tr>
</table>

</body>

</html>
