<?php
class Linux extends Object {
	
	public function __construct() {
		parent::__construct();
	}
	
	public static function initialize() {
		return self::getInstance();
	}
	
	public function getUser() {
		return $this->getVariable('USER');
	}
	
	public function getHome() {
		return $this->getVariable('HOME');
	}
	
	public function getVariable( $name ) {
		return getenv($name);
	}
}
?>