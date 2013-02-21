<?php
final Class DatabaseServer extends Object {

	private $type;
	private $hostname;
	private $username;
	private $password;
	private $database;
	private $flags;
	private $port;

	final public function __construct($config) {
		parent::__construct();
		$this->type    	= $config['type'];
		$this->hostname	= $config['host'];
		$this->username	= $config['user'];
		$this->password	= $config['pass'];
		$this->database	= $config['name'];
		$this->flags	= $config['flag'];
		$this->port		= $config['port'];
	}

	final public function type() {
		return $this->type;
	}

	final public function hostname() {
		return $this->hostname;
	}

	final public function username() {
		return $this->username;
	}

	final public function password() {
		return $this->password;
	}

	final public function database() {
		return $this->database;
	}

	final public function flags() {
		return $this->flags;
	}

	final public function port() {
		return $this->port;
	}
}
?>