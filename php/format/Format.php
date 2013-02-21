<?php
class Format extends Object {

	private static $formatters = array();

	final static public function register( $name, Formatter $formatter ) {
		self::$formatters[$name] = $formatter;
	}

	final static public function apply( $name, $value ) {
		if ( !isset(self::$formatters[$name]) )
			throw new FormatException("No registered formatter found for '$name'.");
		else
			return self::$formatters[$name]->format($value);
	}
}
?>