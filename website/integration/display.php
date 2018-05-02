<?php
class Display {
	private $ip;
	private $port;
	
	function __construct() {
		$this->ip = '192.168.0.1';
		$this->port = '1337';
	}
	
	function send_message($MessageDTO) {
		return false;
	}
}