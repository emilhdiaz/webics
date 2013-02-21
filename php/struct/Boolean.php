<?php
class Boolean extends Object {

	/**
	 * @var bool
	 */
	private $boolean;
	const nativeType = 'boolean';

	/************************
	 * 	   Magic Methods    *
	 ************************/

	/**
	 * __construct()
	 *
	 * Magic Method: Boolean class constructor that accepts a native PHP
	 * boolean or an Boolean object.
	 *
	 * @param  Boolean|boolean	$boolean - The boolean
	 * @return Boolean
	 */
	public function __construct( $boolean ) {
		parent::__construct();
		
		$boolean = static::validate($boolean);

		$this->boolean = $boolean;

		return $this;
	}

	/**
	 * __destruct()
	 *
	 * Magic Method: Boolean class destructor that unsets the underlying
	 * native PHP string.
	 *
	 * @param  void
	 * @return void
	 */
	public function __destruct() {
		unset($this->boolean);
	}

	/**
	 * __toString()
	 *
	 * Magic Method: Boolean class native PHP string representation to be
	 * used in string operations by the PHP translator.
	 *
	 * @param  void
	 * @return string
	 */
	public function __toString() {
		return (string) $this->boolean ? 'true' : 'false';
	}
	
	public function toInteger() {
		return new Integer((int) $this->boolean);
	}

	/************************
	 * 	   	  Export 		*
	 ************************/

	/**
	 * bool()
	 *
	 * Boolean class native PHP boolean representation to be
	 * used in boolean operations by the PHP translator.
	 *
	 * @param  void
	 * @return boolean
	 */
	public function bool() {
		return (bool) $this->boolean;
	}
	
	public static function validate( $boolean ) {
		/* Check parameters */
		if( $boolean === true )
			$boolean = true;
			
		elseif( $boolean === '1' )
			$boolean = true;
			
		elseif( $boolean === 1 )
			$boolean = true;
			
		elseif( $boolean === 'y' )
			$boolean = true;
			
		elseif( $boolean === 'yes' )
			$boolean = true;
			
		elseif( $boolean === 'on' )
			$boolean = true;
			
		elseif( $boolean === 'true' )
			$boolean = true;		
		
		elseif( $boolean === false )
			$boolean = false;
			
		elseif( $boolean === '0' )
			$boolean = false;
			
		elseif( $boolean === 0 )
			$boolean = false;
			
		elseif( $boolean === 'n' )
			$boolean = false;
			
		elseif( $boolean === 'no' )
			$boolean = false;
			
		elseif( $boolean === 'off' )
			$boolean = false;
			
		elseif( $boolean === 'false' )
			$boolean = false;
			
		elseif( $boolean instanceOf self )
			$boolean = $boolean->bool();
			
		else
			throw new InvalidTypeException($boolean, 'Boolean');
			
		return (bool) $boolean;
	}
}
?>