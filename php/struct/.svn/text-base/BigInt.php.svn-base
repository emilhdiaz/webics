<?php
class BigInt extends Integer {
	
	const nativeType = 'double';
	
	public static function validate( $integer ) {
		/* Check parameters */
		if( is_numeric($integer) )
			$integer = floor($integer);
			
		elseif( $integer instanceOf self )
			$integer = $integer->int();
			
		else 
			throw new InvalidTypeException($integer, 'BigInt');
			
		return (float) $integer;
	}
}
?>