<?php
class WebicsException extends Exception implements Iterable {
	public function iterator() {
		return new Hash(array(
			'code'	=> $this->getCode(),
			'file'	=> $this->getFile(),
			'line'	=> $this->getLine(),
			'message'=> $this->getMessage(),
			'exception'=> get_class($this)
		));
	}

	public function __toArray() {
//		v( $this->getTrace() );
		return array(
			'code'	=> $this->getCode(),
			'file'	=> $this->getFile(),
			'line'	=> $this->getLine(),
			'message'=> $this->getMessage(),
			'exception'=> get_class($this),
//			'trace'=>$this->getTrace()
		);
	}
	
	public function getClass() {
		$trace = $this->getTrace();
		$invocation = array_shift($trace);
		return $invocation['class'];
	}
	
	public function getMethod() {
		$trace = $this->getTrace();
		$invocation = array_shift($trace);
		return $invocation['function'];
	}
	
	public function getArguments() {
		$trace = $this->getTrace();
		$invocation = array_shift($trace);
		return $invocation['args'];
	}
	
};

class WebicsExceptions extends WebicsException implements Iterable {
	
	private $exceptions = array();
	
	public function __construct($message, array $exceptions, Exception $previous = null) {
		parent::__construct($message, null, $previous);
		$this->exceptions = $exceptions;
	}
	
	public function iterator() {
		return new Hash(array(
			'file'	=> $this->getFile(),
			'line'	=> $this->getLine(),
			'message'=> $this->getMessage(),
			'exception'=> get_class($this),
			'exceptions'=> $this->exceptions
		));
	}

	public function __toArray() {
		return array(
			'file'	=> $this->getFile(),
			'line'	=> $this->getLine(),
			'message'=> $this->getMessage(),
			'exception'=> get_class($this),
			'exceptions'=> $this->exceptions
		);
	}
};

class WebicsErrorException extends ErrorException implements Iterable {
	public function iterator() {
		return new Hash(array(
			'code'	=> $this->getCode(),
			'file'	=> $this->getFile(),
			'line'	=> $this->getLine(),
			'message'=> $this->getMessage(),
			'exception'=> get_class($this)
		));
	}

	public function __toArray() {
		return array(
			'code'	=> $this->getCode(),
			'file'	=> $this->getFile(),
			'line'	=> $this->getLine(),
			'message'=> $this->getMessage(),
			'exception'=> get_class($this)
		);
	}
}


/*
 * Fatal Runtime Exceptions
 */

class FatalRuntimeException extends WebicsException { }
class FatalRuntimeExceptions extends WebicsExceptions { }

class UnavailableResourceException extends FatalRuntimeException {
	public function __construct($resource, Exception $previous = null) {
		parent::__construct("Unavailable resource $resource", null, $previous);
	}
}

class AbnormalExecutionException extends FatalRuntimeException {
	public function __construct($execution, Exception $previous = null) {
		parent::__construct("Abnormal execution $execution", null, $previous);
	}
}

class InvalidValueException extends FatalRuntimeException {
	public function __construct($value, Exception $previous = null) {
		parent::__construct("Invalid value $value", null, $previous);
	}
}

class NullValueException extends FatalRuntimeException { 
	public function __construct($value, Exception $previous = null) {
		parent::__construct("Null value $value", null, $previous);
	}
}

class InvalidStateException extends FatalRuntimeException {
	public function __construct($state, Exception $previous = null) {
		parent::__construct("Invalid state $state", null, $previous);
	}
}

class InvalidTypeException extends FatalRuntimeException {
	public function __construct($value, $type, Exception $previous = null) {
		parent::__construct("Invalid type, expected $type for ".$this->getClass()."::".$value, null, $previous);
	}
}

class InvalidTypesException extends FatalRuntimeExceptions {
	public function __construct($values, Exception $previous = null) {
		parent::__construct("Invalid types $values for ".$this->getClass(), $values, $previous);
	}
}

