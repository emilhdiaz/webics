<?php
class CSVApplicationResponse extends Object implements ApplicationResponse {

	private $status;
	private $endpoint;
	private $response;

	public function __construct( $status, Iterable $object ) {
		parent::__construct();
		$this->status = $status;
		$this->response = ($object instanceOf Iterable) ? $object->iterator() : $object;
	}

	public function send() {
		print "status,$this->status\n";
		print CSV::convert($this->response);
	}
}
?>