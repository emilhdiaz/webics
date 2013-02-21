<?php
enum('E_Comparison',
	array(
		'LESS_THAN',
		'EQUAL_TO',
		'GREATER_THAN'
	)
);

abstract class Number extends Object {

	protected $number;

	/**
	 * __construct()
	 *
	 * Magic Method: Number class constructor that accepts a native PHP
	 * number or an Number object.
	 *
	 * @param  Number|number	$number - The number
	 * @return Number
	 */
	public function __construct( $number ) {

		/* Check parameters */
		if( !is_numeric($number) )
			throw new InvalidTypeException($number, 'Number');

		/* Load parent */
		parent::__construct();

		/* Convert to native number if a Number object */
		//$string = (string) $this->nativeString($string);

		$this->number = $number;

		return $this;
	}

	/**
	 * __destruct()
	 *
	 * Magic Method: Number class destructor that unsets the underlying
	 * native PHP number.
	 *
	 * @param  void
	 * @return void
	 */
	public function __destruct() {
		unset($this->number);
	}

	/**
	 * __toString()
	 *
	 * Magic Method: Number class native PHP string representation to be
	 * used in string operations by the PHP translator.
	 *
	 * @param  void
	 * @return string
	 */
	public function __toString() {
		return (string) $this->number;
	}

	/**
	 * add()
	 *
	 * Mathematical add operation.
	 *
	 * @param  Number	$number - The number to add
	 * @return Number
	 */
	public function add( Number $number ) {
		$this->number += $number->int();
		return $this;
	}

	/**
	 * subtract()
	 *
	 * Mathematical subtract operation.
	 *
	 * @param  Number 	$number - The number to subtract
	 * @return Number
	 */
	public function subtract( Number $number ) {
		$this->number -= $number->int();
		return $this;
	}

	/**
	 * multiply()
	 *
	 * Mathematical multiply operation.
	 * @param  Number	$number - The number to multiply
	 * @return Number
	 */
	public function multiply( Number $number ) {
		$this->number *= $number->int();
		return $this;
	}

	/**
	 * divide()
	 *
	 * Mathematical divide operation.
	 * @param  Number 	$number - The number to divide by
	 * @return Number
	 */
	public function divide( Number $number ) {
		$this->number /= $number->int();
		return $this;
	}

	/**
	 * negate()
	 *
	 * Negate the number (multiply by -1)
	 *
	 * @param  void
	 * @return Number
	 */
	public function negate() {
		$this->number *= -1;
		return $this;
	}

	/**
	 * absolute()
	 *
	 * Absolute value of the number.
	 *
	 * @param  void
	 * @return Number
	 */
	public function absolute() {
		$this->number = abs($this->number);
		return $this;
	}

	/**
	 * isZero()
	 *
	 * Check if the number is zero.
	 *
	 * @param  void
	 * @return Boolean
	 */
	public function isZero() {
		return $this->number ? new Boolean(false) : new Boolean(true);
	}

	/**
	 * compare()
	 *
	 * Number inequality comparision.
	 * @param  Number 			$number - The number to compare to
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compare( Number $number, Number $threshold ) {
		$diff = abs($this->number - $number->int());

		if( $diff <= $threshold )
			return E_Comparison::EQUAL_TO();
		elseif( $this->number < $number->int() )
			return E_Comparison::LESS_THAN();
		elseif( $this->number > $number->int() )
			return E_Comparison::GREATER_THAN();
		else
			throw new LogicException();
	}

	/**
	 * round()
	 *
	 * Round the float to the closest Integer
	 *
	 * @param  Integer	$precision - The precision to round to
	 * @return Number
	 */
	public function round( Integer $precision ) {
		$this->number = round($this->number, $precision);
		return $this;
	}

}
?>