<?php

require 'includes/main.inc.php';
require 'includes/modulinit.inc.php';

if (!headers_sent()) header('Content-Type: text/css');

$content = '';

if (!file_exists('designs/'.$configuration['admin_designs']['design'].'/style.css'))
	die('');

$handle = @fopen('designs/'.$configuration['admin_designs']['design'].'/style.css', 'r');
while (!@feof($handle))
{
	$buffer = @fgets($handle, 4096);
	$content .= $buffer;
}
@fclose ($handle);

$content = str_replace('###', 'designs/'.$configuration['admin_designs']['design'].'/', $content);

echo $content;

?>