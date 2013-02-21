<?php
class DropTableStatement extends DatabaseStatement {

	private $tableName;
	private $options;
	private $cascade = DatabaseSQLBuilder::CASCADE;
	
	public function name( String $tableName ) {
		$this->tableName = $tableName;
	}
	
	public function options( Hash $options ) {
		$this->options = $options;
	}
	
	public function sql() {
		return $this->builder->dropTable($this->tableName, $this->cascade, $this->options);
	}
}
?>