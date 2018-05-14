<?php
class Display {
	private $ip;
	private $port;
	
	/**
	 * This sets up the display port and ip address from a login_info.php file,
	 * which must lie one level above the server.
	 */
	function __construct() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
		$this->ip = $ip;
		$this->port = $port;
	}
	
	/**
	 * Helper method for connecting to the database for saving the latest message
	 * to be displayed.
	 */
	private function connect() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
	
        \mysqli_report(MYSQLI_REPORT_ERROR);
		$this->connection = new \mysqli($HOST, $USER, $PASSWORD, $DATABASE);
	}
	
	/**
	 * Sends a message to the disaplay and DB.
	 * @param MessageDTO $messageDTO The message to be sent
	 * @param string $username The authors username
	 * @return boolean Returns true if it was able to send the message, otherwise false.
	 */
	function send_message($messageDTO, $username) {
		$fp = fsockopen ($this->ip, $this->port, $errno, $errstr, 3);
		$message_to_display = $this->write_to_display_format($messageDTO);
		if (!$fp) {
			return false;
		} else {
			fputs($fp, $message_to_display);
			fclose($fp);
			$this->set_display_db($messageDTO, $username);	// ignores true/false from set_display_db
			return true;
		}
	}
	
	private function write_to_display_format($messageDTO) {
		$text = $messageDTO->get_text();
		$time_to_live = $messageDTO->get_time_to_live();
		
		$message = "w" . str_pad(strval($time_to_live), 5, "0", STR_PAD_LEFT) . $text;
		return $message;
	}
	
	/**
	 * @param MessageDTO $messageDTO The message to be set in DB
	 * @param string $username The authors username
	 * @return boolean Returns true if it was able to save to the database, otherwise if returns false.
	 */
	private function set_display_db($messageDTO, $username) {
		$text = $messageDTO->get_text();
        $this->connect();
		$this->erase_message();
		$prepare_stmt = $this->connection->prepare("INSERT INTO display (text, username, time_to_live) VALUES (?, ?, ?)");
		$ttl = $messageDTO->get_time_to_live();
		$prepare_stmt->bind_param('ssi', $text, $username, $ttl);
		$result = $prepare_stmt->execute();
		$prepare_stmt->close();
		return $result;
	}

	/**
	 * Asks the display to erase the currently displayed message, and removes/updates the entry in DB.
	 *
	 * @return boolean TRUE if the deletion went through and FALSE if it failed
	 */
	function erase_message() {
		$this->connect();
		$prepare_stmt = $this->connection->prepare("DELETE FROM display");
		$result = $prepare_stmt->execute();
		$prepare_stmt->close();
        return $result;
	}
	/*
	function erase_message() {
		$fp = fsockopen ($this->ip, $this->port, $errno, $errstr, 3);
		if (!$fp) {
			return false;
		} else {
			fputs($fp, "c");
			fclose($fp);
			return true;
		}
	}
	*/
	
	/**
	 * Gets the latest message from the database (from the display in the future).
	 * @return MessageDTO/boolean Returns a message to be displayed if there's an eligable one. Otherwise returns false.
	 */
	function get_message() {
		$this->connect();
		$prepare_stmt = $this->connection->prepare("SELECT text, UNIX_TIMESTAMP(date), time_to_live, id FROM display ORDER BY date DESC");

		$prepare_stmt->execute();
        $prepare_stmt->bind_result($result_text, $result_date, $result_time_to_live, $result_id);
		if($prepare_stmt->fetch()) {
			$result_time_to_live_seconds = $result_time_to_live * 60;
			$prepare_stmt->close();
			if ($result_time_to_live == 0) {
				$message_DTO = new MessageDTO($result_text, $result_time_to_live);
				return $message_DTO;
			}
			if ((time() - ($result_date + $result_time_to_live_seconds)) < 0) {
				$message_DTO = new MessageDTO($result_text, $result_time_to_live);
				return $message_DTO;
			}
			return false;	// old message
        } else {			// no message
			$prepare_stmt->close();
			return false;
        }
	}
	/*
	function get_message() {
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $this->ip, $this->port) or die("Could not connect to server\n");
		
		$message = "r";
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");

		stream_set_timeout($socket, 3);
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		socket_close($socket);
		$result_text = substr($result, 5);
		$result_time_to_live = substr($result, 0, 5);
		
		$message_DTO = new MessageDTO($result_text, $result_time_to_live);
		return $message_DTO;
	}
	*/
	
}