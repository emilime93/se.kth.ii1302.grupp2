<?php

class MessageModel {
	private $text;
	private $date;
	private $time_to_live;
	
	function __construct($text, $date, $time_to_live) {
		$this->text = $text;
		$this->date = $date;
		$this->time_to_live = $time_to_live;
	}
	function get_text() {
		return $this->text;
	}
	function get_date() {
		return $this->fname;
	}
	function get_time_to_live() {
		return $this->lname;
	}
}