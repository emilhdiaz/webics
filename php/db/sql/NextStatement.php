<?php
class NextStatement extends DatabaseStatement {
	
	private $tableName;
	private $columns;
	private $conditions;
	private $group;
	
	public function tables( VArray $tableNames ) {
		$this->tableNames = $tableNames;
		return $this;
	}
	
	public function columns( VArray $columns ) {
		$this->columns = $columns;
		return $this;
	}
	
	public function group( VArray $columns ) {
		$this->group = $columns;
		return $this;
	}
	
	public function where( Hash $conditions ) {
		$this->conditions = $conditions;
		return $this;
	}
	
	public function execute() {
		return $this->db->locate($this, $this->conditions);			
	}

	public function sql() {
		return $this->builder->select($this->tableNames, $this->columns, $this->conditions, $this->group);
	}
}
?>