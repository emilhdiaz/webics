<?php
/*
 * Database
 *
 * Database is a Database Abstraction Layer that uses the
 * Strategy Pattern to deligate method calls to a Database
 * Driver with the appropriate logic to handle the request.
 */
final class Database extends Object {

	public $type;
	private $driver;

	final static public function connect( DatabaseServer $server ) {
		$databaseDriver = $server->type().'DatabaseDriver';

		if( !class_exists($databaseDriver) )
			throw new UnavailableResourceException($databaseDriver);

		$database = new self;
		$database->type = $server->type();
		$database->driver = new $databaseDriver;
		$database->driver->connect($server);
		return $database;
	}
	
	final public function type() {
		return $this->type;
	}

	final public function active( $database ) {
		$this->driver->active($database);
		return $this;
	}

	final public function execute( DatabaseStatement $statement ) {
		return $this->driver->execute($statement);
	}

	final public function prepare( DatabaseStatement $statement, VArray $bind ) {
		return $this->driver->prepare($statement, $bind->values());
	}

	final public function hasResult() {
		return $this->driver->hasResult();
	}

	final public function insertID() {
		return $this->driver->insertID();
	}

	final public function transaction() {
		$this->driver->transaction();
		return $this;
	}

	final public function autocommit() {
		$this->driver->autocommit();
		return $this;
	}

	final public function commit() {
		$this->driver->commit();
		return $this;
	}

	final public function rollback() {
		$this->driver->rollback();
		return $this;
	}

	final public function error() {
		return $this->driver->error();
	}

	final public function disconnect() {
		$this->driver->disconnect();
	}
	
	final public function locate( SelectDatabaseStatement $statement, VArray $bind = null ) {
		if (isset($bind)) {
			$stmt = $this->prepare($statement, $bind);
			$result = $stmt->execute();
		}
		else {
			$result = $this->execute($statement);
		}
		return $result->fetchRow();
	}
	
	final public function query( SelectDatabaseStatement $statement, VArray $bind = null ) {
		if (isset($bind)) {
			$stmt = $this->prepare($statement, $bind);
			$result = $stmt->execute();
		}
		else {
			$result = $this->execute($statement);
		}
		return $result->fetchRows();
	}

	final public function quick( DatabaseStatement $statement, VArray $bind = null ) {
		if (isset($bind)) {
			$stmt = $this->prepare($statement, $bind);
			$stmt->execute();
		}
		else {
			$this->execute($statement);
		}
	}
	
	public function sql( $type, $options ) {
		$databaseSQL = $database->type.'DatabaseSQL';
		return $databaseSQL::build($type, $options);
	}
	
	public function tableExists( $tableName ) {
		return $this->driver->tableExists($tableName);
	}
	
	public function dropAll() {
		return $this->driver->dropAll();
	}
	
	public function newTable( $tableName ) {
		return new DatabaseTable($this, $tableName);
	}

	public function newInsertStatement() {
		return new InsertStatement($this);
	}
		
	public function newSelectStatement() {
		return new SelectStatement($this);
	}
	
	public function newNextStatement() {
		return new NextStatement($this);
	}
	
	public function newUpdateStatement() {
		return new UpdateStatement($this);
	}
	
	public function newDeleteStatement() {
		return new DeleteStatement($this);
	}
	
	public function newCreateTableStatement() {
		return new CreateTableStatement($this);
	}
	
	public function newDropTableStatement() {
		return new DropTableStatement($this);
	}

	public function mapType( $class ) {
		return $this->driver->mapType($class);
	}

	final public function __destruct() 	{
        unset($this->driver);
	}
}
?>