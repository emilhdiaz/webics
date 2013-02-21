<?php

class Integer extends Number {

	/**
	 * @var integer
	 */
	protected $number;
	const nativeType = 'integer';

	/************************
	 * 	   Magic Methods    *
	 ************************/

	/**
	 * __construct()
	 *
	 * Magic Method: Integer class constructor that accepts a native PHP
	 * integer or an Integer object.
	 *
	 * @param  Integer|integer	$integer - The integer
	 * @return Integer
	 */
	public function __construct( $integer ) {
		$integer = static::validate($integer);

		parent::__construct($integer);
	}

	/**
	 * int()
	 *
	 * Integer class native PHP integer representation to be
	 * used in integer operations by the PHP translator.
	 *
	 * @param  void
	 * @return integer
	 */
	public function int() {
		return $this->number;
	}

	/**
	 * add()
	 *
	 * Mathematical add operation.
	 *
	 * @param  Integer	$integer - The integer to add
	 * @return Integer
	 */
	public function add( Integer $integer ) {
		return parent::add($integer);
	}

	/**
	 * subtract()
	 *
	 * Mathematical subtract operation.
	 *
	 * @param  Integer 	$integer - The integer to subtract
	 * @return Integer
	 */
	public function subtract( Integer $integer ) {
		return parent::subtract($integer);
	}

	/**
	 * multiply()
	 *
	 * Mathematical multiply operation.
	 *
	 * @param  Integer	$integer - The integer to multiply
	 * @return Integer
	 */
	public function mutiply( Integer $integer ) {
		return parent::multiply($integer);
	}

	/**
	 * divide()
	 *
	 * Mathematical divide operation.
	 *
	 * @param  Integer 	$integer - The integer to divide by
	 * @return Integer
	 */
	public function divide( Integer $integer ) {
		return parent::divide($integer);
	}

	/**
	 * compare()
	 *
	 * Interger inequality comparision.
	 *
	 * @param  Integer 			$integer - The integer to compare to
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compare( Integer $integer ) {
		$threshold = new Integer(0);
		return parent::compare($integer, $threshold);
	}

	/**
	 * round()
	 *
	 * Round the float to the closest Integer
	 *
	 * @param  Integer	$precision - The precision to round to
	 * @return Integer
	 */
	public function round( Integer $precision ) {
		return parent::round($precision->absolute());
	}
	
	public static function validate( $integer ) {
		/* Check parameters */
		if( is_numeric($integer) )
			$integer = floor($integer);
			
		elseif( $integer instanceOf self )
			$integer = $integer->int();
			
		else 
			throw new InvalidTypeException($integer, "Integer");
			
		return (int) $integer;
	}
}
?>