<?php

class MessageModel {
	private $text;
	private $date;
	private $id;
	private $time_to_live;
	
	/**
	* Contains a message
	*
	* @param String	$text the text of the message
	* @param int 	$date the date that the message was written in unix seconds
	* @param int 	$id the id of the message
	* @param int 	$time_to_live the time to live of the message in minutes
	*/
	function __construct($text, $date, $time_to_live, $id) {
		$this->text = $text;
		$this->date = $date;
		$this->id = $id;
		$this->time_to_live = $time_to_live;
	}
	
	/**
	* @return String the text of the message
	*/
	function get_text() {
		return $this->text;
	}
	/**
	* @return int the id of the message
	*/
	function get_id() {
		return $this->id;
	}
	/**
	* @return int the date that the message was written in unix seconds
	*/
	function get_date() {
		return $this->fname;
	}
	/**
	* @return int the time to live of the message in minutes
	*/
	function get_time_to_live() {
		return $this->time_to_live;
	}
}