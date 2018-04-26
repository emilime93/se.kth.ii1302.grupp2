<?php

class MessageDB {
	private $HOST;
	private $DATABASE;
	private $USER;
    private $PASSWORD;
	private $connection;
	
	public function __construct() {
		$this->HOST = 'localhost';
		$this->DATABASE = 'digiboard';
		$this->USER = 'digiboard';
		$this->PASSWORD = 'WorkVerifyDone';
	}
	
	public function connect() {
        \mysqli_report(MYSQLI_REPORT_ERROR);
        $this->connection = new \mysqli($this->HOST, $this->USER, $this->PASSWORD, $this->DATABASE);
    }
	public function save_message($message_DTO, $username) {
		$text = $message_DTO->get_text();
		
        $this->connect();
		$prepare_stmt = $this->connection->prepare("INSERT INTO message (text, username) VALUES (?, ?)");
		$prepare_stmt->bind_param('ss', $text, $username);
		return $prepare_stmt->execute();
    }
	
	function erase_saved_message($id, $username) {
        $this->connect();
        $prepare_stmt = $this->connection->prepare("DELETE FROM message WHERE id = ? AND username = ?");
        
        $prepare_stmt->bind_param('is', $id, $username);
        $prepare_stmt->execute();
		if ($prepare_stmt->affected_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}