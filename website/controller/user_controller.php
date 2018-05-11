<?php
class UserController {
	/*
	* Registers a user into the database. Sets $_SESSION['register_success'] to either TRUE or FALSE
	* to indicate the success of registering the user.
	*
	* @param RegistryDTO	$registry_DTO information about the user that is to be registered
	*/
	function create_user($registry_DTO) {
		$valid_username_chars = array('_', '-');
		$max_username = 30;
		$max_name = 50;
		if (!ctype_alnum(str_replace($valid_username_chars, "", $registry_DTO->get_username()))
			|| strlen($registry_DTO->get_username()) > $max_username || strlen($registry_DTO->get_username()) < 1) {
			$_SESSION['register_username_error'] = 'The username can only contain letters, numbers, "_" and "-". Max length for the username is ' . $max_username . ' characters.';
			header("Location: /index.php");
		}
		if (!ctype_alpha($registry_DTO->get_fname() . $registry_DTO->get_lname()) 
			|| strlen($registry_DTO->get_fname()) > $max_name || strlen($registry_DTO->get_lname()) > $max_name) {
			$_SESSION['register_name_error'] = 'The firstname and lastname can only contain letters and the max length for the name fields are ' . $max_name . ' characters.';
			header("Location: /index.php");
		}
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/user_db.php');
		$UserDB = new UserDB();
		
		if($UserDB->create_user($registry_DTO)) {
			$_SESSION['register_success'] = true;
		} else {
			$_SESSION['register_success'] = false;
		}
		header("Location: /index.php");
	}
	
	/*
	* Used to login a user. Saves the user in $_SESSION['logged_in_user'] if successful or
	* $_SESSION['login_failed'] to TRUE if the login failed.
	*
	* @param UserDTO	$user_DTO the user that is to be logged in
	*/
	function login_user($user_DTO) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/user_db.php');
		$UserDB = new UserDB();
		
		if ($result = $UserDB->login_user($user_DTO)) {
			$_SESSION['logged_in_user'] = serialize($result);
		} else {
			$_SESSION['login_failed'] = true;
		}
		header("Location: /index.php");
	}

	/*
	* Unsets the $_SESSION['logged_in_user'] to logout a user.
	*/
	function log_out() {
		unset($_SESSION['logged_in_user']);
		header('Location: /index.php');
	}
}