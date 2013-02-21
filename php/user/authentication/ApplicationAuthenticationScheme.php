<?php
class ApplicationAuthenticationScheme extends Object implements AuthenticationScheme {

	public function getCredentials() {
		$request = Application::getCurrentRequest();
		$username = $request->getArgument('Username');
		$password = $request->getArgument('Password');

		if( empty($username) || empty($password) )
			throw new UserAuthenticationException('The Username or Password you entered is not correct.');

		return new UserCredentials($username, $password);
	}

	public function challenge( $message ) {
		Application::respond('authenticate', new Hash( array(
			'negotiate'	=> Application::getAuthenticationProtocols(),
			'message'	=> $message
		)));

		return $this;
	}
}
?>