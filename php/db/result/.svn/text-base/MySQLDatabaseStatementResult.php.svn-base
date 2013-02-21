<?php

/*
 * MySQLDatabaseStatementResult
 *
 * DBResult implementation for the MySQLi database.
 * To be used in conjunction with other MySQLi driver components.
 */

final class MySQLDatabaseStatementResult extends Object implements DatabaseResult {

	private $stmt;
	private $meta;
	private $bind_results;

	final public function __construct( mysqli_stmt $stmt ) {
		parent::__construct();
		debug("Initializing MySQLDatabaseStatementResult object # ".static::getClass()->getInstanceCount()."...", 6);
		if( !mysqli_stmt_store_result($stmt) )  throw new AbnormalExecutionException();
		if( !$this->meta = mysqli_stmt_result_metadata($stmt))  throw new AbnormalExecutionException();
		$this->stmt = $stmt;

		/* Bind output variables */
		$headers = $this->fetchHeaders();
		foreach($headers as $header) {
			$bind_results[] = &${$header};
		}
		$this->bindResults($bind_results);
	}

	final public function numOfRows() {
		debug("Fetching number of rows...", 6);
		return mysqli_stmt_num_rows($this->stmt);
	}

	final public function numOfFields() {
		debug("Fetching number of fields...", 6);
		return mysqli_num_fields($this->meta);
	}

	final public function fetchHeaders() {
		debug("Fetching header names ...", 6);
		$fields = $this->fetchFields();
		$field_names = array();
		foreach($fields as $field) {
			$field_names[] = $field->name;
		}
		return $field_names;
	}

	final public function fetchField() {
		debug("Fetching next field ...", 6);
		$field = mysqli_fetch_field($this->meta);
		return $field ? $field : NULL;
	}

	final public function fetchFields() {
		debug("Fetching all fields ...", 6);
		$fields = mysqli_fetch_fields($this->meta);
		return $fields ? $fields : array();
	}

	final public function fetchRow( $type = FETCH_OBJ ) {
		debug("Fetching next row ...", 6);
		$result = mysqli_stmt_fetch($this->stmt);
		if( $result === FALSE ) throw new AbnormalExecutionException();
		elseif( $result === NULL ) return NULL;
		$row = NULL;
		switch( $type ) {
			case FETCH_ARRAY:
				$row = array_combine( $this->fetchHeaders(), reference_to_copy($this->bind_results) );
				break;
			case FETCH_VALUES:
				$row = array_values( $this->bind_results );
				break;
			case FETCH_OBJ:
				$row = array_to_object( array_combine( $this->fetchHeaders(), reference_to_copy($this->bind_results) ) );
				break;
		}
	 	return $row;
	}

	final public function fetchRows( $type = FETCH_OBJ ) {
		debug("Fetching all rows ...", 6);
		$this->reset();
		$rows = array();
		for($i = 0; $i < $this->numOfRows(); $i++) {
			$rows[$i] = $this->fetchRow($type);
		}
		return $rows;
	}

	final public function fetch() {
		debug("Fetching data for ".$this->numOfRows()." rows", 6);
		$this->reset();
		if($this->numOfRows() > 1)
			return $this->fetchRows();
		else
			return $this->fetchRow();
	}

	final public function reset() {
		debug("Resetting result set pointers...", 6);
		mysqli_stmt_data_seek($this->stmt, 0);
		mysqli_field_seek($this->meta, 0);
	}

	final public function free() {
		debug("Freeing result set resources ...", 6);
		mysqli_stmt_free_result($this->stmt); //no return value;
		mysqli_free_result($this->meta); //no return value;
	}

	final public function bindResults( array $bind_results ) {
		debug("Binding output parameters ...", 6);
		$this->bind_results = $bind_results;
		$bind_results = array_reverse($bind_results);
		$bind_results[] = $this->stmt;
		$bind_results = array_reverse($bind_results);
//		array_unshift($bind_results, $this->stmt);
		if( !call_user_func_array('mysqli_stmt_bind_result', $bind_results) ) throw new AbnormalExecutionException();
	}

	final public function each( $closure ) {
		
	}

	final public function first() {
		
	}
	
	final public function last() {
		
	}
		
	final public function __toString() {
		return print_r($this->fetch(), true);
	}

	final public function __destruct() {
		debug("Destroying MySQLDatabaseStatementResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->free();
	}
}
?>