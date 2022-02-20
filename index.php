<?php

require 'includes/main.inc.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">

<html>
<head>
   <title>ViaThinkSoft IronBASE</title>
</head>

<?php

echo '<frameset rows="72,*" noresize border="0" frameborder="0" framespacing="0">
  <frame src="ueberschrift.php" framespacing="0" border="0" frameborder="0" marginheight="0" marginwidth="0" name="Caption" scrolling="no" noresize>
  <frameset cols="200,*,10" noresize border="0" frameborder="0" framespacing="0" noresize>
    <frameset rows="*,14" noresize border="0" frameborder="0" framespacing="0" noresize>
      <frame src="navigation.php';

if ($_SERVER["QUERY_STRING"] != '') echo '?'.$_SERVER["QUERY_STRING"];

echo '" framespacing="0" frameborder="0" marginheight="0" marginwidth="0" name="Navigation" scrolling="no" noresize>
      <frame src="leer.php?mitscrolling=yes" framespacing="0" border="0" name="LeerFrame1" scrolling="no" noresize>
    </frameset>
    <frameset rows="*,10" noresize border="0" frameborder="0" framespacing="0" noresize>
      <frame src="leer.php" framespacing="0" frameborder="0" marginheight="5" marginwidth="7" name="Inhalt" scrolling="auto" noresize>
      <frame src="leer.php" framespacing="0" frameborder="0" marginheight="0" marginwidth="0" name="LeerFrame1" scrolling="no" noresize>
    </frameset>
    <frame src="leer.php" framespacing="0" frameborder="0" marginheight="0" marginwidth="0" name="LeerFrame1" scrolling="no" noresize>
  </frameset>
</frameset>

</html>';

?>