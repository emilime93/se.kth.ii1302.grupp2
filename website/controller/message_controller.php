<?php

class MessageController {
	
	function save_message($message) {
		// // true if the user isn't logged in!
		// if (!isset($_SESSION['logged_in_user'])) {
			// 	$_SESSION['save_message_success'] = false;
			// 	header("Location: /index.php");
			// }	
		
		require_once('../model/user_model.php');
		$user_model = unserialize($_SESSION['logged_in_user']);
		$username = $user_model->get_username();
		
		require_once('../modelDTO/message_DTO.php');
		$message_DTO = new message_DTO($message, null);
		
		require_once('../integration/message_db.php');
		$message_db = new message_db();
		
		if($message_db->save_message($message_DTO, $username)) {
			$_SESSION['save_message_success'] = true;
		} else {
			$_SESSION['save_message_success'] = false;
		}
		header("Location: /index.php");
	}

	function delete_saved_message($id, $user) {
		// true if the user isn't logged in!
		// if (!isset($_SESSION['logged_in_user'])) {
		// 	$_SESSION['erase_saved_message_success'] = false;
		// 	header("Location: /index.php");
		// }
		
		require_once('../model/user_model.php');
		$user_model = unserialize($_SESSION['logged_in_user']);
		$username = $user_model->get_username();
		
		require_once('../integration/message_db.php');
		$message_db = new message_db();
		
		if($message_db->erase_saved_message($id, $username)) {
			$_SESSION['erase_saved_message_success'] = true;
		} else {
			$_SESSION['erase_saved_message_success'] = false;
		}
		header("Location: /index.php");

	}

}