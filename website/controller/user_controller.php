<?php
class UserController {

	function create_user($registry_DTO) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/user_db.php');
		$UserDB = new UserDB();
		
		if($UserDB->create_user($registry_DTO)) {
			$_SESSION['register_success'] = true;
		} else {
			$_SESSION['register_success'] = false;
		}
		header("Location: /index.php");
	}
	
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

	function log_out() {
		unset($_SESSION['logged_in_user']);
		header('Location: /index.php');
	}
}