<?php

final class OracleDatabaseDriver extends Object implements DatabaseDriver {

	private $cxn;
	private $stmt;

	final public function __construct() {
		parent::__construct();
		debug("Initializing OCI8 driver # ".static::getClass()->getInstanceCount()."...", 5);
	}

	final public function ssl() {
		debug("Configuing SSL options ...", 5);
	}

	final public function connect( DatabaseServer $srv ) {
		debug("Connecting to ".$srv->type()." database server at ".$srv->hostname().":".$srv->port()." ...", 5);
		if( !$this->cxn = oci_new_connect(
					$srv->username(),
					$srv->password(),
					"//".$srv->hostname().":".$srv->port()."/".$srv->database())
		) throw new AbnormalExecutionException($this->error());
	}

	final public function active( $database ) {
		debug("Selecting active database: '$database' ...", 5);
	}

	final public function execute( DatabaseStatement $statement ) {
		debug("Executing query: '$statement;' ...", 5);
		$this->stmt = New OracleDatabasePreparedStatement($this->cxn, $statement);
		return $this->stmt->execute();
	}

	final public function prepare( DatabaseStatement $statement, array $bind ) {
		$stmt = New OracleDatabasePreparedStatement($this->cxn, $statement);
		$stmt->bindParams($bind);
		return $stmt;
	}

	final public function hasResult() {
		return (bool) $this->stmt->hasResult();
	}

	final public function insertID() {
		debug("Obtaining last insert ID ...", 5);
	}

	final public function transaction() {
		debug("Entering transaction mode ...", 5);
		OracleDatabasePreparedStatement::$AUTOCOMMIT = OCI_DEFAULT;
	}

	final public function autocommit() {
		debug("Entering autocommit mode ...", 5);
		OracleDatabasePreparedStatement::$AUTOCOMMIT = OCI_COMMIT_ON_SUCCESS;
	}

	final public function commit() {
		debug("Committing transaction ...", 5);
		if( !oci_commit($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}

	final public function rollback() {
		debug("Rolling back transaction ...", 5);
		if( !oci_rollback($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}

	final public function error() {
		debug("Generating OCI8 error ...", 5);
		$error = $this->cxn ? oci_error($this->cxn) : oci_error();
		return $error ? $error ['message'] : FALSE;
	}

	final public function disconnect() {
		debug("Disconnecting from OCI8 database server ...", 5);
		if(! oci_close($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}

	final function __destruct() {
		debug("Destroying OracleDatabaseDriver object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->disconnect();
		unset($this->stmt);
	}
}
?>