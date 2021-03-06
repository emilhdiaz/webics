<?php
require_once('ApplicationConfiguration.php');
require_once('php/common/common.php');
require_once('php/environment/Environment.php');
require_once('php/file/Path.php');

final class Application {

	private static $db;
	private static $dao;
	private static $apis;
	private static $config;
	private static $logger;
	private static $currentRequest;
	private static $executionEnvironment;

	final static public function load( ApplicationConfiguration $config = null ) {
		if( !$config ) $config = new ApplicationConfiguration;
		self::$executionEnvironment = executution_environment(); 
		
		/* Include Path settings */
		Environment::registerLibraryPath(new Path($config->SERVER_WEBICSDIR));

		/* Timezone settings */
		date_default_timezone_set('America/New_York');
		
		/* Load libraries */
		require_once('Exceptions.php');

		/* Error & Exception settings */
		define('DEBUG', $config->APPLICATION_DEBUG_LEVEL);
		ini_set('display_errors', $config->PHP_DISPLAY_ERRORS);
//		ini_set('error_reporting', $config->PHP_ERROR_REPORTING);
		ini_set('error_reporting', E_ALL ^ E_STRICT ^ E_NOTICE);
		set_error_handler('error_handler');
		set_exception_handler('exception_handler');
		assert_options(ASSERT_ACTIVE,     1);
		assert_options(ASSERT_WARNING,    0);
		assert_options(ASSERT_BAIL,       0);
		assert_options(ASSERT_QUIET_EVAL, 0);
		assert_options(ASSERT_CALLBACK,'assert_handler');
		self::$config = $config;

		/* Logger settings */
		$l = new DebugLogger(Logger::DEBUG);
		$e = new EmailLogger(Logger::NOTICE);
		$s = new StderrLogger(Logger::ERR);
		$l->setNext($e)->setNext($s);
		self::$logger = $l;
	}

	final static public function getName() {
		return self::$config->APPLICATION_NAME;
	}

	final static public function getURL() {
		return self::$config->APPLICATION_URL;
	}

	final static public function getDebugLevel() {
		return self::$config->APPLICATION_DEBUG_LEVEL;
	}

	final static public function getContactEmail() {
		return self::$config->APPLICATION_CONTACT_EMAIL;
	}

	final static public function getDataInterchange() {
		return self::$config->APPLICATION_DATA_INTERCHANGE;
	}

	final static public function getAuthenticationAPI() {
		return self::$config->APPLICATION_AUTHENTICATION_API;
	}

	final static public function getAuthenticationAgent() {
		$agent = self::$config->APPLICATION_AUTHENTICATION_AGENT.'AuthenticationAgent';
		return new $agent;
	}

	final static public function getAuthenticationProtocols() {
		return self::$config->APPLICATION_AUTHENTICATION_PROTOCOLS;
	}

	final static public function getCurrentRequest() {
		return self::$currentRequest;
	}

	final static public function registerAPI( $api ) {
		static::$apis[$api] = $api;
	}
	
	final static public function discover() {
		$services = array();
		foreach( static::$apis as $api ) {
			foreach( $api::getClass()->getMethods() as $method ) {
				if( $method->isFinal() )
					$services[$method->getFullName()] = $method->getFullName();
			}
		}
		self::respond('normal', new Hash($services));
	}

	final static public function definition() {
		$service = self::getCurrentRequest()->getArgument('service');
		$signature = array();
		list($api, $method) = explode('::', $service);
		
		if( !class_exists($api) )
			throw new UnavailableResourceException($api);
			
		if( !$api::getClass()->hasMethod($method) )
			throw new UnknownMethodException($method);
		
		foreach( $api::getClass()->getMethod($method)->getParameters() as $parameter ) {
			$signature[$parameter->getName()] = $parameter->getAnnotations();
		}
		self::respond('normal', new Hash($signature));
	}

	final static public function authenticate() {
		$session = new Session;
		$session->destroy();
		try {
			// Instantiate the authentication agent
			$agent = self::getAuthenticationAgent();

			$agent->setProtocol( self::getCurrentRequest()->getArgument('AuthenticationProtocol') );

			// Authenticate the user
			$agent->authenticate();

			// Start the session
			$session->start();

			// Save the user account in the session
			$session->user = $agent->getUser();

			self::respond('normal', new Hash());
		}
		catch (UserAuthenticationException $e) {
			$agent->challenge( $e->getMessage() );
		}
	}

