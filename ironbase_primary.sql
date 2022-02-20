-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: www.viathinksoft.de
-- Erstellungszeit: 22. Juni 2008 um 17:09
-- Server Version: 5.0.32
-- PHP-Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `ironbase`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_confixx`
-- 

CREATE TABLE `ironbase_confixx` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  `server` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_dateien`
-- 

CREATE TABLE `ironbase_dateien` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `folder` bigint(21) NOT NULL default '0',
  `dateiname` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `daten` longblob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_datentraeger_eintraege`
-- 

CREATE TABLE `ironbase_datentraeger_eintraege` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `nr` bigint(21) NOT NULL default '0',
  `kategorie` varchar(255) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `medium` enum('CD','DVD') NOT NULL default 'CD',
  `einstellungsdatum` datetime NOT NULL default '0000-00-00 00:00:00',
  `gebrannt` enum('1','0') NOT NULL default '1',
  `aussortiert` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_datentraeger_inhalt`
-- 

CREATE TABLE `ironbase_datentraeger_inhalt` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `kategorie` varchar(255) NOT NULL default '',
  `eintrag` bigint(21) NOT NULL default '0',
  `komplett` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `eintrag` (`eintrag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_datentraeger_kategorien`
-- 

CREATE TABLE `ironbase_datentraeger_kategorien` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `spalte` char(1) NOT NULL default '',
  `nummer` bigint(21) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `spalte_and_nummer` (`spalte`,`nummer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_dokumente`
-- 

CREATE TABLE `ironbase_dokumente` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_ereignisprotokoll`
-- 

CREATE TABLE `ironbase_ereignisprotokoll` (
  `id` bigint(21) NOT NULL auto_increment,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `modul` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `vorkommen` bigint(21) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_fatalvortex`
-- 

CREATE TABLE `ironbase_fatalvortex` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `benutzername` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_html`
-- 

CREATE TABLE `ironbase_html` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hcode` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_kalender`
-- 

CREATE TABLE `ironbase_kalender` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `start_date` date NOT NULL default '0000-00-00',
  `start_time` time NOT NULL default '00:00:00',
  `kommentare` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_konfig`
-- 

CREATE TABLE `ironbase_konfig` (
  `id` bigint(21) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `wert` varchar(255) NOT NULL default '',
  `modul` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name_and_module` (`name`,`modul`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_kontakte`
-- 

CREATE TABLE `ironbase_kontakte` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `strasse` varchar(255) NOT NULL default '',
  `plz` varchar(255) NOT NULL default '',
  `ort` varchar(255) NOT NULL default '',
  `land` varchar(255) NOT NULL default '',
  `telefon` varchar(255) NOT NULL default '',
  `mobil` varchar(255) NOT NULL default '',
  `fax` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `msn` varchar(255) NOT NULL default '',
  `aim` varchar(255) NOT NULL default '',
  `yahoo` varchar(255) NOT NULL default '',
  `skype` varchar(255) NOT NULL default '',
  `kommentare` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_links`
-- 

CREATE TABLE `ironbase_links` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` text NOT NULL,
  `url` text NOT NULL,
  `update_enabled` enum('0','1') NOT NULL default '0',
  `update_checkurl` varchar(255) NOT NULL default '',
  `update_text_begin` longtext NOT NULL,
  `update_text_end` longtext NOT NULL,
  `update_lastchecked` datetime NOT NULL default '0000-00-00 00:00:00',
  `update_lastcontent` varchar(255) NOT NULL default '',
  `neu_flag` enum('0','1') NOT NULL default '0',
  `kaputt_flag` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_module`
-- 

CREATE TABLE `ironbase_module` (
  `id` bigint(21) NOT NULL auto_increment,
  `modul` varchar(255) NOT NULL default '',
  `table` varchar(255) NOT NULL default '',
  `is_searchable` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `table` (`table`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_net2ftp`
-- 

CREATE TABLE `ironbase_net2ftp` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  `server` varchar(255) NOT NULL default '',
  `port` int(11) NOT NULL default '21',
  `startverzeichnis` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_ordner`
-- 

CREATE TABLE `ironbase_ordner` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `kategorie` varchar(255) NOT NULL default '',
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_phpmyadmin`
-- 

CREATE TABLE `ironbase_phpmyadmin` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  `onlydb` varchar(255) NOT NULL default '',
  `server` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_popper_konten`
-- 

CREATE TABLE `ironbase_popper_konten` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `server` varchar(255) NOT NULL default '',
  `port` int(11) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  `personenname` varchar(255) NOT NULL default '',
  `last_fetch` int(11) NOT NULL default '0',
  `delete` enum('0','1') NOT NULL default '1',
  `replyaddr` varchar(255) default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_popper_messages`
-- 

CREATE TABLE `ironbase_popper_messages` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `dir` varchar(255) default NULL,
  `konto` int(11) default NULL,
  `uidl` varchar(255) NOT NULL default '',
  `replyaddr` varchar(255) default '',
  `tos` text,
  `froms` text,
  `subject` text,
  `is_mime` tinyint(1) default NULL,
  `was_read` tinyint(1) default NULL,
  `mail` longtext,
  `acc_id` int(11) default NULL,
  `date` varchar(14) default NULL,
  `priority` tinyint(4) default '0',
  `from_name` text,
  PRIMARY KEY  (`id`),
  KEY `uidl` (`uidl`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_schule_faecher`
-- 

CREATE TABLE `ironbase_schule_faecher` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `jahrgang` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `wertungsfaktor` bigint(11) NOT NULL default '1',
  `positiv` float NOT NULL default '0',
  `negativ` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_schule_hausaufgaben`
-- 

CREATE TABLE `ironbase_schule_hausaufgaben` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `jahrgang` bigint(21) NOT NULL default '0',
  `fach` bigint(21) NOT NULL default '0',
  `text` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_schule_jahrgaenge`
-- 

CREATE TABLE `ironbase_schule_jahrgaenge` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `notensystem` bigint(11) NOT NULL default '0',
  `jahr` varchar(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_schule_noten`
-- 

CREATE TABLE `ironbase_schule_noten` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `jahrgang` bigint(21) NOT NULL default '0',
  `fach` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `wertung` varchar(5) NOT NULL default '',
  `note` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_sessions`
-- 

CREATE TABLE `ironbase_sessions` (
  `id` bigint(21) NOT NULL auto_increment,
  `SessionID` varchar(255) NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `DataValue` text,
  PRIMARY KEY  (`id`),
  KEY `SessionID` (`SessionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=477994 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_tabellen`
-- 

CREATE TABLE `ironbase_tabellen` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `data` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_users`
-- 

CREATE TABLE `ironbase_users` (
  `id` bigint(21) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `gesperrt` enum('0','1') NOT NULL default '0',
  `personenname` varchar(255) NOT NULL default '',
  `passwort` varchar(255) NOT NULL default '',
  `created_database` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `new_password` varchar(10) NOT NULL default '',
  `creator_ip` varchar(15) NOT NULL default '',
  `last_login_ip` varchar(15) NOT NULL default '',
  `fastlogin_secret` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ironbase_zugangsdaten`
-- 

CREATE TABLE `ironbase_zugangsdaten` (
  `id` bigint(21) NOT NULL auto_increment,
  `user` bigint(21) NOT NULL default '0',
  `folder` bigint(21) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
