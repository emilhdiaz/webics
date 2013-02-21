<?php
class Char extends String {
	
	public static function validate( $string ) {
		/* Check parameters */
		if( is_string($string) )
			$string = $string;
			
		elseif( is_null($string) )
			$string = '';
			
		elseif( $string instanceOf self )
			$string = $string->str();
			
		else
			throw new InvalidTypeException($string, 'String');
			
		if( strlen($string) > 1 )
			throw new InvalidTypeException($string, 'Char');
			
		return (string) $string;
	}
}
?>