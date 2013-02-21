<?php
define('DEBUG0', 0);
define('DEBUG1', 1);
define('DEBUG2', 2);
define('DEBUG3', 3);
define('DEBUG4', 4);
define('DEBUG5', 5);
define('DEV', 1);
define('UAT', 2);
define('PRD', 3);

class ApplicationConfiguration {

	/* Application Settings */
	protected $APPLICATION_NAME;
	protected $APPLICATION_URL;
	protected $APPLICATION_DEBUG_LEVEL;
	protected $APPLICATION_CONTACT_EMAIL;
	protected $APPLICATION_DATA_INTERCHANGE;
	protected $APPLICATION_AUTHENTICATION_API;
	protected $APPLICATION_AUTHENTICATION_AGENT;
	protected $APPLICATION_AUTHENTICATION_PROTOCOLS;

	/* PHP Settings */
	protected $PHP_DISPLAY_ERRORS	= 1;
	protected $PHP_ERROR_REPORTING	= E_ALL;
	protected $PHP_INCLUDE_PATH;

	/* Server Settings */
	protected $SERVER_SITEROOT;

	/* Database Settings */
	protected $DB_TYPE;
	protected $DB_HOST;
	protected $DB_USER;
	protected $DB_PASS;
	protected $DB_NAME;
	protected $DB_PORT;
	protected $DB_FLAG;

	public function __construct() {
		$this->SERVER_WEBICSDIR = $this->SERVER_WEBICSDIR ? $this->SERVER_WEBICSDIR : Environment::getVariable('WEBICS_PATH');
	}
	
	public function __get( $name ) {
		if( property_exists($this, $name) ) return $this->$name;
	}
}
?>