<?php
class CustomStatement extends DatabaseStatement {

	private $customSQL;
	
	public function __construct( String $customSQL ) {
		$this->customSQL = $customSQL;
	}
	
	public function sql() {
		return $this->customSQL;
	}
}
?>