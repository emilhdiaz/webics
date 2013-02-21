<?php
class ValidateCreditCard extends Object implements Validator {

	protected $type = FILTER_VALIDATE_REGEXP;
	protected $options = array('regexp'=>'/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/');
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>