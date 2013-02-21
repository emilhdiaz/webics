<?php

final class MySQLDatabasePreparedStatement extends Object implements DatabasePreparedStatement {

	private $stmt;
	private $args;

	final public function __construct($stmt, $query) {
		parent::__construct();
		debug("Initializing MySQLDatabasePreparedStatement object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->stmt = $stmt;
		$this->prepare($query);
	}

	final public function prepare($query) {
		debug("Preparing query: $query;", 5);
		if( !mysqli_stmt_prepare($this->stmt, $query) ) throw new AbnormalExecutionException($this->error());
	}

	final public function bindParams(VArray $bind_params) {
		debug("Binding input parameters ...", 5);
		$args = array();
		$args[] = $this->stmt;
		$args[] = get_types($bind_params);
		foreach($bind_params as $k=>$v) {
			$rand = rand();
			${$rand} = $this->mapValue($bind_params[$k]);
			$args[] = &${$rand};
		}
		if( !call_user_func_array('mysqli_stmt_bind_param', $args) ) ;//throw new AbnormalExecutionException($this->error());
	}

	final public function execute() {
		debug("Executing prepared statement ...", 5);
		if( !mysqli_stmt_execute($this->stmt) ) throw new AbnormalExecutionException($this->error());
		return $this->hasResult() ? new MySQLDatabaseStatementResult($this->stmt) : new NullDatabaseResult();
	}

	final public function hasResult() {
		debug("Checking if query has a result set ...", 5);
		return (bool) mysqli_stmt_field_count($this->stmt);
	}

	final public function free() {
		debug("Freeing prepared statement resources ...", 5);
		mysqli_stmt_free_result($this->stmt);
		if( !mysqli_stmt_close($this->stmt) ) throw new AbnormalExecutionException($this->error());
	}

	final public function error() {
		debug("Generating MySQLDatabasePreparedStatement error ...", 5);
		$error = mysqli_stmt_error($this->stmt);
		return !empty($error) ? $error : FALSE;
	}
	
	final public function mapValue( $value ) {
		if( is_object($value) ) {
			if( $value instanceOf DateTime )
				$new_value = $value->format("Y-m-d H:i:s");
				
			elseif( $value instanceOf Boolean )
				$new_value = (int) $value->toInteger()->int();

			elseif( $value instanceOf String )
				$new_value = $value->str();
				
			elseif( $value instanceOf Integer )
				$new_value = (int) $value->int();

			elseif( $value instanceOf Float )
				$new_value = $value->float();
				
			else 
				$new_value = $value;
		} else {
			$new_value = $value;
		}
		return $new_value;
	}

	final public function __destruct() {
		debug("Destroying MySQLDatabasePreparedStatement object # ".static::getClass()->getInstanceCount()."...", 5);
		$this->free();
	}
}
?>