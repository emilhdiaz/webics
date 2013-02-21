<?php
abstract class AnnotationParser {
	
	protected $annotations = array();
	
	private static function parseAnnotations (Reflector $reflector, $func) {
		$annotations = array();
		$docComment = $reflector->getDocComment();

		if( preg_match_all('/\*[\s]@([a-zA-Z0-9]+)[\t ]*([\[\]\(\)\{\}!@#\$%\^&\+-\|\?\.=\s]*)?(\*\*)?/', $docComment, $matches) ) {
			foreach( $matches[0] as $key=>$match ) {
				$annotation = $matches[1][$key];
				$value = $matches[2][$key];
				$func($annotation, $value, $annotations);
			}
		}
		
		return $annotations;
	}
	
	public static function parseMethodAnnotations( ReflectionMethod $method ) {
		$func = function($annotation, $value, &$annotations) {
			switch( $annotation ) {
				case 'param':
					break;
				default:
					$annotations[$annotation] = trim($value) ? trim($value) : true;
					break;
			}
		};
		return self::parseAnnotations($method, $func);
	}
	
	public static function parseParameterAnnotations( ReflectionParameter $parameter ) {
		$func = function($annotation, $value, &$annotations) use ($parameter) {
			switch( $annotation ) {
				case 'param':
					preg_match('/([\w\\\]+)(\[\])?(\{\})?\(?([0-9]*)\)?[\s]+\$([\w]+)/', $value, $matches);
					list($value, $class, $isArray, $isHash, $length, $name) = $matches;
					
					if( !class_exists($class) ) throw new Exception("Class `$class` does not exist");

					if( $name == $parameter->getName() ) {
						$annotations['type'] = $class;
						$annotations['length'] = (int) $length;
						$annotations['isEntity'] = $class::getClass()->isSubclassOf('\DAOEntity') ? true : false;
						$annotations['isCollection'] = ( $isArray || $isHash ) ? true : false;
						$annotations['collectionType'] = $isArray ? 'VArray' : ($isHash ? 'Hash' : false);
					}
					break;
			}
		};
		return self::parseAnnotations($parameter->getDeclaringFunction(), $func);
	}
	
	public static function parsePropertyAnnotations( ReflectionProperty $property ) {
		$func = function($annotation, $value, &$annotations) use ($property) {
			switch( $annotation ) {
				case 'var':
					preg_match('/([\w\\\]+)(\[\])?(\{\})?\(?([0-9]*)\)?([\s]+[\w]+)?/', $value, $matches);
					list($value, $class, $isArray, $isHash, $length, $label) = $matches;
					
					if( !class_exists($class) ) throw new Exception("Class `$class` does not exist");

					$annotations['type'] = $class;
					$annotations['length'] = (int) $length;
					$annotations['isEntity'] = $class::getClass()->isSubclassOf('\DAOEntity') ? true : false;
					$annotations['isCollection'] = ( $isArray || $isHash ) ? true : false;
					$annotations['collectionType'] = $isArray ? 'VArray' : ($isHash ? 'Hash' : false);
					break;
					
				case 'restricted':
					preg_match_all('/([\w]+)/', $value, $matches);
					$annotations[$annotation] = $matches[0];
					break;
					
				default:
					$annotations[$annotation] = trim($value) ? trim($value) : true;
					break;
			}
		};
		return self::parseAnnotations($property, $func);
	}
}
?>