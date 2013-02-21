<?php
class ValidateDate extends Object implements Validator {

	protected $type = FILTER_VALIDATE_REGEXP;
	protected $options = array('regexp'=>'/^3[47][0-9]{13}$/');

	public function validate( $date ) {
		if( $date instanceof DateTime )
			return true;

		return (bool) strtotime($date);
	}
}
?>