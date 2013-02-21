<?php
class FormatUSCurrency extends Object implements Formatter {

	public function format( $currency ) {
		return '$ '.number_format($currency, 2);
	}
}
?>