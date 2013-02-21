<?php
class DAOEntityMethodReflector extends MethodReflector {

	private $calling_class;
	
	public function __construct( $class, $method ) {
		parent::__construct($class,$method);
		$this->calling_class = $class;
	}
	
	public function getParameterTypes() {
		switch( $this->getName() ) {
			case 'find':
				return $this->getFindParameterTypes();
				break;
			case 'load':
				return $this->getKeyParameterTypes();
				break;
			case 'exists':
				return $this->getKeyParameterTypes();
				break;
			case 'create':
				return $this->getCreateParameterTypes();
				break;
			case 'update':
				return $this->getUpdateParameterTypes();
				break;
			case 'remove':
				return $this->getKeyParameterTypes();
				break;
			default: 
				$parameters = array();
				foreach( $this->getParameters() as $parameter ) {
					$parameters[$parameter->getName()] = $parameter->getType();
				}
				return $parameters;
				break;
		}
	}
	
	private function getFindParameterTypes() {
		$parameters = array();
		$properties = array();
		foreach( $this->getClass()->getProperties() as  $property ) {
			$properties[$property->getName()] = $property->getType();
		}
		$parameters['properties'] = $properties;
		$parameters['full_text_search'] = 'Boolean'; 
		return $parameters;
	}
	
	private function getCreateParameterTypes() {
		$parameters = array();
		$properties = array();
		foreach( $this->getClass()->getProperties() as $property ) {
			#TODO: should also remove alias properties
			
			if( $property->hasAnnotation('readonly') )
				continue;

			if( $property->hasAnnotation('internal') )
				continue;
								
//			if( $property->getAnnotation('default') == '*' )
//				continue;
				
			if( $property->getAnnotation('key') == 'auto' )
				continue;
				
			$properties[$property->getName()] = $property->getType();
		}
		$parameters['properties'] = $properties;
		return $parameters;
	}
	
	private function getUpdateParameterTypes() {
		$parameters = array();
		$key = array();
		$properties = array();
		foreach( $this->getClass()->getProperties() as $property ) {
			#TODO: should also remove alias properties
			
			if( $property->hasAnnotation('readonly') )
				continue;
				
			if( $property->hasAnnotation('internal') )
				continue;
								
			if( $property->hasAnnotation('constant') )
				continue;

			if( $property->hasAnnotation('key') ) {
				$key[$property->getName()] = $property->getType();
				continue;
			}
				
			$properties[$property->getName()] = $property->getType();
		}
		$parameters['key'] = count($key) == 1 ? array_pop($key) : $key;
		$parameters['properties'] = $properties;
		return $parameters;
	}
	
	private function getKeyParameterTypes() {
		$parameters = array();
		$key = array();
		foreach( $this->getClass()->getProperties() as $property ) {
			if( $property->hasAnnotation('key') )
				$key[$property->getName()] = $property->getType();
		}
		$parameters['key'] = count($key) == 1 ? array_pop($key) : $key;;
		return $parameters;
	}

	public function getClass() {
		return new DAOEntityReflector($this->calling_class);
	}
	
	public function getDeclaringClass() {
		return new DAOEntityReflector(parent::getDeclaringClass()->getName());
	}
	
}
?>