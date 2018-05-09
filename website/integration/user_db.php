<?php

class UserDB {
	private $HOST;
	private $DATABASE;
	private $USER;
    private $PASSWORD;
	private $connection;
	
	/**
	 * Set ups all connection details from a file one level above the server root.
	 */
	public function __construct() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
		$this->HOST = $HOST;
		$this->DATABASE = $DATABASE;
		$this->USER = $USER;
		$this->PASSWORD = $PASSWORD;
	}
	
	/**
	 * Connects the instance to the dababase.
	 */
	private function connect() {
        \mysqli_report(MYSQLI_REPORT_ERROR);
        $this->connection = new \mysqli($this->HOST, $this->USER, $this->PASSWORD, $this->DATABASE);
	}
	
	/**
	 * Logs in a user if the credentials are correct. Saves the user serialized in the session if successful.
	 * @param UserDTO $user_DTO Username and password of the user who wants to log in.
	 * @return UserModel/boolean Returns a user model of the logged in user if successfull. False if login failed.
	 */
	public function login_user($user_DTO) {
		$username = $user_DTO->get_username();
		$password = $user_DTO->get_password();
		
        $this->connect();
        $prepare_stmt = $this->connection->prepare("SELECT username, fname, lname, email, password FROM user WHERE username = ?");
        
        $prepare_stmt->bind_param('s', $username);
        $prepare_stmt->execute();
        $prepare_stmt->bind_result($result_username, $result_fname, $result_lname, $result_email, $result_password);
        if($prepare_stmt->fetch() && \password_verify($password, $result_password)) {
			require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
			$user_model = new UserModel($result_username, $result_fname, $result_lname, $result_email);
			$prepare_stmt->close();
            return $user_model;
        } else {
			$prepare_stmt->close();
            return false;
        }
	}
	
	/**
	 * Signs up a user, if the username is free and the specified sign-up-code exsists.
	 * @param RegistryDTO $registry_DTO The user who wants to register.
	 * @return boolean True if the registration was successful, False if it failed.
	 */
    public function create_user($registry_DTO) {
		$username = $registry_DTO->get_username();
		$password = $registry_DTO->get_password();
		$signup_code = $registry_DTO->get_signup_code();
		$fname = $registry_DTO->get_fname();
		$lname = $registry_DTO->get_lname();
		$email = $registry_DTO->get_email();
		
		if (!($this->user_exists($username)) && $this->signup_code_exists($signup_code)) {
			$this->connect();
			$prepare_stmt = $this->connection->prepare("INSERT INTO user (username, fname, lname, email, password) VALUES (?, ?, ?, ?, ?)");
			
			$prepare_stmt->bind_param('sssss', $username, $fname, $lname, $email, $password);
			$result = $prepare_stmt->execute();
			$prepare_stmt->close();
			return $result;
		} else {
			return false;
		}
	}
	
	/**
	 * Checks to see if the username already exsists in DB.
	 * @param string $username The username to check.
	 * @return boolean True if the username exists, false if its free.
	 */
	private function user_exists($username) {
        $this->connect();
        $prepare_stmt = $this->connection->prepare("SELECT username FROM user WHERE username = ?");
        
        $prepare_stmt->bind_param('s', $username);
        $prepare_stmt->execute();
		$prepare_stmt->bind_result($username_result);
		
		$result = $prepare_stmt->fetch();
		$prepare_stmt->close();
        return $result;
	}
	
	/**
	 * Checks to see if the a signup code exsists. If it exsists, it removes the code from DB.
	 * @param string $signup_code The signup code to check.
	 * @return boolean True if it exsists, false otherwise.
	 */
	private function signup_code_exists($signup_code) { // Checks if the signup code exists. Deletes the code if it exists and returns true.
        $this->connect();
        $prepare_stmt = $this->connection->prepare("DELETE FROM code WHERE code = ?");
        
        $prepare_stmt->bind_param('s', $signup_code);
        $prepare_stmt->execute();
		if ($prepare_stmt->affected_rows > 0) {
			$prepare_stmt->close();
			return true;
		} else {
			$prepare_stmt->close();
			return false;
		}
	}
}