<?php
class DependencySorter extends VArray {
	
	private $objects; 
	private $sorted;
	private $dependencies; 
	
	public function __construct( VArray $objects ) {
		$this->objects = $objects;
		$this->sorted = new VArray(); 
		$this->dependencies = new Hash();
		
		foreach($objects as $object) {
			$this->dependencies[$object] = $object::dependencies();
		}
	}
	
	public function sort() {
		foreach( $this->dependencies as $entity => $dependencies ) {
			$this->sorter($entity);
		}
		$this->var = $this->sorted->arr();
		return $this->sorted;
	}
	
	public function sorter( $entity ) {
		static $trip = 1;
		$trip = $trip + 1;
		
		if($trip >= 1000) 
			throw new FatalRuntimeException('Please check your DAOEntity models for reflection recursion');
		
		// avoid repetition 
		if( $this->sorted->hasValue($entity) ) return;
		
		foreach( $this->dependencies[$entity] as $dependency ) {
			// avoid infinite recursion due to entities pointing to one another
			if( $dependency == $entity ) continue;
			
			// resove dependencies
			if( !$this->sorted->hasValue($dependency) ) $this->sorter($dependency);
		}
		
		if( !$this->sorted->hasValue($entity) ) $this->sorted->pushBack($entity);
	}
}
?>