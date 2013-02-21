<?php
class Cache extends Hash {
	
	public function has($domain, $index) {
		if( !$this->hasKey($domain) )
			return false;
			
		if( !$this->$domain->hasKey($index) )
			return false;
			
		return true;
	}
	
	public function store( $domain, $index, Object $object ) {
		if( !$this->hasKey($domain) )
			$this->$domain  = new Hash();
			 
		$this->$domain->$index = $object;
	}
	
	public function retrieve( $domain, $index ) {
		if( !$this->hasKey($domain) )
			return null;
		
		if( !$this->$domain->hasKey($index) )
			return null;
			
		return $this->$domain->$index;
	}
	
	public function remove( $domain, $index ) {
		if( !$this->hasKey($domain) )
			return null;
			
		if( !$this->$domain->hasKey($index) )
			return null;
			
		return $this->$domain->remove($index);
	}
}
?>