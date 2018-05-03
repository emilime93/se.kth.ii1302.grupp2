<?php
class Display {
	private $ip;
	private $port;
	
	function __construct() {
		include('~/server_config/login_info.php');
		$this->ip = $ip;
		$this->port = $port;
	}
	
	function send_message($MessageDTO) {
		return false;
	}
}