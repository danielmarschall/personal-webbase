<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

unset($_SESSION['PMA_Config']);

if (!isset($id)) $id = '';

echo 'Bitte warten...

<script language="JavaScript" type="text/javascript">
<!--
document.location.href = "modules/'.wb_dir_escape($modul).'/system/?server='.urlencode($id).'";
// -->
</script>';

?>