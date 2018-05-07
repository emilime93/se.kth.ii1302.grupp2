<?php

class MessageModel {
	private $text;
	private $date;
	private $id;
	private $time_to_live;
	
	function __construct($text, $date, $time_to_live, $id) {
		$this->text = $text;
		$this->date = $date;
		$this->time_to_live = $time_to_live;
		$this->id = $id;
	}
	function get_text() {
		return $this->text;
	}
	function get_id() {
		return $this->id;
	}
	function get_date() {
		return $this->fname;
	}
	function get_time_to_live() {
		return $this->time_to_live;
	}
}