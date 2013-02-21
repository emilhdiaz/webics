<?php
class ValidateCurrency extends Object implements Validator {

	protected $type = FILTER_VALIDATE_REGEXP;
	protected $options = array('regexp'=>'/^[0-9]{1,3}(?:,?[0-9]{3})*\.[0-9]{2}$/');
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>