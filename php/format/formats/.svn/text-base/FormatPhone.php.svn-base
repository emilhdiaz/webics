<?php
class FormatPhone extends Object implements Formatter {

	public function format( $phone ) {
		$sec1 = substr($phone, -4);
		$sec2 = substr($phone, -7, 3);
		$sec3 = substr($phone, -10, 3);

		$phone = '';
		if( empty($sec1) ) return $phone;
		$phone = $sec1;

		if( empty($sec2) ) return $phone;
		$phone = $sec2.'-'.$phone;

		if( empty($sec3) ) return $phone;
		$phone = '('.$sec3.') '.$phone;

		return $phone;
	}
}
?>