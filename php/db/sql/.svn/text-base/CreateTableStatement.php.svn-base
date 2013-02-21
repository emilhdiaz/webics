<?php
class CreateTableStatement extends DatabaseStatement {
	
	private $tableName;
	private $options;
	private $columns;
	private $primaryKey;
	private $uniqueKeys;
	private $foreignKeys;
	
	public function name( String $tableName ) {
		$this->tableName = $tableName;
	}
	
	public function options( Hash $options ) {
		$this->options = $options;
	}
	
	public function columns( Varray $columns ) {
		$this->columns = $columns;
	}
	
	public function primaryKey( DatabasePrimaryKey $primaryKey ) {
		$this->primaryKey = $primaryKey;
	}
	
	public function uniqueKeys( Varray $uniqueKeys ) {
		$this->uniqueKeys = $uniqueKeys;
	}
	
	public function foreignKeys( VArray $foreignKeys ) {
		$this->foreignKeys = $foreignKeys;
	}
	
	public function sql() {
		return $this->builder->createTable($this->tableName, $this->columns, $this->primaryKey, $this->uniqueKeys, $this->foreignKeys, $this->options);
	}
}
?>