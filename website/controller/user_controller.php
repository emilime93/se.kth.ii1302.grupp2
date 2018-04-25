<?php
session_start();

switch($_POST['button']) {
	case "register":
		$username = $_POST['username'];
		$password = \password_hash($_POST['password'], PASSWORD_DEFAULT);
		$signup_code = $_POST['signup_code'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		
		//  the if statement is true if username contains chars that isn't letters, numbers or in "$valid_chars"
		$valid_chars = array('_', '-');
		if (!\ctype_alnum(\str_replace($valid_chars, '', $username))) {
			$_SESSION['register_success'] = false;
			header("Location: /index.php");
		}
		
		require_once('..\modelDTO\registry_DTO.php');
		$registry_DTO = new registry_DTO($username, $password, $signup_code, $fname, $lname, $email);
		
		require_once('..\integration\user_db.php');
		$user_db = new user_db();
		
		if($user_db->create_user($registry_DTO)) {
			$_SESSION['register_success'] = true;
		} else {
			$_SESSION['register_success'] = false;
		}
		header("Location: /index.php");
	break;
	case "login":
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		require_once('..\modelDTO\user_DTO.php');
		$user_DTO = new user_DTO($username, $password);
		
		require_once('..\integration\user_db.php');
		$user_db = new user_db();
		
		if ($result = $user_db->login_user($user_DTO)) {
			session_start();
			$_SESSION['logged_in_user'] = serialize($result);
		} else {
			$_SESSION['login_failed'] = true;
		}
		header("Location: /index.php");
	break;
	default:
		header("Location: /index.php");
	break;
}