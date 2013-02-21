<?php
class SanitizeCurrency extends Object implements Sanitizer {

	public function sanitize( $currency ) {
		return number_format(preg_replace('/[^0-9\.,-]+/', '', $currency), 2);
	}
}
?>