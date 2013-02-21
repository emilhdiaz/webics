<?php
class UserCredentials extends Object {

	private $iHave;
	private $iKnow;

	public function __construct( $iHave, $iKnow ) {
		parent::__construct();
		$this->iHave = $iHave;
		$this->iKnow = $iKnow;
	}

	public function iHave() {
		return $this->iHave;
	}

	public function iKnow() {
		return $this->iKnow;
	}
}
?>