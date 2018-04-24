<?php

class user_DTO {
	private $username;
	private $password;
	
	function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	function get_username() {
		return $this->username;
	}
	function get_password() {
		return $this->password;
	}
}