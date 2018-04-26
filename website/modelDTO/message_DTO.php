<?php

class MessageDTO {
	private $text;
	private $time_to_live;
	
	function __construct($text, $time_to_live) {
		$this->text = $text;
		$this->time_to_live = $time_to_live;
	}
	function get_text() {
		return $this->text;
	}
	function get_time_to_live() {
		return $this->time_to_live;
	}
}