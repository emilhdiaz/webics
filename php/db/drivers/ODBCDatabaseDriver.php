<?php

final class ODBCDatabaseDriver extends Object implements DatabaseDriver {

	private $cxn;
	private $result;
	private $last_query_type;

	final public function __construct() {
		parent::__construct();
		debug("Initializing ODBC driver # ".static::getClass()->getInstanceCount()."...", 5);
	}

	final public function ssl() {
		debug("Configuing SSL options ...", 5);
	}

	final public function connect( DatabaseServer $srv ) {
		debug("Connecting to ".$srv->type()." database server at ".$srv->hostname().":".$srv->port()." ...", 5);
		if( !$this->cxn = odbc_connect(
			'QuickBooks Data'
//			'Driver={QODBC Driver for QuickBooks};'.
//			'SERVER=QODBC;'.
//			'DFQ=C:\Users\Public\Documents\Intuit\QuickBooks\Sample Company Files\QuickBooks 2009\sample_product-based business.qbw;'.
//			'OpenMode=F;'.
//			'OptimizerOn=No;'.
//			'IBizOEConnection=No'.
//			'OptimizerOn=No'.
//			'UseDCOM=No;'.
//			'UseRDS=No;'
			, '', ''))
			throw new AbnormalExecutionException($this->error());
//		if( !$this->cxn = odbc_connect(
//			'Driver={'.$srv->flags().'};'.
//			'Server='.	$srv->hostname().';'.
//			'Port='.	$srv->port().';'.
//			'Database='.$srv->database().';',
//			$srv->username(),
//			$srv->password()
//		)) throw new AbnormalExecutionException($this->error());
	}

	final public function active( $database ) {
		debug("Selecting active database: '$database' ...", 5);
	}

	final public function execute( DatabaseStatement $statement ) {
		debug("Executing query: '$statement;' ...", 5);
		if( !$this->result = odbc_exec($this->cxn, $statement) ) throw new AbnormalExecutionException($this->error());
		$this->last_query_type = $statement->sql()->before(new String(' '));
		return $this->hasResult() ? New ODBCDatabaseResult($this->result) : NULL;
	}

	final public function prepare( DatabaseStatement $statement, array $bind ) {
		$stmt =  New ODBCDatabasePreparedStatement($this->cxn, $statement);
		$stmt->bindParams($bind);
		return $stmt;
	}

	final public function hasResult() {
		debug("Checking if query has a result set ...", 5);
		return (bool) ($this->last_query_type == "SELECT") ? true : false;
	}

	#TODO: fix
	final public function insertID() {
		debug("Obtaining last insert ID ...", 5);
		//return (int) mysqli_insert_id($this->cxn);
	}

	final public function transaction() {
		debug("Entering transaction mode ...", 5);
		if( !odbc_autocommit($this->cxn, FALSE) ) throw new AbnormalExecutionException($this->error());
	}

	final public function autocommit() {
		debug("Entering autocommit mode ...", 5);
		if( !odbc_autocommit($this->cxn, TRUE) ) throw new AbnormalExecutionException($this->error());
	}

	final public function commit() {
		debug("Committing transaction ...", 5);
		if( !odbc_commit($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}

	final public function rollback() {
		debug("Rolling back transaction ...", 5);
		if( !odbc_rollback($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}

	final public function error() {
		debug("Generating ODBCDatabaseDriver error ...", 5);
		$error = $this->cxn ? odbc_errormsg($this->cxn) : FALSE;
		return !empty($error) ? $error : FALSE;
	}

	final public function disconnect() {
		debug("Disconnecting from MySQLi database server ...", 5);
		odbc_close($this->cxn); //no return value
	}

	public function __destruct() 	{
		debug("Destroying ODBCDatabaseDriver object # ".static::getClass()->getInstanceCount()."...", 5);
        $this->disconnect();
	}
}
?>