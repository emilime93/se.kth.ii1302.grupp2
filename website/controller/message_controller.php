<?php

class MessageController {
	/*
	* Saves a message in the database. Sets $_SESSION['save_message_success'] to either TRUE or FALSE
	* to indicate the success of saving the message.
	*
	* @param MessageDTO	$messageDTO the message to be saved
	*/
	function save_message($messageDTO) {
		$max_length = 40;
		if(strlen($messageDTO->get_text()) < 1 || strlen($messageDTO->get_text()) > $max_length) {
			$_SESSION['save_message_length_error'] = "The message should be at least 1 character and at most " . $max_length . " characters long.";
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

	/*
	* Deletes a saved message from the database. Sets $_SESSION['erase_saved_message_success'] to either TRUE or FALSE
	* to indicate the success of deleting the message.
	*
	* @param int 		$id the id of the message that is to be deleted
	* @param UserModel 	$user the user that is trying to delete the message
	*/
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

	/*
	* Send a message saved in the database to the display. Sets $_SESSION['send_saved_message_success'] to either TRUE or FALSE
	* to indicate the success of sending the message.
	*
	* @param int 	$id the id of the message that is to be sent
	*/
	function send_saved_message_by_id($id) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$msg_db = new MessageDB();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_model.php');
		$message = $msg_db->get_message_by_id($id);

		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/message_DTO.php');
		$messageDTO = new MessageDTO($message->get_text(), $message->get_time_to_live());

		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();

		require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
		$user = unserialize($_SESSION['logged_in_user']);
		$username = $user->get_username();
		if($display->send_message($messageDTO, $username)) {
			$_SESSION['send_saved_message_success'] = true;
		} else {
			$_SESSION['send_saved_message_success'] = false;
		}
		header("Location: /index.php");
	}

	/*
	* Returns the saved messaged from the database.
	*
	* @return MessageModel[]	 an array of the messages savsed in the database.
	*/
	function get_saved_messages() {
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/message_model.php');
		$user = unserialize($_SESSION['logged_in_user']);
		$username = $user->get_username();
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/message_db.php');
		$msg_db = new MessageDB();
		return $msg_db->get_saved_messages($username);
	}
	
	/*
	* Sends a message to the display. Sets $_SESSION['send_message_success'] to either TRUE or FALSE
	* to indicate the success of sending the message.
	*
	* @param MessageDTO 	$messageDTO the message to be sent to the display
	*/
	function send_message($messageDTO) {
		$max_length = 40;
		if(strlen($messageDTO->get_text()) < 1 || strlen($messageDTO->get_text()) > $max_length) {
			$_SESSION['send_message_length_error'] = "The message should be at least 1 character and at most " . $max_length . " characters long.";
			header("Location: /index.php");
			die();
		}
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();

		// Clean the input
		$messageDTO->set_text(strip_tags($messageDTO->get_text()));
		$messageDTO->set_text(htmlspecialchars($messageDTO->get_text()));
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
		$user_model = unserialize($_SESSION['logged_in_user']);
		$username = $user_model->get_username();

		if($display->send_message($messageDTO, $username)) {
			$_SESSION['send_message_success'] = true;
		} else {
			$_SESSION['send_message_success'] = false;
		}
		header("Location: /index.php");
	}
	
	/*
	* Returns the message from the display(or display DB)
	*
	* @return MessageDTO	the message displayed.
	*/
	function get_display_message() {
		require_once($_SERVER['DOCUMENT_ROOT'].'/integration/display.php');
		$display = new Display();
		require_once($_SERVER['DOCUMENT_ROOT'].'/modelDTO/message_DTO.php');
		return $display->get_message();
	}

}