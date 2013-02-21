<?php
class MethodReflector extends ReflectionMethod {

	private $declaringClass;
	private $parameters = array();
	protected $annotations = array();
	const parameter_reflector_class = 'ParameterReflector';

	public function __construct( $class, $method ) {
		parent::__construct($class, $method);
		$this->declaringClass = parent::getDeclaringClass()->getName();
		$this->annotations = AnnotationParser::parseMethodAnnotations($this);
	}
	
	public function hasAnnotation( $annotation ) {
		return (bool) array_key_exists($annotation, $this->annotations);
	}
	
	public function getAnnotation( $annotation ) {
		return $this->annotations[$annotation];
	}
	
	public function getAnnotations() {
		return $this->annotations; 
	}
	
	public function getParameter( $parameter ) {
		if( empty($this->parameters[$parameter]) ) {
			$reflector_class = static::parameter_reflector_class;	
			$this->parameters[$parameter] = new $reflector_class(array($this->class, $this->name), $parameter);
		}
		return $this->parameters[$parameter];
	}
	
	public function getParameters() {
		$parameters = array();
		foreach( parent::getParameters() as $parameter ) {
			$parameters[$parameter->getName()] = $this->getParameter($parameter->getName());
		}
		return $parameters;
	}
	
	public function getFullName() {
		return $this->class.'::'.$this->name;
	}
	
	public function getDeclaringClass() {
		$declaringClass = $this->declaringClass;
		return $declaring::getClass();
	}
}
?>