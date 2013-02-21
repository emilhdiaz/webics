<?php
class Timestamp extends Object {

	const nativeType = 'string';
	private $datetime; 
	
	public function __construct( $timestamp = "now", DateTimeZone $timezone = NULL ) {
		parent::construct();
		
		$timestamp = static::validate($timestamp);
		
		/* Load parent */
		if( is_null($timezone) )
			$this->datetime = new DateTime($timestamp);
		else 
			$this->datetime = new DateTime($timestamp, $timezone);
	}
	
	public function __call( $name, $argument ) {
		return call_user_func_array( array($this->datetime, $name), $arguments);
	}
	
	public static function __callStatic( $name, $arguments ) {
		return forward_static_call_array( array('DateTime', $name), $arguments);
	}
	
	public function __toString() {
		return $this->datetime->format("F j, Y, g:i a");
	}
	
	public static function validate( $timestamp ) {
		/* Check parameters */
		if( is_string($timestamp) )
			$timestamp = $timestamp;
			
		elseif( $timestamp instanceOf self )
			$timestamp = $timestamp->format("F j, Y, g:i a");
			
		else 
			throw new InvalidTypeException($timestamp, 'Timestamp');
			
		return (string) $timestamp;
		
	}
}
?>