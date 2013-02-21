<?php
final class ODBCDatabaseResult extends Object implements DatabaseResult {

	private $stmt;
	private $row_i;
	private $field_i;
	private $num_rows;
	private $bind_results;

	final public function __construct($stmt) {
		parent::__construct();
		debug("Initializing ODBCDatabaseResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->stmt = $stmt;
		$this->row_i = 0;
		$this->field_i = 1;
		while( odbc_fetch_into($stmt, &$counter) ) $this->num_rows++;
		$this->reset();
	}

	final public function numOfRows() {
		debug("Fetching number of rows...", 6);
		return $this->num_rows;
		//return odbc_num_rows($this->stmt);
	}

	final public function numOfFields() {
		debug("Fetching number of fields...", 6);
		return odbc_num_fields($this->stmt);
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
		$field->name  = odbc_field_name($this->stmt, $this->field_i);
		$field->type  = odbc_field_type($this->stmt, $this->field_i);
		$field->length  = odbc_field_len($this->stmt, $this->field_i);
		$field->precision = odbc_field_precision($this->stmt, $this->field_i);
		$field->scale = odbc_field_scale($this->stmt, $this->field_i);
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
		debug("Fetching next row ...", 6);
		if($this->row_i > $this->numOfRows()) return NULL;
		$row = NULL;
		switch( $type ) {
			case FETCH_ARRAY:
				$row = odbc_fetch_array($this->stmt, $this->row_i++);
				break;
			case FETCH_VALUES:
				$row = array_values( mysqli_fetch_assoc($this->stmt, $this->row_i++) );
				break;
			case FETCH_OBJ:
				$row = odbc_fetch_object($this->stmt, $this->row_i++);
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
		$this->row_i = 1;
		$this->field_i = 1;
	}

	final public function free() {
		debug("Freeing result set resources ...", 6);
		odbc_free_result ($this->stmt); //always return true
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
		debug("Destroying ODBCDatabaseResult object # ".static::getClass()->getInstanceCount()."...", 6);
		$this->free();
	}
}
?>