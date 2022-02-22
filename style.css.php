<?php

require 'includes/main.inc.php';

$content = '';

if (!file_exists('design/'.wb_dir_escape($konfiguration['admin_design']['design']).'/style.css'))
  die('');

$handle = @fopen('design/'.wb_dir_escape($konfiguration['admin_design']['design']).'/style.css', 'r');
while (!@feof($handle))
{
  $buffer = @fgets($handle, 4096);
  $content .= $buffer;
}
@fclose ($handle);

$content = str_replace('###', 'design/'.wb_dir_escape($konfiguration['admin_design']['design']).'/', $content);

echo $content;

?>
