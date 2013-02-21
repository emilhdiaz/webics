<?php

class Float extends Number {

	/**
	 * @var float
	 */
	protected $number;
	const nativeType = 'double';

	/************************
	 * 	   Magic Methods    *
	 ************************/

	/**
	 * __construct()
	 *
	 * Magic Method: Float class constructor that accepts a native PHP
	 * float or an Float object.
	 *
	 * @param  Float|float	$float - The float
	 * @return Float
	 */
	public function __construct( $float ) {
		$float = static::validate($float);

		parent::__construct($float);
	}

	/**
	 * float()
	 *
	 * Float class native PHP float representation to be
	 * used in float operations by the PHP translator.
	 *
	 * @param  void
	 * @return float
	 */
	public function float() {
		return (float) $this->number;
	}

	/**
	 * add()
	 *
	 * Mathematical add operation.
	 *
	 * @param  Float	$float - The float to add
	 * @return Float
	 */
	public function add( Float $float ) {
		return parent::add($float);
	}

	/**
	 * subtract()
	 *
	 * Mathematical subtract operation.
	 *
	 * @param  Float 	$float - The float to subtract
	 * @return Float
	 */
	public function subtract( Float $float ) {
		return parent::subtract($float);
	}

	/**
	 * multiply()
	 *
	 * Mathematical multiply operation.
	 *
	 * @param  Float	$float - The float to multiply
	 * @return Float
	 */
	public function mutiply( Float $float ) {
		return parent::multiply($float);
	}

	/**
	 * divide()
	 *
	 * Mathematical divide operation.
	 *
	 * @param  Float 	$float - The float to divide by
	 * @return Float
	 */
	public function divide( Float $float ) {
		return parent::divide($float);
	}

	/**
	 * compare()
	 *
	 * Float inequality comparision.
	 *
	 * @param  Float 	$float - The float to compare to
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compare( Float $float ) {
		$threshold = new Float(0.00001);
		return parent::compare($float, $threshold);
	}

	/**
	 * ceiling()
	 *
	 * Round up the float to the ceiling Integer
	 *
	 * @param  void
	 * @return Integer
	 */
	public function ceiling() {
		return new Integer( (int) ceil($this->number) );
	}

	/**
	 * floor()
	 *
	 * Round down the float to the floor Integer
	 *
	 * @param  void
	 * @return Integer
	 */
	public function floor() {
		return new Integer( (int) floor($this->number) );
	}
	
	public static function validate( $float ) {
		/* Check parameters */
		if( is_numeric($float) )
			$float =  $float;
			
		elseif( $float instanceOf self )
			$float = $float->float();
			
		else
			throw new InvalidTypeException($float, 'Float');
		
		return (float) $float;
	}
}
?>