class InvalidMethodArgumentException extends FatalRuntimeException {
	public function __construct($argument, Exception $previous = null) {
		parent::__construct("Invalid method argument ".$this->getClass()."::".$this->getMethod()."(.. $$argument ..)", null, $previous);
	}
}

class InvalidMethodArgumentsException extends FatalRuntimeExceptions {
	public function __construct(array $arguments, Exception $previous = null) {
		parent::__construct("Invalid method arguments $arguments for ".$this->getClass()."::".$this->getMethod(), $arguments, $previous);
	}
}

class MissingMethodArgumentException extends FatalRuntimeException {
	public function __construct($argument, Exception $previous = null) {
		parent::__construct("Missing method argument ".$this->getClass()."::".$this->getMethod()."(.. $$argument ..)", null, $previous);
	}
}

class MissingMethodArgumentsException extends FatalRuntimeExceptions {
	public function __construct($arguments, Exception $previous = null) {
		parent::__construct("Missing method arguments $arguments for ".$this->getClass()."::".$this->getMethod(), $arguments, $previous);
	}
}

class InvalidIndexException extends FatalRuntimeException { 
	public function __construct($index, Exception $previous = null) {
		parent::__construct("Invalid index [$index]", null, $previous);
	}
}

class RestrictedPropertyException extends FatalRuntimeException { 
	public function __construct($property, $type, Exception $previous = null) {
		parent::__construct("Restricted $type property ".$this->getClass()."::".$property, null, $previous);
	}
}
class RestrictedPropertiesException extends FatalRuntimeExceptions {
	public function __construct($arguments, Exception $previous = null) {
		parent::__construct("Restricted properties $arguments for ".$this->getClass(), $arguments, $previous);
	}
}
class RequiredPropertiesException extends FatalRuntimeExceptions { 
	public function __construct($properties, Exception $previous = null) {
		parent::__construct("Required properties $properties for ".$this->getClass(), $properties, $previous);
	}
}

class UnknownMethodException extends FatalRuntimeException {
	public function __construct($method, Exception $previous = null) {
		parent::__construct("Unknown method ".$this->getClass()."::".$method."()", null, $previous);
	}
}

class UnknownPropertyException extends FatalRuntimeException { 
	public function __construct($property, Exception $previous = null) {
		parent::__construct("Unknown property ".$this->getClass()."::".$property, null, $previous);
	}
}

class UnknownPropertiesException extends FatalRuntimeExceptions { 
	public function __construct($properties, Exception $previous = null) {
		parent::__construct("Unknown properties $properties for ".$this->getClass(), $properties, $previous);
	}
}

class NoneExistentEntityException extends FatalRuntimeException {
	public function __construct($entity, $key, Exception $previous = null) {
		parent::__construct("None existing entity ".$entity."[".implode(',',$key)."]", null, $previous);
	}
}

class DuplicateEntityException extends FatalRuntimeException {
	public function __construct($entity, $key, Exception $previous = null) {
		parent::__construct("Duplicate entity ".$entity."[".implode(',',$key)."]", null, $previous);
	}
}

class FailedAssertionException extends FatalRuntimeException {
	public function __construct($assertion, Exception $previous = null) {
		parent::__construct("Failed assertion ".$assertion, null, $previous);
	}
}

/*
 * Logical Application Exception
 */
class LogicalApplicationException extends WebicsException { } 

class DuplicateUserException extends LogicalApplicationException {
	public function __construct($duplicateField, Exception $previous = null) {
		parent::__construct(
			"Sorry! The $duplicateField provided is already associated with an account. ".
			"Please either sign in or provide a different $duplicateField to create a new account."
		);
	}
}


/*
 * Utility Exceptions
 */
class FilterException extends WebicsException { }
class FormatException extends WebicsException { }
class SanitizeException extends WebicsException { }
class ValidateException extends WebicsException { }
class PrototypeFactoryException extends WebicsException { }

/*
 * API & Session Exceptions
 */
class APIException extends WebicsException { }
class ApplicationException extends WebicsException { }

class DataValidationException extends WebicsExceptions { }
class UserAuthenticationException extends WebicsException { }
?>