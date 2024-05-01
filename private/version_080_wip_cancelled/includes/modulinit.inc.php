<?php

//////////////////////////////////////////////////////////////////////////////
// MODULINITIALISIERUNG                                                     //
//////////////////////////////////////////////////////////////////////////////

// 1. Modulliste laden

function liste_module()
{
	$ary = array();
	$i = 0;
	$v = 'modules/';
	$verz = opendir($v);

	while ($file = readdir($verz))
	{
		if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
		{
			$i++;
			$ary[$i] = $file;
		}
	}

	closedir($verz);
	sort($ary);

	return $ary;
}

$modules = liste_module();

// 2. Modul-Autostarts ausführen

for ($st=0; true; $st++)
{
	$erf = false;

	foreach ($modules AS $m1 => $m2)
	{
		$module_information = WBModuleHandler::get_module_information($m2);

		if (file_exists('modules/'.$m2.'/autostart/'.$st.'.inc.php'))
		{
			include 'modules/'.$m2.'/autostart/'.$st.'.inc.php';
			$erf = true;
		}
	}

	unset($m1);
	unset($m2);

	if (!$erf) break;
}

?>