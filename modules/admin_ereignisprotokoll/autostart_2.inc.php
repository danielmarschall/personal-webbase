<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('ereignisprotokoll', $m2, 'datetime', "datetime NULL",
                                              'modul', "varchar(255) NOT NULL default ''",
                                              'message', "text NOT NULL default ''",
                                              'vorkommen', "bigint(21) NOT NULL default '1'");

?>
