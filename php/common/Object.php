<?php
require_once('php/reflection/ClassReflector.php');

class Object {

	private static $reflectors = array();
	private static $singletons = array();
	const nativeType = 'object';
	const reflector_class = 'ClassReflector';
	
	public function __construct() {
		static::getClass()->raiseInstanceCount();
	}

	public function __clone() {
		static::getClass()->raiseInstanceCount();
	}

	public function __toArray() {
		return static::getClass()->getProperties();
	}

	public function __toString() {
		return static::getClass()->getName();
	}

	public function __set( $name, $value ) {
//		if( !static::getClass()->hasProperty($name) )
			throw new UnknownPropertyException($name);
			
		$this->$name = $value;
	}

	public function __get( $name ) {
//		if( !static::getClass()->hasProperty($name) )
			throw new UnknownPropertyException($name);

		return $this->$name;
	}

	public function __isset( $name ) {
//		if( !static::getClass()->hasProperty($name) )
			throw new UnknownPropertyException($name);
			
		return isset($this->$name);
	}

	public function __unset( $name ) {
//		if( !static::getClass()->hasProperty($name) )
			throw new UnknownPropertyException($name);

		unset($this->name);
	}

	public function __call( $name, $arguments ) {
//		if( !static::getClass()->hasMethod($name) )
			throw new UnknownMethodException($name);

		return call_user_func_array( array($this, $name), $arguments);
	}

	public static function __callStatic( $name, $arguments ) {
//		if( !static::getClass()->hasMethod($name) )
			throw new UnknownMethodException($name);

		return forward_static_call_array( array(static::getClass()->getName(), $name), $arguments);
	}

	public function __comparable( Object $object ) {
		return (bool) ( get_class($this) != get_class($entity) );
	}
	
	public function iterator() {
		return new Hash($this->__toArray());
	}
	
	public static function getInstance() {
		if( empty(self::$singletons[get_called_class()]) )
			self::$singletons[get_called_class()] = new static;
			
		return self::$singletons[get_called_class()];
	}
	
	public static function getClass() {
		if( empty(self::$reflectors[get_called_class()]) ) {
			$reflector_class = static::reflector_class;	
			self::$reflectors[get_called_class()] = new $reflector_class(get_called_class());
		}
		return self::$reflectors[get_called_class()];
	}
}
?>