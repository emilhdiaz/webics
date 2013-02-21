<?php
class ValidateIPv4 extends Object implements Validator {

	protected $type = FILTER_VALIDATE_IP;
	protected $flags = FILTER_FLAG_IPV4;
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>