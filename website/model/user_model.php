<?php

class user_model {
	private $username;
	private $fname;
	private $lname;
	private $email;
	
	function __construct($username, $fname, $lname, $email) {
		$this->username = $username;
		$this->fname = $fname;
		$this->lname = $lname;
		$this->email = $email;
	}
	function get_username() {
		return $this->username;
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