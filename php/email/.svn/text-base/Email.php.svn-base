<?php
class Email {

	private $from;
	private $to;
	private $subject;
	private $headers;
	private $message;
	private $cc;

	function __construct($from, $to, $subject, $message, $cc) {
		$this->from = $from;
		$this->to = $to;
		$this->subject = $subject;
		$this->message = $message;
		$this->cc = $cc;
		$this->prepare();
	}

	function prepare()	{
		$this->subject	 = mb_encode_mimeheader($this->subject,'UTF-8');

		if( $this->from )$this->headers	.= "From: $this->from\r\n";
		if( $this->cc )  $this->headers .= "Cc: $this->cc\r\n";
		$this->headers	.= "MIME-Version: 1.0\r\n";
		$this->headers	.= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$this->headers	.= "(anti-spam-(anti-spam-content-type:)) text/html;\r\n";
		$this->headers	.= "Content-Transfer-Encoding: 8bit\n";
		$this->headers	.= "X-Mailer: PHP\n";

		ini_set('mailparse.def_charset', 'ISO-8859-1');
	}

	function send() {
		return mail($this->to, $this->subject, $this->message, $this->headers);
	}
}
?>