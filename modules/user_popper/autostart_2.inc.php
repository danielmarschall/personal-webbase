<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('popper_konten', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                          'folder', "bigint(21) NOT NULL default '0'",
                                          'name', "varchar(255) NOT NULL default ''",
                                          'server', "varchar(255) NOT NULL default ''",
                                          'port', "int(11) NOT NULL default '0'",
                                          'username', "varchar(255) NOT NULL default ''",
                                          'passwort', "varchar(255) NOT NULL default ''",
                                          'personenname', "varchar(255) NOT NULL default ''",
                                          'last_fetch', "int(11) NOT NULL default '0'",
                                          'delete', "enum('0','1') NOT NULL default '1'",
                                          'replyaddr', "varchar(255) default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'popper_konten', 1);

ib_newdatabasetable('popper_messages', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                            'dir', "varchar(255) default NULL",
                                            'konto', "int(11) default NULL",
                                            'uidl', "varchar(255) NOT NULL default ''",
                                            'replyaddr', "varchar(255) default ''",
                                            'tos', "text",
                                            'froms', "text",
                                            'subject', "text",
                                            'is_mime', "tinyint(1) default NULL",
                                            'was_read', "tinyint(1) default NULL",
                                            'mail', "longtext",
                                            'acc_id', "int(11)",
                                            'date', "varchar(14) default NULL",
                                            'priority', "tinyint(4) default '0'",
                                            'from_name', "text");

if (function_exists('set_searchable')) set_searchable($m2, 'popper_messages', 0);

my_add_key($mysql_zugangsdaten['praefix'].'popper_messages', 'uidl', false, 'uidl');

?>