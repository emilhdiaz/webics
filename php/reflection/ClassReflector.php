<?php
class ClassReflector extends ReflectionClass {
	
	private $methods = array();
	private $properties = array();
	protected static $instances = array();
	const method_reflector_class = 'MethodReflector';
	const property_reflector_class = 'PropertyReflector';
	
	public function __construct( $class ) {
		parent::__construct($class);
	}
	
	public function raiseInstanceCount() {
		if( isset(self::$instances[$this->getFullName()]) )
			self::$instances[$this->getFullName()] += 1;
		else
			self::$instances[$this->getFullName()] = 1;
	}
	
	public function getInstanceCount() {
		return self::$instances[$this->getFullName()];
	}
	
	public function getMethod($method) {
		if( empty($this->methods[$method]) ) {
			$reflector_class = static::method_reflector_class;	
			$this->methods[$method] = new $reflector_class($this->getFullName(), $method);
		}
		return $this->methods[$method];
	}
	
	public function getMethods($filter = ReflectionMethod::IS_PUBLIC) {
		$methods = array(); 
		foreach( get_class_methods($this->getFullName()) as $method ) {
			$methods[$method] = $this->getMethod($method);
		}
		return $methods;
	}
	
	public function getProperty($property) {
		if( empty($this->properties[$property]) ) {
			$reflector_class = static::property_reflector_class;
			$this->properties[$property] = new $reflector_class($this->getFullName(), $property);
		}
		
		return $this->properties[$property];
	}
	
	public function getProperties() {
		$properties = array();
		foreach( parent::getProperties() as $property ) {
			$properties[$property->getName()] = $this->getProperty($property->getName());
		}
		return $properties;
	}
	
	public function getName() {
		return array_pop(explode('\\', parent::getName()));
	}
	
	public function getFullName() {
		return parent::getName();
	}
}
?>