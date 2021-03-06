<?php
/*
 * Traversor uses the Adapter Pattern to provide a
 * unified interface to PHP's array functions. All functions
 * declared in this class must preserve array keys.
 */
abstract class Traversor extends Object implements Iterable, Iterator, ArrayAccess {

	protected $var = array();
	const nativeType = 'array';

	/**
	 * The Traversor will store any structure that implements
	 * the Iterator Interface in a natural PHP associated array.
	 *
	 * @param  Iterator $struct
	 * @return self
	 * @access public
	 */
	public function __construct( $struct = null ) {
		parent::__construct();
		
		$struct = static::validate($struct);

		foreach($struct as $key => $value ) {
			$this->var[$key] = $value;
		}
	}

    /**
     * Get values by key. To access numeric
     * keys enclose the number with brackets{}.
     *
     * @magic
     * @param  scalar $key
     * @return mixed
     * @access public
     */
    public function __get( $key ) {
    	if( !$this->hasKey($key) ) throw new InvalidIndexException($key);
    	return $this->var[$key];
    }

    /**
     * Set values by key. To access numeric
     * keys enclose the number with brackets{}.
     *
     * @magic
     * @param  scalar $key
     * @param  mixed $value
     * @access public
     */
	public function __set( $key, $value ) {
    	$this->var[$key] = $value;
    }

	public function __isset( $name ) {
		return isset($this->var[$name]);
	}

    public function __clone() {
    	foreach( $this->var as &$element ) {
    		if( is_object($element) )
    			$element = clone $element;
    		else
    			$element = $element;
    	}
    }

    public function __toString() {
    	$array = array();
		foreach( $this->var as $key=>$var ) {
			$array[] = $key.' = '.$var;
		}
		return '('.implode(', ',$array).')';
    }

    public function __toArray() {
    	$elements = array();
    	foreach( $this->var as $key => &$element ) {
    		if( $element instanceOf Iterable ) {
    			$elements[$key] = $element->__toArray();
    		}
    		else
    			$elements[$key] = $element;
    	}
    	return $elements;
    }

	public function __toVArray() {
		return new VArray(array_values($this->var));
	}

	public function __toHash() {
		return new Hash($this->var);
	}
	
    public function get( $key, $default = null ) {
    	return $this->hasKey($key) ? $this->var[$key] : $default;
    }
	
    public function iterator() {
    	$iterator = new static;
    	foreach( $this->var as $key => $element ) {
    		if( $element instanceOf Iterable ) {
    			$iterator->$key = $element->iterator();
    		}
    		else
    			$iterator->$key = $element;
    	}
    	return $iterator;
    }
    	
	/**
     * Return the natural PHP associated array representation of the
     * stored data.
     *
     * @param  void
     * @return array
     * @access public
	 */
    public function arr() {
		return $this->var;
    }

    /**
     * Return the values of the array.
     *
     * @param  void
     * @return self
     * @access public
     */
    public function values() {
    	return new VArray(array_values($this->var));
    }

    /**
     * Return the keys of the array.
     *
     * @param  void
     * @return self
     * @access public
     */
    public function keys() {
    	return new VArray(array_keys($this->var));
    }

    /**
     * Return the current value.
     *
     * @param  void
     * @return mixed
     * @access public
	 */
    public function &current() {
        return current($this->var);
    }

    /**
     * Return the key of the current value.
     *
     * @param  void
     * @return scalar
     * @access public
	 */
    public function key() {
        return key($this->var);
    }

    /**
     * Return the first element of the array.
     *
     * @param  void
     * @return mixed
     * @access public
	 */
    public function &first() {
    	return reset($this->var);
    }

    /**
     * Return the last element of the array.
     *
     * @param  void
     * @return mixed
     * @access public
	 */
    public function &last() {
    	return end($this->var);
    }

    /**
     * Return the next element of the array.
     *
     * @param  void
     * @return mixed
     * @access public
	 */
    public function &next() {
        return next($this->var);
    }

    /**
     * Return the previous element of the array.
     *
     * @param  void
     * @return mixed
     * @access public
	 */
    public function &prev() {
    	return prev($this->var);
    }

    /**
     * Check if the pointer is not out of bounds.
     *
     * @param  void
     * @return boolean
     * @access public
	 */
    public function valid() {
        return $var = $this->current() !== false;
    }

    /**
     * Reset the array pointer.
     *
     * @param  void
     * @return void
     * @access public
	 */
    public function rewind() {
        reset($this->var);
    }

    public function offsetExists( $offset ) {
    	return isset( $this->var[$offset] );
    }

    public function offsetSet( $offset, $value) {
    	if( $offset )
    		$this->var[$offset] = $value;
    	else 
    		$this->var[] = $value;
    }

    public function offsetGet( $offset ) {
    	return $this->var[$offset];
    }

    public function offsetUnset( $offset ) {
    	unset( $this->var[$offset] );
    }

    /**
     * Return a random element from the array.
     *
     * @param  void
     * @return mixed
     * @access public
	 */
    public function random() {
    	return $this->var[array_rand($this->var)];
    }

    /**
     * Return the number of elements in the array.
     *
     * @param  void
     * @return integer
     * @access public
	 */
    public function size() {
    	return count($this->var);
    }

	/**
     * Check if a value exist.
     *
     * @param  mixed $value
     * @return boolean
     * @access public
	 */
    public function hasValue( $value ) {
    	return in_array($value, $this->var);
    }

