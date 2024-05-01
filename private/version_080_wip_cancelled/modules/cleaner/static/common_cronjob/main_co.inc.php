<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// ToDo! Hier prüfen auf $configuration[$modul]['lock_cleaner_until']

// "SELECT WHERE NOW() < '".$configuration[$modul]['lock_cleaner_until']."'";

if (true)
{
	for ($st=1; true; $st++)
	{
		$erf = false;

		foreach ($modules as $m1 => $m2)
		{
			$module_information = WBModuleHandler::get_module_information($m2);

			if (file_exists('modules/'.$m2.'/crossover/'.$modul.'/'.$st.'.inc.php'))
			{
				$filename = 'modules/'.$m2.'/crossover/'.$modul.'/'.$st.'.inc.php';

				// eval() statt include(), damit Parsing-Fehler gemeldet werden können, die der Admin nicht sehen würde!
				eval('?>' . trim(implode("\n", file($filename))));

				$erf = true;
			}

		}

		unset($m1);
		unset($m2);

		if (!$erf) break;
	}
}

?>