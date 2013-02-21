<?php
class FormatDate extends Object implements Formatter {

	public function format( $date ) {
		if( is_numeric($date) )
			return date("F j, Y, g:i a", $date);
		if( $date instanceOf DateTime )
			return $date->format("F j, Y, g:i a");
		if( is_string($date) )
			return date("F j, Y, g:i a", strtotime($date));

		return '';
	}
}
?>