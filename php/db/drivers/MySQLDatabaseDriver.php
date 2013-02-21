<?php
final class MySQLDatabaseDriver extends Object implements DatabaseDriver {

	private $cxn;

	final public function __construct() {
		parent::__construct();
		debug("Initializing MySQLi driver # ".static::getClass()->getInstanceCount()."...", 5);
		$this->cxn = mysqli_init();
	}

	final public function ssl() {
		debug("Configuing SSL options ...", 5);
	}

	final public function connect( DatabaseServer $srv ) {
		debug("Connecting to ".$srv->type()." database server at ".$srv->hostname().":".$srv->port()." ...", 5);
		if( !mysqli_real_connect(
					$this->cxn,
					$srv->hostname(),
					$srv->username(),
					$srv->password(),
					$srv->database(),
					$srv->port())
		) throw new AbnormalExecutionException(mysqli_connect_error());
	}

	final public function active( $database ) {
		debug("Selecting active database: '$database' ...", 5);
		if( !mysqli_select_db($this->cxn, $database) ) throw new AbnormalExecutionException($this->error());
	}

	final public function execute( DatabaseStatement $statement ) {
		debug("Executing query: '$statement;' ...", 5);
		if( !mysqli_real_query($this->cxn, $statement) ) throw new AbnormalExecutionException($this->error());
		return $this->hasResult() ? New MySQLDatabaseResult(mysqli_store_result($this->cxn)) : NULL;
	}

	final public function prepare( DatabaseStatement $statement, array $bind ) {
		$stmt =  New MySQLDatabasePreparedStatement(mysqli_stmt_init($this->cxn), $statement);
		$stmt->bindParams($bind);
		return $stmt;
	}

	final public function hasResult() {
		debug("Checking if query has a result set ...", 5);
		return (bool) mysqli_field_count($this->cxn);
	}

	final public function insertID() {
		debug("Obtaining last inser ID ...", 5);
		return (int) mysqli_insert_id($this->cxn);
	}

	final public function transaction() {
		debug("Entering transaction mode ...", 5);
		if( !mysqli_autocommit($this->cxn, FALSE) ) throw new AbnormalExecutionException($this->error());
	}

	final public function autocommit() {
		debug("Entering autocommit mode ...", 5);
		if( !mysqli_autocommit($this->cxn, TRUE) ) throw new AbnormalExecutionException($this->error());
	}

	final public function commit() {
		debug("Committing transaction ...", 5);
		if( !mysqli_commit($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}

	final public function rollback() {
		debug("Rolling back transaction ...", 5);
		if( !mysqli_rollback($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}
	
	final public function tableExists( $tableName ) {
		return (bool) $this->execute( new CustomStatement( new String("SHOW TABLES LIKE '$tableName'") ) )->numOfRows();
	}
	
	final public function dropAll() {
		$this->execute( new CustomStatement( new String("SET foreign_key_checks = 0") ) );
		$tables = $this->execute( new CustomStatement( new String("SHOW TABLES") ) );
		foreach($tables->fetchRows(FETCH_ARRAY) as $table) {
			$table = array_pop($table);
			$drop = new CustomStatement(new String("DROP TABLE `$table`"));
			$this->execute($drop);
		}
		$this->execute( new CustomStatement( new String("SET foreign_key_checks = 1") ) );
	}

	final public function error() {
		debug("Generating MySQLDatabaseDriver error ...", 5);
		$error = $this->cxn ? mysqli_error($this->cxn) : mysqli_connect_error();
		return !empty($error) ? $error : FALSE;
	}

	final public function disconnect() {
		debug("Disconnecting from MySQLi database server ...", 5);
		if( !mysqli_close($this->cxn) ) throw new AbnormalExecutionException($this->error());
	}
	
	final public function mapType( $class ) {
		switch($class) {
			case String: 
				$type = 'VARCHAR(255)';
				break;
				
			case Integer: 
			case SocialSecurityNumber:
				$type = 'INT(9) UNSIGNED';
				break;

			case BigInt:
				$type = 'BIGINT(20) UNSIGNED';
				break;
				
			case Float:
			case Money:
				$type = 'DECIMAL(6,2)';
				break;
			
			case DateTime:
			case Timestamp:
				$type = 'DATETIME';
				break;
			
			case Boolean:
				$type = 'TINYINT(1) UNSIGNED';
				break;

			default: 
				$type = 'VARCHAR(255)';
		} 
		return $type;
	}	

	public function __destruct() 	{
		debug("Destroying MySQLDatabaseDriver object # ".static::getClass()->getInstanceCount()."...", 5);
        $this->disconnect();
	}
}
?>