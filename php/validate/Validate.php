<?php
class Validate extends Object {

	private static $validators = array();

	final static public function register( $name, Validator $validator ) {
		self::$validators[$name] = $validator;
	}

	final static public function apply( $name, $value ) {
		if ( !isset(self::$validators[$name]) )
			throw new ValidateException("No registered validator found for '$name'.");
		else if ( !self::$validators[$name]->validate($value) )
			throw new ValidateException("Value '$value' failed validation for '$name'.");
		else
			return true;
	}
}
?>