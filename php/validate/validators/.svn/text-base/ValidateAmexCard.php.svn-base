<?php
class ValidatorAmexCard extends Object implements Validator {

	protected $type = FILTER_VALIDATE_REGEXP;
	protected $options = array('regexp'=>'/^3[47][0-9]{13}$/');
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>