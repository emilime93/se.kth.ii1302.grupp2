<?php

class UserDTO {
	/**
	 * User Data Transfer Object.
	 * Contains:
	 * username
	 * password
	 */
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