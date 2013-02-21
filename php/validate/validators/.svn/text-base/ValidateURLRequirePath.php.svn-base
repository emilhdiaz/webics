<?php
class ValidateURLRequirePath extends Object implements Validator {

	protected $type = FILTER_VALIDATE_URL;
	protected $flags = FILTER_FLAG_PATH_REQUIRED;
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>