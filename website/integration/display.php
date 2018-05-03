<?php
class Display {
	private $ip;
	private $port;
	
	function __construct() {
		$this->ip = 'localhost';
		$this->port = 1337;
	}
	
	function send_message($messageDTO) {
		$fp = fsockopen ($this->ip, $this->port, $errno, $errstr); 
		if (!$fp) {
			return false;
		} else {
			fputs($fp, $messageDTO->get_text());
			fclose($fp);
			return true;
		}
	}
}