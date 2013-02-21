<?php

/*
 * MySQLDatabaseResult
 *
 * DBResult implementation for the MySQLi database.
 * To be used in conjunction with other MySQLi driver components.
 */

final class MySQLDatabaseResult extends Object implements DatabaseResult {

	private $result;
	private $bind_results;

	final public function __construct(mysqli_result $result) {
		parent::__construct();
		debug("Initializing MySQLDatabaseResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->result = $result;
	}

	final public function numOfRows() {
		debug("Fetching number of rows...", 6);
		return mysqli_num_rows($this->result);
	}

	final public function numOfFields() {
		debug("Fetching number of fields...", 6);
		return mysqli_num_fields($this->result);
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
		$field = mysqli_fetch_field($this->result);
		return $field ? $field : NULL;
	}

	final public function fetchFields() {
		debug("Fetching all fields ...", 6);
		$fields = mysqli_fetch_fields($this->result);
		return $fields ? $fields : array();
	}

	final public function fetchRow( $type = FETCH_OBJ ) {
		debug("Fetching next row ...", 6);
		$row = NULL;
		switch( $type ) {
			case FETCH_ARRAY:
				$row = mysqli_fetch_assoc($this->result);
				break;
			case FETCH_VALUES:
				$row = mysqli_fetch_row($this->result);
				break;
			case FETCH_OBJ:
				$row = mysqli_fetch_object($this->result, 'Std');
				break;
		}
		if( !$row ) return NULL;
		$i = 0;
		foreach($row as $value) {
			$this->bind_results[$i] = $value;
			$i++;
		}
	 	return $row;
	}

	final public function fetchRows( $type = FETCH_OBJ ) {
		debug("Fetching all rows ...", 6);
		$this->reset();
		$rows = array();
		for($i = 0; $i < $this->numOfRows(); $i++) {
			$rows[] = $this->fetchRow($type);
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
		mysqli_data_seek($this->result, 0);
		mysqli_field_seek($this->result, 0);
	}

	final public function free() {
		debug("Freeing result set resources ...", 6);
		mysqli_free_result($this->result); //no return value
	}

	final public function bindResults(array $bind_results) {
		debug("Binding output parameters ...", 6);
		$this->bind_results = $bind_results;
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
		debug("Destroying MySQLDatabaseResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->free();
	}
}
?>