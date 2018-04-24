<?php

class user_db {
	private $HOST;
	private $DATABASE;
	private $USER;
    private $PASSWORD;
	private $connection;
	
	public function __construct() {
		$this->HOST = 'localhost';
		$this->DATABASE = 'digiboard';
		$this->USER = 'digiboard';
		$this->PASSWORD = 'WorkVerifyDone';
	}
	
	public function connect() {
        \mysqli_report(MYSQLI_REPORT_ERROR);
        $this->connection = new \mysqli($this->HOST, $this->USER, $this->PASSWORD, $this->DATABASE);
    }
	
    public function user_exists($username) {
        $this->connect();
        $prepare_stmt = $this->connection->prepare("SELECT username FROM user WHERE username = ?");
        
        $prepare_stmt->bind_param('s', $username);
        $prepare_stmt->execute();
        $prepare_stmt->bind_result($username_result);
        return $prepare_stmt->fetch();
    }
	private function signup_code_exists($signup_code) { // Checks if the signup code exists. Deletes the code if it exists and returns true.
        $this->connect();
        $prepare_stmt = $this->connection->prepare("DELETE FROM code WHERE code = ?");
        
        $prepare_stmt->bind_param('s', $signup_code);
        $prepare_stmt->execute();
		if ($prepare_stmt->affected_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
    public function create_user($registry_DTO) {
		$username = $registry_DTO->get_username();
		$password = $registry_DTO->get_password();
		$signup_code = $registry_DTO->get_signup_code();
		$fname = $registry_DTO->get_fname();
		$lname = $registry_DTO->get_lname();
		$email = $registry_DTO->get_email();
		
		if ($this->signup_code_exists($signup_code)) {
			$this->connect();
			$prepare_stmt = $this->connection->prepare("INSERT INTO user (username, fname, lname, email, password) VALUES (?, ?, ?, ?, ?)");
			
			$prepare_stmt->bind_param('sssss', $username, $fname, $lname, $email, $password);
			return $prepare_stmt->execute();
		} else {
			return false;
		}
    }
}