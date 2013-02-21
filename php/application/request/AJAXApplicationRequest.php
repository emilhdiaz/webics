<?php
class AJAXApplicationRequest extends Object implements ApplicationRequest {

	public function getEndpoint() {
		return $_SERVER['REQUEST_URI'];
	}

	public function getReturnType() {
		return $_REQUEST['return'];
	}

	public function getRequest() {
		return $_REQUEST['request'];
	}

	public function getArgument($name) {
		return $_REQUEST['arguments'][$name];
	}

	public function getArguments() {
		return $_REQUEST['arguments'];
	}
}
?>