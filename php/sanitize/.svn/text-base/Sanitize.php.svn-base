<?php
class Sanitize extends Object {

	private static $sanitizers = array();

	final static public function register( $name, Sanitizer $sanitizer ) {
		self::$sanitizers[$name] = $sanitizer;
	}

	final static public function apply( $name, $value ) {
		if ( !isset(self::$sanitizers[$name]) )
			throw new SanitizeException("No registered sanitizer found for '$name'.");
		else
			return self::$sanitizers[$name]->sanitize($value);
	}
}
?>