	final static public function session() {
		self::requireUserSession();
		self::respond('normal', new Hash(array('session'=>$session->getID())));
	}

	final static public function end() {
		$session = new Session;
		$session->destroy();
		self::respond('normal', new Hash());
	}

	final static public function process() {
		$service = self::getCurrentRequest()->getRequest();
		list($api, $method) = explode('::', $service);
		
		if( !class_exists($api) )
			throw new UnavailableResourceException($api);
			
		$arguments = new Hash( self::getCurrentRequest()->getArguments() );
		$parameters = array();
		foreach( $api::getClass()->getMethod($method)->getParameters() as $parameter ) {
			$type = $parameter->getType();
			if( $parameter->isEntity() ) {
				$parameters[$parameter->getName()] = $type::load($arguments[$parameter->getName()]);	
			}
			else {
				$parameters[$parameter->getName()] = new $type($arguments[$parameter->getName()]);
			}
		}
		
		$result = call_user_func_array( self::getCurrentRequest()->getRequest(), $parameters );
		self::respond('normal', $result);
	}

	final static public function requireUserSession() {
		$session = new Session();

		if ( !isset($session->user) )
			throw new UserAuthenticationException('User is not authenticated.');

		return $session->user;
	}

	final static public function refreshUserSession() {
		$session = new Session();
		$user = self::requireUserSession();

		$session->user = $user->refresh();
	}

	final static public function run() {
		switch( self::$executionEnvironment ) {
			case 'cli':
				self::$currentRequest = new CLISApplicationRequest;
				break;
			case 'cgi':
				self::$currentRequest = new AJAXApplicationRequest;
				break;
		}
		try {
			// Query available services
			if( self::getCurrentRequest()->getRequest() == 'discover' )
				self::discover();

			// Query available services
			elseif(  self::getCurrentRequest()->getRequest() == 'definition' )
				self::definition();

			// New authentication and session
			elseif(  self::getCurrentRequest()->getRequest() == 'authenticate' )
				self::authenticate();

			// Check authenticated session, then return session ID
			elseif(  self::getCurrentRequest()->getRequest() == 'session' )
				self::session();

			// Close session
			elseif(  self::getCurrentRequest()->getRequest() == 'end' )
				self::end();

			// Check authenticated session, then process request
			else
				self::process();
		}
		// Prepare error response and send
		catch (UserAuthenticationException $e) {
			self::respond('authenticate', $e);
		}
		catch (WebicsError $e) {
			self::respond('error', $e);
		}
		catch (WebicsException $e) {
			self::respond('exception', $e);
		}
	}

	final static public function respond( $status, $message ) {
		$applicationResponse = self::getCurrentRequest()->getReturnType().'ApplicationResponse';
		$response = new $applicationResponse($status, $message);
		$response->send();
	}

	final static public function db() {
		if( !self::$db ) {
			$settings = array(
				'type'	=> self::$config->DB_TYPE,
				'host'	=> self::$config->DB_HOST,
				'user'	=> self::$config->DB_USER,
				'pass'	=> self::$config->DB_PASS,
				'name'	=> self::$config->DB_NAME,
				'port'	=> self::$config->DB_PORT,
				'flag'	=> self::$config->DB_FLAG
			);
			$server = new DatabaseServer( $settings );
			self::$db = Database::connect( $server );
		}
		return self::$db;
	}
	
	final static public function dao() {
		if( !self::$dao ) {
			self::$dao = new DatabaseDataAccessObject( self::db() );
		}
		return self::$dao;
	}

	final static public function log( $message ) {
		self::$logger->log($message);
	}
	
	final static public function build() {
		$models = new VArray();
		$modelPath = new Path(self::$config->SERVER_SITEROOT.'/app/model');
		$modelFiles = $modelPath->getFiles();
		$extentionSeperator = new String('.');
		foreach( $modelFiles as $modelFile ) {
			$models[] = $modelFile->before($extentionSeperator)->str();
		}
		$sorter = new DependencySorter($models);
		$sorter->sort();
		self::$db->transaction();
		println("** Dropping entire repository **");
		self::$db->dropAll();
		try {
			// create repositories for base models 
			foreach( $models as $model ) {
				$model::getClass()->createRepository();
			}
			// create implided relationships
			foreach( $models as $model ) {
				$model::getClass()->createRelationships();
			}
			
			self::$db->commit();
		}
		catch( Exception $e ) {
			self::$db->rollback();
			throw $e;
		}
	}
}
?>