<?php
class AlterTableStatement extends DatabaseStatement {

	private $tableName;
	private $options;
	
	public function name( String $tableName ) {
		$this->tableName = $tableName;
	}
	
	public function options( Hash $options ) {
		$this->options = $options;
	}
	
	public function sql() {
		return '';
	}
}
?>