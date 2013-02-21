<?php
class DatabaseForeignKey extends Object {

	public $symbol;
	public $columns;
	public $refTable;
	public $refColumns;
	public $match;
	public $onDelete;
	public $onUpdate;
	
	public function __construct( array $columns, $refTable, array $refColumns ) {
		$this->columns = $columns; 
		$this->refTable = $refTable;
		$this->refColumns = $refColumns;
	}
}
?>