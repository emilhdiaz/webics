<?php
abstract class UnitTest extends Object {
	
	public static function run() {
		$db = Application::db();
		$methods = static::getClass()->getMethods();
		print "\n*** Running UnitTests for ".static::getClass()->getName()." ***\n";
		$i = 1;
		foreach( $methods as $method ) {
			$methodName = $method->name;
			$db->transaction();
			try {
				if( strpos($methodName, 'test') === 0 ) {
					print "----------------------------------------------------------\n";
					
					static::$methodName();
					if( $exceptionClass = static::getClass()->getMethod($methodName)->getAnnotation('exception') ) {
						throw new FailedAssertionException("expected exception: $exceptionClass");
					}
					print $i++.") Test Passed: $methodName\n";
				}
			} catch( Exception $exception ) {
				if( $exceptionClass = static::getClass()->getMethod($methodName)->getAnnotation('exception') ) {
					if( $exception instanceOf $exceptionClass ) {
						print $i++.") Test Passed: $methodName\n";	
						continue;
					} 
				}
				print $i++.") Test Failed: $methodName\n\n";
				print "\tException: ".$exception->getMessage()."\n";
				print "\tLocation: ".$exception->getFile()." line ".$exception->getLine()."\n";
//				print "\tTrace: ".print_r($exception->getTrace(), true)."\n";
			}
			$db->rollback();
		}
	}
}
?>