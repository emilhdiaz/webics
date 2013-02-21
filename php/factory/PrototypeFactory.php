<?php
class PrototypeFactory {
	
	private static $prototypes = array();
	
	final private function __construct() {
		 
	}

	final static protected function register( $name, Object $obj ) {
		self::$prototypes[$name] = $obj;
	}
	
	final static protected function create( $name ) {
		if ( !isset(self::$prototypes[$name]) ) 
			throw new PrototypeFactoryException("No prototype found for: ".$name);
		return clone self::$prototypes[$name];
	}
}
?>