<?php
class JSONApplicationResponse extends Object implements ApplicationResponse {

	private $status;
	private $endpoint;
	private $response;

	public function __construct( $status, Iterable $object ) {
		parent::__construct();
		$this->status = $status;
		$this->response = ($object instanceOf Iterable) ? $object->__toArray() : $object;
	}

	public function send() {
		$json = array(
			'status'	=> $this->status,
			'response'	=> $this->response
		);
		print Zend_Json::encode( $json );
	}
}
?>