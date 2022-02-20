<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('ereignisprotokoll', $m2, 'datetime', "datetime NOT NULL default '0000-00-00 00:00:00'",
                                              'modul', "varchar(255) NOT NULL default ''",
                                              'message', "text NOT NULL default ''",
                                              'vorkommen', "bigint(21) NOT NULL default '1'");

?>