    /**
     * Check if a key exist.
     *
     * @param  scalar $key
     * @return boolean
     * @access public
	 */
    public function hasKey( $key ) {
    	return array_key_exists($key, $this->var);
    }

    /**
     * Determines the structure of the data set
     *
     * @return string
     * @access public
     */
    public function structure() {
    	$structure = null;
    	foreach( $this->var as $element ) {
    		if( (is_array($element) || $element instanceOf Iterable) )
    			if( $structure == 'single')
    				$structure = 'mixed';
    			else
    				$structure = 'multi';
    		else
    		    if( $structure == 'multi')
    				$structure = 'mixed';
    			else
    				$structure = 'single';
    	}
    	return $structure;
    }

    /**
     * Implodes the values of the data set into a string
     * using a delimiter.
     *
     * @param  string $delimiter
     * @return string
     * @access public
     */
    public function join( $delimiter ) {
    	return new String(implode($delimiter, $this->var));
    }

    /**
     * Return the key found using a value.
     *
     * @param  mixed $value
     * @return scalar
     * @access public
	 */
    public function search( $value ) {
    	if ( !($key = array_search($value, $this->var)) )
    		return -1;
   		return $key;
    }

    /**
     * Remove duplicate values from the array.
     * Will compare object states.
     *
     * @param  void
     * @return void
     * @access public
	 */
    public function unique() {
    	$this->var = array_unique($this->var);
    }
    
    public function prefix( $prefix ) {
    	$this->var = array_prefix_values($prefix, $this->var);
    	return $this;
    }
    
    public function postfix( $postfix ) {
    	$this->var = array_postfix_values($postfix, $this->var);
    	return $this;
    }

    /**
     * Clears the contents of the array.
     *
     * @param  void
     * @return void
     * @access public
	 */
    public function clear() {
    	$this->var = array();
    }

    /**
     * Check to see if the array is empty
     *
     * @param  void
     * @return boolean
     * @access public
	 */
    public function isEmpty() {
    	return empty($this->var);
    }

    /**
	 * Return chunks of the same size of this array.
	 *
	 * @param  integer $size
	 * @return self
	 * @access public
	 */
    public function chunk( $size ) {
    	foreach(array_chunk($this->var, $size, true) as $value) {
    		$var[] = new $class($value);
    	}
    	return static::getClass()->newInstance($var);
    }

    /**
     * Reverse the order of the array.
     *
     * @param  void
     * @return ArraDataStructure
     * @access public
     */
	public function reverse() {
    	$this->var = array_reverse($this->var, true);
    	return $this;
	}

	/**
	 * Sort the data in a case-insensitive natural order.
	 *
	 * @param  void
	 * @return void
	 * @access public
	 */
    public function sort() {
    	natcasesort($this->var);
    }

	/**
	 * Remove the element at the specified key.
	 *
	 * @param  scalar $key
	 * @return void
	 * @access public
	 */
	public function remove( $key ) {
		$var = $this->var[$key];
		unset($this->var[$key]);
		return $var;
	}

    /**
     * Change the case of the keys.
     * Accepts CASE_LOWER or CASE_UPPER
     *
     * @param  constant $case
     * @return void
     * @access public
	 */
    public function keyCase( $case = CASE_LOWER ) {
    	$this->var = array_change_key_case($this->var, $case);
    }

	/**
	 * Merge the Mergable object into this structure.
	 * This duplicate keys result in data being preserved
	 * by this object and ignored from the source object.
	 *
	 * @param  Mergable $object
	 * @return void
	 * @access public
	 */
	public function merge( Iterable $var ) {
		$var = static::validate($var);
		foreach( $var as $key=>$value ) {
			if( $this->hasKey($key) &&
				$value instanceOf Iterable &&
				$this->var[$key] instanceOf Iterable ) {
				$this->var[$key]->merge($value);
			}
		}
		$this->var = array_merge($this->var, $var);
		return $this;
	}

    /**
     * Return a slice of the array, given an offset and a length.
     * If offset is negetive the sequence will start from the end.
     * If length is omitted then returns everything from offset on.
     * The keys of the returned array are preserved
     *
     * @param  integer $offset
     * @param  integer $length default NULL
     * @return self
     * @access public
	 */
    public function slice( $offset, $length = NULL ) {
    	return static::getClass()->newInstance(array_slice($this->var, $offset, $length, true));
    }

    /**
     * Splice (delete only) a section of the array.
     * If offset is negetive the sequence will start from the end.
     * If length is omitted then removes everything from offset on.
     * Returns the number of deleted elements
     *
     * @param  integer $offset
     * @param  integer $length
     * @param  self	   $replacement
     * @return integer
     * @access public
	 */
    public function splice( $offset, $length = NULL ) {
      	return array_splice($this->var, $offset, $length);
    }
    

    /**
     * Generate an associated array using a fill
     * value from start index for a certain length
     * of elements
     *
     * @param  integer $start
     * @param  integer $length
     * @param  scalar  $value
     * @access public
	 */
	abstract public function fill( $value );
	    
    abstract public function each( Closure $closure );
    
   	public static function validate( $array ) {
		/* Check parameters */
		if( is_array($array) )
			$array = $array;
			
		elseif( is_null($array) )
			$array = array();
			
		elseif( $array instanceOf Iterable )
			$array = $array->__toArray();
			
		else
			throw new InvalidTypeException($array, 'Array'); 
			
		return (array) $array;
	}
}
?>