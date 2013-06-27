<?php

Class Postcard {
	public $headers;
	public $message;

	public function create_subject()
	{
		return 'Wish You Were Here!';
	}

	public function create_text()
	{
		$str = '<div style="border: 5px solid black; background-color: red; width: 90%; height: 33%; margin: 0 auto; text-align: center;"><p style="background: #fff; font-size: 2em; font-weight: bold;">Hey Jordan! Wish you were here!</p></div>';
		return $str;
	}

	public function send_postcard()
	{
		$this->email = 'jordanmand@gmail.com';
		$this->headers = 'From: Trip Postcard <postcard@mumblecrumblydesign.com>'."\r\n";
		$this->headers .= 'MIME-Version: 1.0'."\r\n";
		$this->headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
		$this->message = $this->create_text();
		mail($this->email, $this->create_subject(), $this->message, $this->headers);
	}
}
?>
