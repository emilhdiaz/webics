<?php
class TextApplicationResponse extends Object implements ApplicationResponse {

	private $status;
	private $endpoint;
	private $response;

	public function __construct( $status, Object $text ) {
		parent::__construct();
		$this->status = $status;
		$this->response = $text;
	}

	public function send() {
		print "status: $this->status\n";
		print "response: $this->response\n";
	}
}
?>