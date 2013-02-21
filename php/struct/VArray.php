<?php
class VArray extends Traversor {

	/**
	 * @var VArray
	 */
	protected $var = array();

	/**
	 * The OrderedArray will store any structure that implements
	 * the Iterator Interface in a natural PHP numbered array.
	 * The constructor will ignore any keys in the source structure.
	 */
	public function __construct( $array = null ) {
		$array = static::validate($array);

		foreach($array as $value) {
			$this->var[] = $value;
		}
	}

    /**
     * VArray values by key. To access numeric
     * keys enclose the number with brackets{}.
     *
     * @magic
     * @param  scalar $key
     * @param  mixed $value
     * @access public
     */
	final public function __set( $key, $value ) {
		if( !is_numeric($key) ) throw new InvalidTypeException($key, 'integer');
    	if( !$this->hasKey($key) ) throw new InvalidIndexException($key);
    	$this->var[$key] = $value;
    }
    
	public function __toString() {
		return '('.implode(', ',$this->var).')';
	}    

	/**
	 * The OrderedArray will store any structure that implements
	 * the Iterator Interface in a natural PHP numbered array.
	 * The constructor will ignore any keys in the source structure.
	 */
	final public function import( $array = null ) {
		if( is_null($array) ) $array = func_get_args();
		
		$array = static::validate($array);
		
		foreach($array as $value) {
			$this->var[] = $value;
		}
	}

	/**
	 * Maps the values in this array to a Hash by treating the values
	 * as the corresponding keys in the Hash.
	 *
	 * @param $hash
	 * @return unknown_type
	 */
	final public function map( Hash $hash ) {
		$map = new self;
		foreach( $this->var as $element ) {
			if( $hash->hasKey($element) )
				$map->pushBack( $hash->$element);
		}
		return $map;
	}

	/**
	 * Reorders the array resetting the keys.
	 *
	 * @final
	 * @access public
	 * @param  void
	 * @return void
	 */
	final public function order() {
		$this->var = array_values($this->var);
	}

	/**
	 * Removes duplicate values from the array
	 * and maintains order and continuity.
	 *
	 * @access public
	 * @param  void
	 * @return void
	 */
	final public function unique() {
		parent::unique();
		$this->order();
	}

	/**
	 * Reverse the order of the array and maintain continuity.
	 *
	 * @access public
	 * @param  void
	 * @return VArray
	 */
	final public function reverse() {
		parent::reverse();
		$this->order();
		return $this;
	}

	/**
	 * Sort the data in a case-insensitive natural order
	 * and maintains order and continuity.
	 *
	 * @access public
	 * @param  void
	 * @return void
	 */
	public function sort() {
		parent::sort();
		$this->order();
	}

	/**
	 * Remove the element at the specified key
	 * and maintain order and continuity.
	 *
	 * @access public
	 * @param  scalar $key
	 * @return void
	 */
	final public function remove( $key ) {
		parent::remove($key);
		$this->order();
	}

	/**
	 * Merge the Meragable Object into this structure.
	 * Duplicate keys are not a concern because this is
	 * a numeric array and all values will be appended.
	 *
	 * @param  Mergable $object
	 * @return void
	 * @access public
	 */
	final public function merge( Mergable $var ) {
		$var = static::validate($var);
		$this->var = array_merge($this->var, (array) $var);
	}

	/**
	 * Add and element to the front of the array.
	 *
	 * @access public
	 * @param  mixed
	 * @return void
	 */
	final public function pushFront( $var ) {
		array_unshift($this->var, $var);
	}

	/**
	 * Add and element to the end of the array.
	 *
	 * @access public
	 * @param  mixed
	 * @return void
	 */
	final public function pushBack( $var ) {
		array_push($this->var, $var);
	}

	/**
	 * Remove the element at the front of the array.
	 *
	 * @access public
	 * @param  void
	 * @return mixed
	 */
	final public function popFront() {
		return array_shift($this->var);
	}

	/**
	 * Remove the element at the back of the array.
	 *
	 * @access public
	 * @param  void
	 * @return mixed
	 */
	final public function popBack() {
		return array_pop($this->var);
	}

    /**
     * Shuffle the array and reorder.
     *
     * @access public
     * @param  void
     * @return void
     * @access public
	 */
    final public function shuffle() {
    	shuffle($this->var);
    }

    /**
     * Generate an array filled with a range of
     * alphanumeric values.
     *
     * @access public
     * @param  scalar  $low
     * @param  scalar  $high
     * @param  integer $step
     * @return void
	 */
    final public function range( $low, $high, $step = 1 ) {
    	$this->var = range($low, $high, $step);
    }

    /**
     * Fill the existing array with the given value
     *
     * @param  scalar  $value
     * @access public
	 */
    final public function fill( $value ) {
    	$this->var = array_fill(0, $this->size(), $value);
    }
    
    /**
     * Add the value to array if it doesnt exists
     */
    final public function contain( $value ) {
    	if( !$this->hasValue($value) ) $this->var[] = $value;
    }

    /**
     * Add padding to left or right of the array
     * and maintain order and continuity.
     *
     * @param  int $size
     * @param  var $value
     * @access public
	 */
    final public function pad( $size, $value ) {
    	$this->var = array_pad($this->var, $size, $value);
    }

    /**
     * Return a slice of the array, given an offset and a length.
     * If offset is negetive the sequence will start from the end.
     * If length is omitted then everything from offset on will be
     * returned. The keys of the returned array are reordered
     *
     * @param  integer $offset
     * @param  integer $length default NULL
     * @return self
     * @access public
	 */
    final public function slice( $offset, $length = NULL ) {
    	return new self(array_slice($this->var, $offset, $length));
    }

    /**
     * Splice (delete, replace, or insert into) a section of the array.
     * If offset is negetive the sequence will start from the end.
     * If length is omitted then removes everything from offset on.
     * If replacement array is specified then sections are replaced.
     * Returns the number of replaced elements
     *
     * @param  integer $offset
     * @param  integer $length
     * @param  self	   $replacement
     * @return integer
     * @access public
	 */
    final public function splice( $offset, $length = NULL, self $replacement = NULL) {
      	return array_splice($this->var, $offset, $length, $replacement);
    }
    
    public function each( Closure $closure ) {
    	foreach( $this->var as $element ) {
    		$closure($element);
    	}
    }
    
	public static function validate( $array ) {
		/* Check parameters */
		if( is_array($array) )
			$array = $array;
			
		elseif( is_null($array) )
			$array = array();
			
		elseif( $array instanceOf Iterable )
			$array = $array->__toArray();
			
		else
			$array = array($array); 
			
		return (array) $array;
	}
}
?>