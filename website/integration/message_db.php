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
		$prepare_stmt = $this->connection->prepare("INSERT INTO message (text, username, time_to_live) VALUES (?, ?, ?)");
		$ttl = $message_DTO->get_time_to_live();
		$prepare_stmt->bind_param('ssi', $text, $username, $ttl);
		$result = $prepare_stmt->execute();
		$prepare_stmt->close();
		return $result;
    }
	
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

	function get_saved_messages($user) {
		$this->connect();
		$prepare_stmt = $this->connection->prepare("SELECT * FROM message WHERE username = ?");
		
		$prepare_stmt->bind_param('s', $user);
		$prepare_stmt->execute();

		$result = $prepare_stmt->get_result();
		$n_rows = $result->num_rows;
		
		$result_array = array();
		while($row = $result->fetch_assoc()) {
			require_once($_SERVER['DOCUMENT_ROOT']."/model/message_model.php");
			$msg_model = new MessageModel($row['text'], $row['date'], null);
			array_push($result_array, $msg_model);
		}
		$prepare_stmt->close();
		return $result_array;
		/*
		// FROM STACK OVERFLOW
		if($stmt = $mysqli->prepare($query)){
			/*
				 Binds variables to prepared statement
		 
				 i    corresponding variable has type integer
				 d    corresponding variable has type double
				 s    corresponding variable has type string
				 b    corresponding variable is a blob and will be sent in packets
			$stmt->bind_param('i',$id);
		 
			/* execute query 
			$stmt->execute();
		 
			/* Get the result 
			$result = $stmt->get_result();
		 
			/* Get the number of rows 
			$num_of_rows = $result->num_rows;
		 
			while ($row = $result->fetch_assoc()) {
				 echo 'ID: '.$row['id'].'<br>';
				 echo 'First Name: '.$row['first_name'].'<br>';
				 echo 'Last Name: '.$row['last_name'].'<br>';
				 echo 'Username: '.$row['username'].'<br><br>';
			}

			*/
		 
			/* free results */
			//$stmt->free_result();
		 
			/* close statement */
			/**************************/
	}
}