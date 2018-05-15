<?php

class UserModel {
	private $username;
	private $fname;
	private $lname;
	private $email;
	
	/**
	* Contains a user
	*
	* @param String	$username the username of the person
	* @param String	$fname the firstname of the person
	* @param String	$lname the lastname of the person
	* @param String $email the email of the person
	*/
	function __construct($username, $fname, $lname, $email) {
		$this->username = $username;
		$this->fname = $fname;
		$this->lname = $lname;
		$this->email = $email;
	}
	/**
	* @return String the username of the person
	*/
	function get_username() {
		return $this->username;
	}
	/**
	* @return String the firstname of the person
	*/
	function get_fname() {
		return $this->fname;
	}
	/**
	* @return String the lastname of the person
	*/
	function get_lname() {
		return $this->lname;
	}
	/**
	* @return String the email of the person
	*/
	function get_email() {
		return $this->email;
	}
	
}