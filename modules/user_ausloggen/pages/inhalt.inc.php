<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  @session_unset();
  @session_destroy();

    echo $header;

  echo '<h1>'.my_htmlentities($modulueberschrift).'</h1><b>Sie werden weitergeleitet</b><br><br>Bitte warten...<br><br><script language="JavaScript" type="text/javascript">
<!--
  parent.location.href = \'index.php\';
// -->
</script>';

  echo $footer;

?>
