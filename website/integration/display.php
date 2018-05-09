<?php
class Display {
	private $ip;
	private $port;
	
	function __construct() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
		$this->ip = $ip;
		$this->port = $port;
	}
	
	private function connect() {
		include($_SERVER['DOCUMENT_ROOT'].'/../login_info.php');
	
        \mysqli_report(MYSQLI_REPORT_ERROR);
		$this->connection = new \mysqli($HOST, $USER, $PASSWORD, $DATABASE);
	}
	
	function send_message($messageDTO, $username) {
		$fp = fsockopen ($this->ip, $this->port, $errno, $errstr, 3); 
		if (!$fp) {
			return false;
		} else {
			fputs($fp, $messageDTO->get_text());
			fclose($fp);
			$this->set_display_db($messageDTO, $username);	// ignores true/false from set_display_db
			return true;
		}
	}
	
	private function set_display_db($messageDTO, $username) {
		$text = $messageDTO->get_text();
		
        $this->connect();
		$prepare_stmt = $this->connection->prepare("INSERT INTO display (text, username, time_to_live) VALUES (?, ?, ?)");
		$ttl = $messageDTO->get_time_to_live();
		$prepare_stmt->bind_param('ssi', $text, $username, $ttl);
		$result = $prepare_stmt->execute();
		$prepare_stmt->close();
		return $result;
	}

	function erase_message() {
		// TODO
	}

	function get_message() {
		$this->connect();
		$prepare_stmt = $this->connection->prepare("SELECT text, UNIX_TIMESTAMP(date), time_to_live, id FROM display ORDER BY date DESC");

		$prepare_stmt->execute();
        $prepare_stmt->bind_result($result_text, $result_date, $result_time_to_live, $result_id);
		$result_time_to_live_seconds = $result_time_to_live * 60;
		if($prepare_stmt->fetch()) {
			$prepare_stmt->close();
			if ($result_time_to_live == 0) {
				$message_model = new MessageModel($result_text, $result_date, $result_time_to_live, $result_id);
				return $message_model;
			}
			if ((time() - ($result_date + $result_time_to_live_seconds)) < 0) {
				$message_model = new MessageModel($result_text, $result_date, $result_time_to_live, $result_id);
				return $message_model;
			}
			return false;	// old message
        } else {			// no message
			$prepare_stmt->close();
            return false;
        }
	}
	
}