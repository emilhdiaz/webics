<?php
abstract class DatabaseSQLBuilder extends  Object {
	
	const CONDITIONAL_AND = ' AND ';
	const CONDITIONAL_OR = ' OR ';
	
	const EQUAL = '=';
	const NOT_EQUAL = '!=';
	const CONTAINING = 'LIKE';
	const NOT_CONTAINING = 'NOT LIKE';
	const LESS_THAN = '<';
	const LESS_THAN_OR_EQUAL = '<=';
	const GREATER_THAN = '>';
	const GREATER_THAN_OR_EQUAL = '>=';
	const NULL = 'IS NULL';
	
	const ASC = 'ASC';
	const DESC = 'DESC';
	
	const RESTRICT = 'RESTRICT';
	const CASCADE = 'CASCADE';
	
	const INNER = 'INNER';
	const OUTER = 'OUTER';
	const LEFT = 'LEFT';
	const RIGHT = 'RIGHT';
	
	abstract function insert( String $tableName, VArray $values, VArray $columns = null );
	
	abstract function update( String $tableName, Hash $values );
	
	abstract function where( Hash $conditions, $operator = DatabaseSQLBuilder::CONDITIONAL_AND, $junction = DatabaseSQLBuilder::EQUAL );
	
	abstract function order( VArray $columns, $direction = DatabaseSQLBuilder::ASC );
}
?>