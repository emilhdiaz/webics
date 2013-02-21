<?php
class SanitizeDate extends Object implements Sanitizer {

	public function sanitize( $date ) {
		if( is_numeric($date) )
			return date("Y-m-d H:i:s", $date);
		if( $date instanceof DateTime )
			return $date->format("Y-m-d H:i:s");
		if( is_string($date) )
			return date("Y-m-d H:i:s", strtotime($date));

		return '';
	}
}
?>