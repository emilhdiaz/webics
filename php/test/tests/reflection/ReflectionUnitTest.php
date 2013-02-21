<?php
class ReflectionUnitTest extends UnitTest {
	
	/**
	 * @var ReflectionUnitTest
	 */
	protected $testProperty1;
	
	/**
	 * @var unittests\Book[]
	 */
	protected $testProperty2;
	
	/**
	 * @var Timestamp
	 * @default Now
	 */
	protected $testProperty3;
	
	public static function test_ClassReflectorInstanciation() {
		$class1 = ReflectionUnitTest::getClass();
		$class2 = ReflectionUnitTest::getClass();
		assert( $class1 === $class2 );
	}
	
	public static function test_MethodReflectorInstanciation() {
		$class = ReflectionUnitTest::getClass();
		$methods1 = $class->getMethods();
		$methods2 = $class->getMethods();
		assert( $methods1 === $methods2 );
	}
	
	public static function test_PropertyReflectorInstanciation() {
		$class = ReflectionUnitTest::getClass();
		$properties1 = $class->getProperties();
		$properties2 = $class->getProperties();
		assert( $properties1 === $properties2 );
	}
	
	public static function test_ParameterReflectorInstanciation($param1, $param2) {
		$class = ReflectionUnitTest::getClass();
		$method = $class->getMethod('test_ParameterReflectorInstanciation');
		$parameters1 = $method->getParameters();
		$parameters2 = $method->getParameters();
		assert( $parameters1 === $parameters2 );
	}
	
	/**
	 * @annotation0
	 * @annotation1 Annotation1
	 * @annotation2	Annotation2
	 * @param Null null
	 */
	public static function test_MethodAnnotation() {
		$class = ReflectionUnitTest::getClass();
		$method = $class->getMethod('test_MethodAnnotation');
		$annotations = $method->getAnnotations();
		assert( $annotations['annotation0'] && $annotations['annotation0'] == true );
		assert( $annotations['annotation1'] && $annotations['annotation1'] == 'Annotation1' );
		assert( $annotations['annotation2'] && $annotations['annotation2'] == 'Annotation2' );
		assert( !$annotations['param'] );
	}	
	
	public static function test_PropertyAnnotation() {
		$class = ReflectionUnitTest::getClass();
		$testProperty1 = $class->getProperty('testProperty1');
		assert( $testProperty1->getAnnotation('type') == 'ReflectionUnitTest' );
		assert( $testProperty1->getAnnotation('length') == 0 );
		assert( $testProperty1->getAnnotation('isEntity') == false );
		assert( $testProperty1->getAnnotation('isCollection') == false );
		assert( $testProperty1->getAnnotation('collectionType') == false );
		assert( $testProperty1->getAnnotation('random') == false );
		
		assert( $testProperty1->getType() == 'ReflectionUnitTest' );
		assert( $testProperty1->getLength() == 0 );
		assert( $testProperty1->isEntity() == false );
		assert( $testProperty1->isCollection() == false );
		assert( $testProperty1->getCollectionType() == false );
		
		$testProperty2 = $class->getProperty('testProperty2');
		assert( $testProperty2->getAnnotation('type') == 'unittests\Book' );
		assert( $testProperty2->getAnnotation('length') == 0 );
		assert( $testProperty2->getAnnotation('isEntity') == true );
		assert( $testProperty2->getAnnotation('isCollection') == true );
		assert( $testProperty2->getAnnotation('collectionType') == 'VArray' );
		assert( $testProperty2->getAnnotation('random') == false );
		
		assert( $testProperty2->getType() == 'unittests\Book' );
		assert( $testProperty2->getLength() == 0 );
		assert( $testProperty2->isEntity() == true );
		assert( $testProperty2->isCollection() == true );
		assert( $testProperty2->getCollectionType() == 'VArray' );
		
		$testProperty3 = $class->getProperty('testProperty3');
		assert( $testProperty3->getAnnotation('type') == 'Timestamp' );
		assert( $testProperty3->getAnnotation('length') == 0 );
		assert( $testProperty3->getAnnotation('isEntity') == false );
		assert( $testProperty3->getAnnotation('isCollection') == false );
		assert( $testProperty3->getAnnotation('collectionType') == false );
		assert( $testProperty3->getAnnotation('default') == 'Now' );
	}
	
	/**
	 * Method Name - Method description
	 * @param unittests\Author	$param1
	 * @param unittests\Book{}	$param2
	 */
	public static function test_ParameterAnnotation($param1, $param2) {
		$class = ReflectionUnitTest::getClass();
		$method = $class->getMethod('test_ParameterAnnotation');
		$parameter1 = $method->getParameter('param1');
		$parameter2 = $method->getParameter('param2');
		
		assert( $parameter1->getType() == 'unittests\Author' );
		assert( $parameter1->getLength() == 0 );
		assert( $parameter1->isEntity() == true );
		assert( $parameter1->isCollection() == false );
		assert( $parameter1->getCollectionType() == false );
		
		assert( $parameter2->getType() == 'unittests\Book' );
		assert( $parameter2->getLength() == 0 );
		assert( $parameter2->isEntity() == true );
		assert( $parameter2->isCollection() == true );
		assert( $parameter2->getCollectionType() == 'Hash' );
	}
}
?>