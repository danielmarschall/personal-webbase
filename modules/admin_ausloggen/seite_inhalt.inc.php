<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  @session_unset();
  @session_destroy();

  echo $header;

  echo '<h1>'.htmlentities($modulueberschrift).'</h1><b>Sie werden weitergeleitet</b><br><br>Bitte warten...<br><br><script language="JavaScript" type="text/javascript">
<!--
  parent.location.href = \'index.php\';
// -->
</script>';

  echo $footer;

?>