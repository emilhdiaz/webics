<?php

final class OracleDatabasePreparedStatement extends Object implements DatabasePreparedStatement {

	private $cxn;
	private $stmt;
	public static $AUTOCOMMIT = OCI_COMMIT_ON_SUCCESS;

	final public function __construct($cxn, $query) {
		parent::__construct();
		debug("Initializing OracleDatabaseStatement object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->cxn = $cxn;
		$this->prepare($query);
	}

	final public function prepare($query) {
		debug("Preparing query: $query;", 5);
		$ph = 1;
		while($pos = stripos($query, '?')) {
			$query = substr_replace($query, ':bind'.$ph, $pos, 1);
			$ph++;
		}
		if( !$this->stmt = oci_parse($this->cxn, $query) ) throw new AbnormalExecutionException($this->error());
	}

	final public function bindParams(VArray $bind_params) {
		debug("Binding input parameters ...", 5);
		$isAssoc = is_associative($bind_params);
		foreach ( $bind_params->arr() as $ph=>&$param ) {
			if($isAssoc) {
				if( !oci_bind_by_name($this->stmt, ':'.$ph, $param, -1) ) throw new AbnormalExecutionException($this->error());
			}
			else {
				if( !oci_bind_by_name($this->stmt, ':bind'.($ph+1), $param) ) throw new AbnormalExecutionException($this->error());
			}
		}
	}

	final public function execute() {
		debug("Executing prepared statement ...", 5);
		if( !oci_execute($this->stmt, self::$AUTOCOMMIT) ) throw new AbnormalExecutionException($this->error());
		if( $this->error() ) throw new AbnormalExecutionException($this->error());
		return $this->hasResult() ? new OracleDatabaseResult($this->stmt) : new NullDatabaseResult();
	}

	final public function hasResult() {
		debug("Checking if query has a result set ...", 5);
		return (bool) (oci_statement_type($this->stmt) == "SELECT") ? true : false;
	}

	final public function free() {
		debug("Freeing prepared statement resources ...", 5);
		oci_free_statement ($this->stmt); //always return true
	}

	final public function error() {
		debug("Generating OracleDatabaseStatement error ...", 5);
		$error = $this->stmt? oci_error($this->stmt) : oci_error($this->cxn);
		return $error ? $error ['message'] : FALSE;
	}

	final public function __destruct() {
		debug("Destroying OracleDatabaseStatement object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->free();
	}
}
?>