<?php
class DatabaseColumn extends Object {
	
	public $name;
	public $dataType;
	public $default;
	public $comment;
	public $isNotNull;
	public $isUnique;
	public $isPrimaryKey;
	public $isAutoIncrement;
	
	public function __construct( $name, $dataType ) {
		$this->name = $name;
		$this->dataType = $dataType;
	}
}
?>
