<?php

class WBConfigManager {
	private $revision = '?';
	private $rev_datum = '?';
	private $mysql_access_data_server = 'localhost';
	private $mysql_access_data_port = '';
	private $mysql_access_data_prefix = 'webbase_';
	private $mysql_access_data_username = 'root';
	private $mysql_access_data_password = '';
	private $mysql_access_data_database = 'webbase';
	private $mysql_access_data_use_mysqli = false;
	private $lock = false;
	private $force_ssl = false;

	function getRevision() {
		return $this->revision;
	}

	function getRevDatum() {
		return $this->rev_datum;
	}

	function getMySQLServer() {
		return $this->mysql_access_data_server;
	}

	function getMySQLPort() {
		return $this->mysql_access_data_port;
	}

	function getMySQLPrefix() {
		return $this->mysql_access_data_prefix;
	}

	function getMySQLUsername() {
		return $this->mysql_access_data_username;
	}

	function getMySQLPassword() {
		return $this->mysql_access_data_password;
	}

	function getMySQLDatabase() {
		return $this->mysql_access_data_database;
	}

	function getMySQLUseMySQLI() {
		return $this->mysql_access_data_use_mysqli;
	}

	function getLockFlag() {
		return $this->lock;
	}

	function getForceSSLFlag() {
		return $this->force_ssl;
	}

	function init() {
		$revision = '?';
		$rev_datum = '?';

		if (file_exists('includes/revision.inc.php')) {
		        include 'includes/revision.inc.php';
		}

		$mysql_access_data = array();
		$mysql_access_data['server']   = 'localhost';
		$mysql_access_data['port']     = '';
		$mysql_access_data['prefix']   = 'webbase_';
		$mysql_access_data['username'] = 'root';
		$mysql_access_data['password'] = '';
		$mysql_access_data['database'] = 'webbase';
		$mysql_access_data['use_mysqli'] = false;
		$lock = false;
		$force_ssl = false;

		if (file_exists('includes/config.inc.php')) {
		        include 'includes/config.inc.php';
		}

		$this->revision = $revision;
		$this->rev_datum = $rev_datum;
		$this->mysql_access_data_server = $mysql_access_data['server'];
		$this->mysql_access_data_port   = $mysql_access_data['port'];
		$this->mysql_access_data_prefix = $mysql_access_data['prefix'];
		$this->mysql_access_data_username = $mysql_access_data['username'];
		$this->mysql_access_data_password = $mysql_access_data['password'];
		$this->mysql_access_data_database = $mysql_access_data['database'];
		$this->mysql_access_data_use_mysqli = $mysql_access_data['use_mysqli'];
		$this->lock = $lock;
		$this->force_ssl = $force_ssl;		
	}
}

?>
