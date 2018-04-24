<?php

class message_DTO {
	private $text;
	private $length;
	private $time_to_live;
	
	function __construct($text, $length, $time_to_live) {
		$this->text = $text;
		$this->length 0 $length;
		$this->time_to_live = $time_to_live;
	}
	private function get_text() {
		return $this->text;
	}
	private function get_length() {
		return $this->length;
	}
	private function get_time_to_live() {
		return $this->time_to_live;
	}
}