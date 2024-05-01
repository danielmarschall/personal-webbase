<?php

	// Secure Mailer PHP Class
	// Revision: 2009-08-13
	// (C) 2009 ViaThinkSoft
	// QB_SECURE_MAIL_PARAM (C) Erich Kachel

	class SecureMailer {
		private $headers;

		private function QB_SECURE_MAIL_PARAM($param_ = '', $level_ = 2) {
			// Verhindert Mail-Header-Injections
			// Quelle: http://www.erich-kachel.de/?p=26

			unset($filtered);

			/* replace until done */
			while ($param_ != $filtered || !isset($filtered)) {

				if (isset($filtered)) {
					$param_ = $filtered;
				}

				$filtered = preg_replace("/(Content-Transfer-Encoding:|MIME-Version:|content-type:|Subject:|to:|cc:|bcc:|from:|reply-to:)/ims", '', $param_);
			}

			unset($filtered);

			if ($level_ >= 2) {
				/* replace until done */
				while ($param_ != $filtered || !isset($filtered)) {

					if (isset($filtered)) {
						$param_ = $filtered;
					}

					$filtered = preg_replace("/(%0A|\\\\r|%0D|\\\\n|%00|\\\\0|%09|\\\\t|%01|%02|%03|%04|%05|%06|%07|%08|%09|%0B|%0C|%0E|%0F|%10|%11|%12|%13)/ims", '', $param_);
				}
			}

			return $param_;
		}

		private function getHeaders() {
			return $this->headers;
		}

		function addHeader($name, $value) {
			$this->headers .= $this->QB_SECURE_MAIL_PARAM($name).': '.$this->QB_SECURE_MAIL_PARAM($value)."\r\n";
		}

		// TODO: Braucht man auch ein addRawHeader()?

		function sendMail($recipient, $subject, $message) {
			return @mail($this->QB_SECURE_MAIL_PARAM($recipient),
				$this->QB_SECURE_MAIL_PARAM($subject),
				$this->QB_SECURE_MAIL_PARAM($message, 1),
				$this->getHeaders());
		}
	}

?>