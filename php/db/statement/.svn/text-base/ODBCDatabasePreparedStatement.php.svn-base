<?php
final class ODBCDatabasePreparedStatement extends Object implements DatabasePreparedStatement {

	private $cxn;
	private $stmt;
	private $bind_params;
	private $query_type;

	final public function __construct($cxn, $query) {
		parent::__construct();
		debug("Initializing ODBCDatabasePreparedStatement object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->cxn = $cxn;
		$this->prepare($query);
	}

	final public function prepare($query) {
		debug("Preparing query: $query;", 5);
		if( !$this->stmt = odbc_prepare($this->cxn, $query) ) throw new AbnormalExecutionException($this->error());
		$Query = new String($query);
		$this->query_type = $Query->before(new String(' '));
		return $this;
	}

	final public function bindParams(VArray $bind_params) {
		debug("Binding input parameters ...", 5);
		$this->bind_params = $bind_params;
	}

	final public function execute() {
		debug("Executing prepared statement ...", 5);
		if( !odbc_execute($this->stmt, $this->bind_params->arr()) ) throw new AbnormalExecutionException($this->error());
		return $this->hasResult() ? new ODBCDatabaseResult($this->stmt) : new NullDatabaseResult();
	}

	final public function hasResult() {
		debug("Checking if query has a result set ...", 5);
		return (bool) ($this->query_type == "SELECT") ? true : false;
	}

	final public function free() {
		debug("Freeing prepared statement resources ...", 5);
		if( !odbc_free_result ($this->stmt) ) throw AbnormalExecutionException($this->error());
	}

	final public function error() {
		debug("Generating ODBCDatabasePreparedStatement error ...", 5);
		$error = odbc_errormsg($this->cxn);
		return !empty($error) ? $error : FALSE;
	}

	final public function __destruct() {
		debug("Destroying ODBCDatabasePreparedStatement object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->free();
	}
}
?>