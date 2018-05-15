<?php

class MessageDTO {
	/**
	 * Simaple Data Transfer Object for a message.
	 * Contains the message text and Time To Live.
	 */
	private $text;
	private $time_to_live;
	
	function __construct($text, $time_to_live = 0) {
		$this->text = $text;
		$this->time_to_live = $time_to_live;
	}
	function get_text() {
		return $this->text;
	}
	function set_text($text) {
		$this->text = $text;
	}
	function get_time_to_live() {
		return $this->time_to_live;
	}
	function set_time_to_live($time_to_live) {
		$this->time_to_live = $time_to_live;
	}
}