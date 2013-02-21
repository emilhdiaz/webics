<?php
class CLISApplicationRequest extends Object implements ApplicationRequest {

	private $endpoint;
	private $request;
	private $return;
	private $arguments;

	public function __construct() {
		parent::__construct();
		$argv = $_SERVER['argv'];
		$this->endpoint 	= array_shift($argv);
		$this->request 		= array_shift($argv);
		$this->return 		= array_pop($argv);
		$this->arguments 	= array(array_shift($argv)=>array_shift($argv));
	}

	public function getEndpoint() {
		return $this->endpoint;
	}

	public function getReturnType() {
		return $this->return;
	}

	public function getRequest() {
		return $this->request;
	}


	public function getArgument($position) {
		return $this->arguments[$position];
	}

	public function getArguments() {
		return $this->arguments;
	}
}
?>