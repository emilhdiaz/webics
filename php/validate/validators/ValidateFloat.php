<?php
class ValidateFloat extends Object implements Validator {

	protected $type = FILTER_VALIDATE_FLOAT;
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>