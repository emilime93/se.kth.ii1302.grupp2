<?php

class MessageController {
	
	function save_message($MessageDTO) {
		// // true if the user isn't logged in!
		// if (!isset($_SESSION['logged_in_user'])) {
			// 	$_SESSION['save_message_success'] = false;
			// 	header("Location: /index.php");
			// }	
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
		$user_model = unserialize($_SESSION['logged_in_user']);
		$username = $user_model->get_username();

		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$message_db = new MessageDB();
		
		if($message_db->save_message($MessageDTO, $username)) {
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
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
		$user_model = unserialize($_SESSION['logged_in_user']);
		$username = $user_model->get_username();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$message_db = new MessageDB();
		
		if($message_db->erase_saved_message($id, $username)) {
			$_SESSION['erase_saved_message_success'] = true;
		} else {
			$_SESSION['erase_saved_message_success'] = false;
		}
		header("Location: /index.php");

	}

	function get_saved_messages() {
		$user = unserialize($_SESSION['logged_in_user']);
		$username = $user->get_username();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$msg_db = new MessageDB();
		return $msg_db->get_saved_messages($username);
	}

}