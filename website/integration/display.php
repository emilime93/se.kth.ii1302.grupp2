<?php
class Display {
	private $ip;
	private $port;
	
	function __construct() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
		$this->ip = $ip;
		$this->port = $port;
	}
	
	function send_message($messageDTO) {
		$fp = fsockopen ($this->ip, $this->port, $errno, $errstr, 3); 
		if (!$fp) {
			return false;
		} else {
			fputs($fp, $messageDTO->get_text());
			fclose($fp);
			return true;
		}
	}

	function erase_message() {
		// TODO
	}

	function get_message() {
		// TODO
	}
}