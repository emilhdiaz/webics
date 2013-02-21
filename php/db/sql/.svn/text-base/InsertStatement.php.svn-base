<?php
class InsertStatement extends DatabaseStatement {
	
	private $tableName;
	private $values;
	
	public function table( String $tableName ) {
		$this->tableName = $tableName;
		return $this;
	}
	
	public function data( Traversor $values ) {
		$this->values = $values;
		return $this;
	}
	
	public function execute() {
		return $this->db->quick($this, $this->values);
	}
	
	public function sql() {
		if( $this->values instanceOf Hash )
			return $this->builder->insert($this->tableName, $this->values->values(), $this->values->keys());
		else
			return $this->builder->insert($this->tableName, $this->values);
	}
}
?>