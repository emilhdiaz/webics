<?php
class PropertyReflector extends ReflectionProperty {

	private $declaringClass;
	protected $annotations = array();

	public function __construct( $class, $property ) {
		parent::__construct($class, $property);
		$this->declaringClass = parent::getDeclaringClass()->getName();
		$this->annotations = AnnotationParser::parsePropertyAnnotations($this);
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
	
	public function getType() {
		return $this->annotations['type'];
	}
	
	public function getLength() {
		return $this->annotations['length'];
	}
	
	public function isEntity() {
		return $this->annotations['isEntity'];
	}
	
	public function isCollection() {
		return $this->annotations['isCollection'];
	}
	
	public function getCollectionType() {
		return $this->annotations['collectionType'];	
	}	

	public function getDeclaringClass() {
		$declaringClass = $this->declaringClass;
		return $declaringClass::getClass();
	}
}
?>