<?php

class w3c_fragment_checker {

	public static function perform_external_w3c_check($fragment, $validator_url) {
		if ($fragment == '') return true; // Damit es nicht zu einer 302-Endlosschleife kommt, wenn Fragment='' ist!

		$w3c_check_conn = new HTTPClass;

		$w3c_check_conn->connection_checker = 'inetconn_ok';
		$w3c_check_conn->error_level = HTTPC_ERRLVL_FATAL_ERRORS;
		$w3c_check_conn->use_post_method = true;

		$w3c_check_conn->user_agent = WBUserAgent();

		$w3c_check_conn->additional_fields['Referer'] = $validator_url;
		$w3c_check_conn->additional_fields['Content-type'] = 'application/x-www-form-urlencoded';

		$w3c_check_conn_res = $w3c_check_conn->execute_http_request($validator_url.'check', 'fragment='.urlencode($fragment));

		if ($w3c_check_conn_res->error != HTTPC_NO_ERROR) {
			return NULL; // Fehler
		} else {
			/* $pos = strpos($w3c_check_conn_res->content, '<h2 class="valid">');
			if ($pos !== false) {
				$ret_status = 'Valid';
			} else {
				$pos = strpos($w3c_check_conn_res->content, '<h2 id="results" class="invalid">');
				if ($pos !== false) {
					$ret_status = 'Invalid';
				} else {
					$ret_status = 'Abort';
				}
			} */

			// Ab Version 0.8.0 wäre x-w3c-validator-status = Abort.
			// Darunter ist x-w3c-validator-status gar nicht vorhanden
			if (isset($w3c_check_conn_res->header['x-w3c-validator-status'])) {
				$ret_status = $w3c_check_conn_res->header['x-w3c-validator-status'];
			} else {
				$ret_status = 'Abort';
			}

			if ($ret_status == 'Valid') {
				return true;
			} else if ($ret_status == 'Invalid') {
				return false;
			} else {
				return NULL; // Fehler
			}
		}
	}

	public static function local_w3c_check_possible() {
		@include_once 'Services/W3C/HTMLValidator.php';
		return class_exists('Services_W3C_HTMLValidator');
	}

	public static function perform_local_w3c_check($fragment) {
		if ($fragment == '') return true; // Damit diese Funktion kein anderes Ergebnis als perform_external_w3c_check() liefert.

		// Es gibt extrem viele Strict-Fehler im PEAR... Wir dürfen kein E_STRICT hier verwenden
		$old_err_rep = ini_get('error_reporting');

		// PEAR hat einen Notice Fehler, wenn ein Nicht-UTF8-Zeichen in der HTML vorhanden ist
		// error_reporting(E_NOTICE);
		error_reporting(E_ALL ^ E_NOTICE);

		require_once 'Services/W3C/HTMLValidator.php';
		$validator = new Services_W3C_HTMLValidator();
		$res = $validator->validateFragment($fragment);

		ini_set('error_reporting', $old_err_rep);

		if (isset($res->validity)) {
			return $res->validity;
		} else {
			return null;
		}
	}

	public static function auto_perform_w3c_check($fragment, $validator_url, $force_external_check = false) {
		if ((self::local_w3c_check_possible()) && (!$force_external_check)) {
			return self::perform_local_w3c_check($fragment);
		} else {
			return self::perform_external_w3c_check($fragment, $validator_url);
		}
	}
}

?>
