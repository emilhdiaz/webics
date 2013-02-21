<?php
class Windows extends Object {
	
	public function __construct() {
		parent::__construct();
	}
	
	public static function initialize() {
		return self::getInstance();
	}
	
	public function getVariable( $name ) {
		return system("echo %$name%");
	}
}
?>