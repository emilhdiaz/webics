<?php
class ParameterReflector extends ReflectionParameter {

	protected $annotations = array();
	
	public function __construct( $method, $parameter ) {
		parent::__construct($method, $parameter);
		$this->annotations = AnnotationParser::parseParameterAnnotations($this);
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
}	
?>