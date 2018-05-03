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
		$username = $user->get_username();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$message_db = new MessageDB();
		
		if($message_db->erase_saved_message($id, $username)) {
			$_SESSION['erase_saved_message_success'] = true;
		} else {
			$_SESSION['erase_saved_message_success'] = false;
		}
		header("Location: /index.php");
	}

	function send_saved_message_by_id($id) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$msg_db = new MessageDB();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_model.php');
		$message = $msg_db->get_message_by_id($id);

		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/message_DTO.php');
		send_message(new MessageDTO($message->get_text(), $message->get_time_to_live()));
	}

	function get_saved_messages() {
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_model.php');
		$user = unserialize($_SESSION['logged_in_user']);
		$username = $user->get_username();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$msg_db = new MessageDB();
		return $msg_db->get_saved_messages($username);
	}
	
	function send_message($MessageDTO) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();
		if($display->send_message($MessageDTO)) {
			$_SESSION['send_message_success'] = true;
		} else {
			$_SESSION['send_message_success'] = false;
		}
		header("Location: /index.php");
	}

}