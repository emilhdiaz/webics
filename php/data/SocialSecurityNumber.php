<?php
class SocialSecurityNumber extends Integer {
	
	public static function validate( $ssn ) {
		$ssn = str_replace('-', '', $ssn);
		return parent::validate($ssn);
	}
	
}
?>