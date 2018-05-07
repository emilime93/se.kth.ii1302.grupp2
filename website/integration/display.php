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
	
	function send_message($messageDTO) {
		$fp = fsockopen ($this->ip, $this->port, $errno, $errstr, 3); 
		if (!$fp) {
			return false;
		} else {
			fputs($fp, $messageDTO->get_text());
			fclose($fp);
			return true;
		}
	}

	function erase_message() {
		// TODO
	}

	function get_message() {
		$this->connect();
		$prepare_stmt = $this->connection->prepare("SELECT text, UNIX_TIMESTAMP(date), time_to_live, id FROM display ORDER BY date DESC");

		$prepare_stmt->execute();
        $prepare_stmt->bind_result($result_text, $result_date, $result_time_to_live, $result_id);
		if($prepare_stmt->fetch()) {
			$prepare_stmt->close();
			if ($result_time_to_live == 0) {
				$message_model = new MessageModel($result_text, $result_date, $result_time_to_live, $result_id);
				return $message_model;
			}
			if ((time() - ($result_date + $result_time_to_live)) < 0) {
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