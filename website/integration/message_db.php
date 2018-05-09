<?php

class MessageDB {
	private $HOST;
	private $DATABASE;
	private $USER;
    private $PASSWORD;
	private $connection;
	
	/**
	 * Set ups all connection details from a file one level above the server root.
	 */
	public function __construct() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
		$this->HOST = $HOST;
		$this->DATABASE = $DATABASE;
		$this->USER = $USER;
		$this->PASSWORD = $PASSWORD;
	}
	
	/**
	 * Connects the instance to the dababase.
	 */
	private function connect() {
        \mysqli_report(MYSQLI_REPORT_ERROR);
		$this->connection = new \mysqli($this->HOST, $this->USER, $this->PASSWORD, $this->DATABASE);
	}
	
	/**
	 * @param MessageDTO $message_DTO The message to be saved.
	 * @param string $username The authors username.
	 * @return boolean returns true if it was successfully saved. Otherwise false.
	 */
	public function save_message($message_DTO, $username) {
		$text = $message_DTO->get_text();
		
        $this->connect();
		$prepare_stmt = $this->connection->prepare("INSERT INTO message (text, username, time_to_live) VALUES (?, ?, ?)");
		$ttl = $message_DTO->get_time_to_live();
		$prepare_stmt->bind_param('ssi', $text, $username, $ttl);
		$result = $prepare_stmt->execute();
		$prepare_stmt->close();
		return $result;
	}
	
	/**
	 * Gets a message from the DB from an ID.
	 * @param int $id The ID of the message requested.
	 * @return MessageModel/boolean The requested message, or false if it was not found.
	 */
	function get_message_by_id($id) {
		$this->connect();

		$prepare_stmt = $this->connection->prepare("SELECT * FROM message WHERE id = ?");
		$prepare_stmt->bind_param('i', $id);
		$prepare_stmt->execute();

		$result = $prepare_stmt->get_result();
		
		$row = $result->fetch_assoc();

		require_once($_SERVER['DOCUMENT_ROOT']."/model/message_model.php");
		$msg_model = new MessageModel($row['text'], $row['date'], $row['time_to_live'], $row['id']);
		$prepare_stmt->close();
		return $msg_model;
		
	}
	
	/**
	 * Erases a saved message from the database.
	 * @param int $id The requested messages ID.
	 * @param string $username The authors username.
	 * @return boolean True if the message was successfully deleted. Otherwise false.
	 */
	function erase_saved_message($id, $username) {
        $this->connect();
        $prepare_stmt = $this->connection->prepare("DELETE FROM message WHERE id = ? AND username = ?");
        
        $prepare_stmt->bind_param('is', $id, $username);
		$prepare_stmt->execute();
		if ($prepare_stmt->affected_rows > 0) {
			$prepare_stmt->close();
			return true;
		} else {
			$prepare_stmt->close();
			return false;
		}
	}

	/**
	 * @param string $username The name if a author to get saved messages by.
	 * @return MessageModel[] An array of message models from the specified author.
	 */
	function get_saved_messages($username) {
		$this->connect();
		$prepare_stmt = $this->connection->prepare("SELECT * FROM message WHERE username = ?");
		
		$prepare_stmt->bind_param('s', $username);
		$prepare_stmt->execute();

		$result = $prepare_stmt->get_result();
		$n_rows = $result->num_rows;
		
		$result_array = array();
		while($row = $result->fetch_assoc()) {
			require_once($_SERVER['DOCUMENT_ROOT']."/model/message_model.php");
			$msg_model = new MessageModel($row['text'], $row['date'], $row['time_to_live'], $row['id']);
			array_push($result_array, $msg_model);
		}
		$prepare_stmt->close();
		return $result_array;
	}
}