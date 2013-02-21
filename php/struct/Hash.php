<?php
class Hash extends Traversor {

	/**
	 * @var Hash
	 */
	protected $var = array();
    
    /**
     * Fill the existing array with the given value
     *
     * @param  scalar  $value
     * @access public
	 */
    public function fill( $value ) {
    	$this->var = array_fill_keys($this->keys()->arr(), $value);
    }

    /**
     * Generate an associated array from an
     * array of keys and an array of values
     */
    public function combine( array $keys, array $values ) {
    	$this->var = array_combine($keys, $values);
    }
    
    public function join( $delimiter, $assignment ) {
    	$array = array();
		foreach( $this->var as $key=>$var ) {
			$array[] = "$key $assignment $var";
		}
		return implode($delimiter,$array);
    }
    
    public function each( Closure $closure ) {
    	foreach( $this->var as $key=>$element ) {
    		$closure($element,$key);
    	}
    }
    
    public function prefixKeys( $prefix ) {
    	$this->var = array_prefix_keys($prefix, $this->var);
    	return $this;
    }
    
    public function postfixKeys( $postfix ) {
    	$this->var = array_unprefix_keys($postfix, $this->var);
    	return $this;
    }

}
?>