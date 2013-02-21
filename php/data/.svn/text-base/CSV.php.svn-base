<?php
abstract class CSV extends Object {
	
	private static $delimiter = ';';
	
	public static function convert( Traversor $object ) {
		$csv = '';
		// single flat structures
		if( $object->structure() == "single" && !$object->isEmpty() ) {
			// associated structures so print the header
			if( is_associative($object) ) {
				$csv .= $object->keys()->join(self::$delimiter)."\n";
			}
			$csv .= $object->join(self::$delimiter)."\n";
		}
		// multi element structures
		else if( $object->structure() == "multi" && !$object->isEmpty() ) {
			if( is_associative($object->first()) ) {
				$csv .= $object->first()->keys()->join(self::$delimiter)."\n";
			}
			foreach( $object as $data ) {
				$csv .= $data->join(self::$delimiter)."\n";
			}
		}
		// mixed or unknown structures
		else {
			return false;
		}
		return $csv;
	}
}
?>