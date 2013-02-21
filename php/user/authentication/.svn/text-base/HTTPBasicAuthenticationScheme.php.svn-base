<?php
class HTTPBasicAuthenticationScheme extends Object implements AuthenticationScheme {

	public function credentials() {
		if( empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']) )
			throw new UserAuthenticationException();

		return new UserCredentials($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
	}

	public function challenge( $message ) {
		header('WWW-Authenticate: Basic realm="Please log in."');
		header('HTTP/1.0 401 Unauthorized');

		Application::respond('error', new Hash( array(
			'negotiate'	=> Application::getAuthenticationProtocols(),
			'message'	=> $meesage ? $message : 'Authentication failed, incorrect username and password.'
		)));

		return $this;
	}
}
?>