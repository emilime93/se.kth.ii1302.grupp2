<?php
class UserController {
	function create_user($registry_DTO) {
		//  the if statement is true if username contains chars that isn't letters, numbers or in "$valid_chars"
		$valid_chars = array('_', '-');
		if (!\ctype_alnum(\str_replace($valid_chars, '', $username))) {
			$_SESSION['register_success'] = false;
			header("Location: /index.php");
		}
		
		require_once('../integration/user_db.php');
		$user_db = new user_db();
		
		if($user_db->create_user($registry_DTO)) {
			$_SESSION['register_success'] = true;
		} else {
			$_SESSION['register_success'] = false;
		}
		header("Location: /index.php");
	}
	function login_user($user_DTO) {
		require_once('../integration/user_db.php');
		$user_db = new user_db();
		
		if ($result = $user_db->login_user($user_DTO)) {
			session_start();
			$_SESSION['logged_in_user'] = serialize($result);
		} else {
			$_SESSION['login_failed'] = true;
		}
		header("Location: /index.php");
	}
}