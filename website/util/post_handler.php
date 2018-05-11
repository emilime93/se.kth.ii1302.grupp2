<?php
session_start();

/**
 * This handles all post requests from the user. It creates necesary DTOs and calls the propper controller method.
 * If the post request was faulty, it redirects the user to index.php.
 */

switch($_POST['submit']) {
	
	/********************
	*	USER HANDLING	*
	*********************/
	case "register":
		$username = $_POST['username'];
		$password = \password_hash($_POST['password'], PASSWORD_DEFAULT);
		$signup_code = $_POST['signup_code'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		
		// Checks if password is empty
		if (strlen($_POST['password']) <= 0) {
			$_SESSION['register_success'] = false;
			header("Location: /index.php");
		}
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/registry_DTO.php');
		$RegistryDTO = new RegistryDTO($username, $password, $signup_code, $fname, $lname, $email);
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/user_controller.php');
		$UserController = new UserController();
		$UserController->create_user($RegistryDTO);
	break;
	case "login":
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/user_DTO.php');
		$UserDTO = new UserDTO($username, $password);
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/user_controller.php');
		$UserController = new UserController();
		$UserController->login_user($UserDTO);
	break;
	case "logout":
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/user_controller.php');
		$UserController = new UserController();
		$UserController->log_out();
	break;
	
	/********************
	* MESSAGE HANDLING	*
	*********************/
	case "save":
		$text = $_POST['text'];
		if ($_POST['time-to-live'] == "") {
			$time_to_live = 0;
		} else {
			$time_to_live = $_POST['time-to-live'];
		}

		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/message_DTO.php');
		$MessageDTO = new MessageDTO($text, $time_to_live);
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/message_controller.php');
		$MessageController = new MessageController();
		$MessageController->save_message($MessageDTO);
	break;
	case "delete-saved":
		$id = $_POST['comment-id'];
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
		$username = unserialize($_SESSION['logged_in_user']);
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/message_controller.php');
		$MessageController = new MessageController();
		$MessageController->delete_saved_message($id, $username);
	break;
	case "send-saved":
		$id = $_POST['comment-id'];
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/message_controller.php');
		$MessageController = new MessageController();

		$MessageController->send_saved_message_by_id($id);
	break;
	case "clear-display":
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();
		$display->erase_message();
		header("Location: /index.php");
	break;
	case "send":
		$text = $_POST['text'];
		if ($_POST['time-to-live'] == "") {
			$time_to_live = 0;
		} else {
			$time_to_live = $_POST['time-to-live'];
		}

		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/message_DTO.php');
		$MessageDTO = new MessageDTO($text, $time_to_live);
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/controller/message_controller.php');
		$MessageController = new MessageController();
		$MessageController->send_message($MessageDTO);
	break;
	default:
		header("Location: /index.php");
	break;
}