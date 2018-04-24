<?php

switch($_POST['button']) {
	case "register":
		$username = $_POST['username'];
		$password = \password_hash($_POST['password'], PASSWORD_DEFAULT);
		$signup_code = $_POST['signup_code'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		
		require_once('..\modelDTO\registry_DTO.php');
		$registry_DTO = new registry_DTO($username, $password, $signup_code, $fname, $lname, $email);
		
		require_once('..\integration\user_db.php');
		$user_db = new user_db();
		$user_db->create_user($registry_DTO);
		// TODO: FIXA LYCKAT/FAIL MEDDELANDE
		header("Location: /index.php");

	break;
	case "login":
		echo "login";
	break;
	default:
		echo "inget";
	break;
}

/*
if (isset($_POST['login_btn'])) {
    UserController.register_user();
    echo("Login");
} elseif(isset($_POST['register_btn'])) {
    echo("Register");
} else {
    echo("Other");
}

class UserController {
    
    public function register_user() {
        echo("Register user " . $_POST['username'] . " with password " . $_POST['password']);
    }

    public function login_user() {
        echo("Login in user " . $_POST['username'] . " with password " . $_POST['password']);
    }

}
*/