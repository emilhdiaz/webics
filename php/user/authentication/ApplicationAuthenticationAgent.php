<?php
class ApplicationAuthenticationAgent extends Object implements AuthenticationAgent {

	private $api;
	private $user;
	private $protocol;

	final public function setProtocol( $protocol ) {
		$api = Application::getAuthenticationAPI();
		$protocol .= 'AuthenticationScheme';

				// Check for support of authentication scheme
		if( !class_exists($api) )
			throw new ApplicationException("Application Authentication agent is not supported or is missing.");

		// Check for support of authentication scheme
		if( !class_exists($protocol) )
			throw new ApplicationException("Authentication protocol '$userAuthentication' is not supported or is missing.");

		// Instantiate the authentication scheme
		$this->api = $api;
		$this->protocol = new $protocol;

		return $this;
	}

	final public function getUser() {
		return $this->user;
	}

	final public function authenticate() {
		$api = $this->api;
		$credentials = $this->protocol->getCredentials();
		$this->user = $api::authenticate( $credentials->iHave(), $credentials->iKnow() );

		return $this;
	}

	final public function challenge( $message ) {
		$this->protocol->challenge( $message );
	}
}
?>