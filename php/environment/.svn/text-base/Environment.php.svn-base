<?php
require_once('php/environment/Linux.php');
require_once('php/environment/Windows.php');

class Environment extends Object {
	
	/* Platform */
	public static function getPlatform() {
		switch( PHP_OS ) {
			case 'FreeBSD':
			case 'NetBSD':
			case 'OpenBSD':
			case 'Linux':
			case 'Darwin':
				return 'Linux';
				break;			
			case 'HP-UX':
			case 'SunOS':
			case 'Unix':
			case 'IRIX64':
				return 'Unix';
				break;
			case 'WIN32':
			case 'WINNT':
			case 'Windows':
			case 'CYGWIN_NT-5.1':
				return 'Windows';
				break;
		}
	}
	
	/* Operating system name */
	public static function getOS() {
		return php_uname('s');	
	}

	/* Host name */
	public static function getHostname() {
		return php_uname('n'); 
	}

	/* Release name */
	public static function getRelease() {
		return php_uname('r');
	}
	 
	/* Version information */
	public static function getVersion() {
		return php_uname('v');
	}
	
	/* Machine type */
	public static function getMachine() {
		return php_uname('m');
	}
	
	public static function getVariable( $name ) {
		return getenv($name);
	}
	
	public static function setIncludePath( $include_path ) {
		set_include_path( $include_path );
	}
	
	public static function registerLibraryPath( Path $path ) {
		$include_path = get_include_path().PATH_SEPARATOR;
		foreach($path->listNestedDirectories() as $dir ) {
			$include_path .= $dir.PATH_SEPARATOR;
		}
		self::setIncludePath($include_path);
	}
	
}
?>