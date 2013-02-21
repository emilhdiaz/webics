<?php
class Money extends Float {

	private $currency;

	public function __construct( $money, $currency = 'USD' ) {
		$this->currency = $currency;
		parent::__construct($money);
	}

	public function __toString() {
		switch($this->currency) {
			case 'USD':
				$money = "$".number_format($this->number, 2, ".", ",");
				break;

			case 'EUR':
				$money = "€".number_format($this->number, 2, ",", ".");
				break;

			case 'GBP':
				$money = "£".number_format($this->number, 2, ",", ".");
		}
		return $money;
	}

}
?>