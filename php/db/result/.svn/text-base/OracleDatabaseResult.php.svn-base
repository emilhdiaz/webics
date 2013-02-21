<?php

/*
 * OracleDatabaseResult
 *
 * DBResult implementation for the Oracle database.
 * To be used in conjunction with other OCI8 driver components.
 */

final class OracleDatabaseResult extends Object implements DatabaseResult {

	private $stmt;
	private $row_i;
	private $field_i;
	private $results;
	private $bind_results;

	final public function __construct($stmt) {
		parent::__construct();
		debug("Initializing OracleDatabaseResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->stmt = $stmt;
		$this->row_i = 0;
		$this->field_i = 1;
		$nrows = oci_fetch_all($this->stmt, $results, 0, -1, OCI_ASSOC);
		//if( $nrows == FALSE ) throw new AbnormalExecutionException();
		$this->results = array();
		for ($i = 0; $i < $nrows; $i++) {
	      foreach ($results as $field=>$data) {
	         $this->results[$i][$field] = $data[$i];
	      }
	   	}
	}

	final public function numOfRows() {
		debug("Fetching number of rows...", 6);
		return oci_num_rows($this->stmt);
	}

	final public function numOfFields() {
		debug("Fetching number of fields...", 6);
		return oci_num_fields($this->stmt);
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
		debug("Fetching next field...", 6);
		if($this->field_i > $this->numOfFields()) return NULL;
		$field = new Std();
		$field->name  = oci_field_name($this->stmt, $this->field_i);
		$field->type  = oci_field_type($this->stmt, $this->field_i);
		$field->length  = oci_field_size($this->stmt, $this->field_i);
		$field->precision = oci_field_precision($this->stmt, $this->field_i);
		$field->scale = oci_field_scale($this->stmt, $this->field_i);
		$this->field_i++;
		return $field;
	}

	final public function fetchFields() {
		debug("Fetching all fields...", 6);
		$this->reset();
		$fields = array();
		for ($i = 0; $i < $this->numOfFields(); $i++) {
			$fields[] = $this->fetchField();
		}
		return $fields;
	}

	final public function fetchRow( $type = FETCH_OBJ ) {
		debug("Fetching next row...", 6);
		if($this->row_i >= $this->numOfRows()) return NULL;
		$row = NULL;
		switch( $type ) {
			case FETCH_ARRAY:
				$row = $this->results[$this->row_i++];
				break;
			case FETCH_VALUES:
				$row = array_values($this->results[$this->row_i++]);
				break;
			case FETCH_OBJ:
				$row = array_to_object($this->results[$this->row_i++]);
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
		debug("Fetching all rows...", 6);
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
		$this->row_i = 0;
		$this->field_i = 1;
	}

	final public function free() {
		debug("Freeing result set resources ...", 6);
		if( !oci_free_statement ($this->stmt) ) throw new AbnormalExecutionException();
	}

	final public function bindResults(array $bind_results) {
		debug("Binding output parameters ...", 6);
		$this->bind_results = $bind_results;
	}

	final public function __toString() {
		return print_r($this->fetch(), true);
	}
	
	final public function each( $closure ) {
		
	}

	final public function first() {
		
	}
	
	final public function last() {
		
	}	

	final public function __destruct() {
		debug("Destroying OracleDatabaseResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->free();
	}
}
?>