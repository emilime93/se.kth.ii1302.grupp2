<?php

class MessageController {
	
	function save_message($messageDTO) {
		$max_length = 40;
		if(strlen($messageDTO->get_text()) < 1 || strlen($messageDTO->get_text()) > $max_length) {
			$_SESSION['message_length_error'] = "The message should be at least 1 character and at most " . $max_length . " characters long.";
			header("Location: /index.php");
			die();
		}

		require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
		$user_model = unserialize($_SESSION['logged_in_user']);
		$username = $user_model->get_username();

		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$message_db = new MessageDB();
		
		// Clean the input
		$messageDTO->set_text(strip_tags($messageDTO->get_text()));
		$messageDTO->set_text(htmlspecialchars($messageDTO->get_text()));

		if($message_db->save_message($messageDTO, $username)) {
			$_SESSION['save_message_success'] = true;
		} else {
			$_SESSION['save_message_success'] = false;
		}
		header("Location: /index.php");
	}

	function delete_saved_message($id, $user) {
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
		$messageDTO = new MessageDTO($message->get_text(), $message->get_time_to_live());

		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();

		if($display->send_message($messageDTO)) {
			$_SESSION['send_saved_message_success'] = true;
		} else {
			$_SESSION['send_saved_message_success'] = false;
		}
		header("Location: /index.php");
	}

	function get_saved_messages() {
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_model.php');
		$user = unserialize($_SESSION['logged_in_user']);
		$username = $user->get_username();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$msg_db = new MessageDB();
		return $msg_db->get_saved_messages($username);
	}
	
	function send_message($messageDTO) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();

		// Clean the input
		$messageDTO->set_text(strip_tags($messageDTO->get_text()));
		$messageDTO->set_text(htmlspecialchars($messageDTO->get_text()));

		if($display->send_message($messageDTO)) {
			$_SESSION['send_message_success'] = true;
		} else {
			$_SESSION['send_message_success'] = false;
		}
		header("Location: /index.php");
	}
	
	function get_display_message() {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_model.php');
		return $display->get_message();
	}

}