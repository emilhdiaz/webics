<?php
class Session extends Object {

	public function __construct() {
		parent::__construct();
		$this->start();
		return $this;
	}

	public function __get( $name ) {
		return unserialize($_SESSION[$name]);
	}

	public function __set( $name, $value ) {
		if( is_object($value) )
			$_SESSION[$name] = serialize($value);
		else
			$_SESSION[$name] = $value;
	}

	public function __unset( $name ) {
		unset($_SESSION[$name]);
	}

	public function __isset( $name ) {
		return isset($_SESSION[$name]);
	}

	public function restore($name) {
		return unserialize($this->$name);
	}

	public function drop( $name ) {
		unset($_SESSION[$name]);
		return $this;
	}

	public function start() {
		session_start();
		return $this;
	}

	public function destroy() {
		session_destroy();
	}

	public function clear() {
		session_unset();
		return $this;
	}

	public function close() {
		session_commit();
		return $this;
	}

	public function decode( $data ) {
		return session_decode($data);
	}

	public function encode() {
		return session_encode();
	}

	public function setID( $id ) {
		session_id($id);
		return $this;
	}

	public function getID() {
		return session_id();
	}

	public function regenerate( $delete_old = false ) {
		session_regenerate_id($delete_old);
		return $this;
	}

	public function setName( $name ) {
		session_name($name);
		return $this;
	}

	public function getName() {
		return session_name();
	}

	public function setModule( $module ) {
		session_module_name($module);
		return $this;
	}

	public function getModule() {
		return session_module_name();
	}

	public function setSavePath( $path ) {
		session_save_path($path);
		return $this;
	}

	public function getSavePath() {
		return session_save_path();
	}

	public function setCacheExpire( $expire ) {
		session_cache_expire($expire);
		return $this;
	}

	public function getCacheExpire() {
		return session_cache_expire();
	}

	public function setCacheLimiter( $limiter ) {
		session_cache_limiter($limiter);
		return $this;
	}

	public function getCacheLimiter() {
		return session_cache_limiter();
	}

	public function setCookie( $lifetime, $path, $domain, $secure, $httponly ) {
		session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
		return $this;
	}

	public function getCookie() {
		return session_get_cookie_params();
	}
}
?>