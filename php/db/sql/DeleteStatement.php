<?php
class DeleteStatement extends DatabaseStatement {
	
	private $tableName;
	private $conditions;
	private $orderBy;
	private $topN;
	
	public function table( String $tableName ) {
		$this->tableName = $tableName;
		return $this;
	}
	
	public function where( Hash $conditions ) {
		$this->conditions = $conditions;
		return $this;
	}
	
	public function order( VArray $columns ) {
		$this->orderBy = $columns;
		return $this;
	}
	
	public function top( Integer $n ) {
		$this->topN = $n;
		return $this;
	}	
	
	public function execute() {
		return $this->db->quick($this, $this->conditions);
	}
	
	public function sql() {
		$sql = $this->builder->delete($this->tableName);
		
		if( $this->conditions )
			$sql->append( $this->builder->where($this->conditions) );
			
		if( $this->orderBy )
			$sql->append( $this->builder->order($this->orderBy) );
			
		if( $this->topN ) 
			$sql->append( $this->builder->top($this->$topN) );
			
		return $sql;
	}
}
?>