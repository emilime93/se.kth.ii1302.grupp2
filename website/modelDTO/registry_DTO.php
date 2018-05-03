<?php

require_once('user_DTO.php');

class RegistryDTO extends UserDTO {
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