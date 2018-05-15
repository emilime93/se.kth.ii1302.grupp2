<?php

require_once('user_DTO.php');

class RegistryDTO extends UserDTO {
	/**
	 * Registry Data Transfer Object.
	 * Contains username and password from User_DTO, as well as:
	 * signup code
	 * first name
	 * last name
	 * email
	 */
	private $signup_code;
	private $fname;
	private $lname;
	private $email;
	
	function __construct($username, $password, $signup_code, $fname, $lname, $email) {
		$this->username = $username;
		$this->password = $password;
		$this->signup_code = $signup_code;
		$this->fname = $fname;
		$this->lname = $lname;
		$this->email = $email;
	}
	function get_username() {
		return $this->username;
	}
	function get_password() {
		return $this->password;
	}
	function get_signup_code() {
		return $this->signup_code;
	}
	function get_fname() {
		return $this->fname;
	}
	function get_lname() {
		return $this->lname;
	}
	function get_email() {
		return $this->email;
	}
	
}