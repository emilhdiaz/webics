<?php
class ValidateMastercard extends Object implements Validator {

	protected $type = FILTER_VALIDATE_REGEXP;
	protected $options = array('regexp'=>'/^5[1-5][0-9]{14}$/');
	
	public function validate( $value ) {
		return filter_var($value,$this->type, array("options"=>$this->options, "flags"=>$this->flags));
	}
}
?>