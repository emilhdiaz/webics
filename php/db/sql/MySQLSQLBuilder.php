<?php
class MySQLSQLBuilder extends DatabaseSQLBuilder {
	
	private $usePlaceholders;
	
	public function __construct($usePlaceholders = true) {
		$this->usePlaceholders = $usePlaceholders;
	}
	
	public function select( String $tableName, VArray $columns ) {
		return new String("SELECT ".$columns->join(',')." FROM ".$tableName);
	}
	
	
	public function next( String $tableName, VArray $columns, Hash $conditions, VArray $group ) {
		$commonColumns = new Hash();
		$commonColumns->combine($group->arr(), $group->arr());
		$commonColumns->prefixKeys('A.');
		$commonColumns->prefex('B.');
		
		if( $this->usePlaceholders ) {
			$conditions = clone $conditions;
			$conditions->fill('?');
		}
		
		$sql .= "SELECT ".$columns->join(',')." FROM (\n";
		$sql .= " SELECT B.* FROM $tableName A, $tableName B ";
		$sql .= $this->where($conditions)." ";
		$sql .= " AND ".$commonColumns->join(DatabaseSQLBuilder::EQUAL, DatabaseSQLBuilder::CONDITIONAL_AND);
		$sql .= "AND A.Order < B.Order ";
		$sql .= "ORDER BY B.Order ASC LIMIT 1";
		$sql .= "\n)";

		$conditions->join(DatabaseSQLBuilder::CONDITIONAL_AND, DatabaseSQLBuilder::EQUAL);
		
		return new String($sql);
	}	
	
	public function insert( String $tableName, VArray $values, VArray $columns = null ) {
		if( $this->usePlaceholders ) {
			$values = clone $values;
			$values->fill('?');
		}
		return new String("INSERT INTO $tableName ".t($columns, $columns)." VALUES ".$values);
	}
	
	public function update( String $tableName, Hash $values ) {
		if( $this->usePlaceholders ) {
			$values = clone $values;
			$values->fill('?');
		}
		return new String("UPDATE $tableName SET ".$values->join(',', '='));
	}
	
	public function delete( String $tableName ) {
		return new String("DELETE FROM $tableName");
	}
	
	public function where( Hash $conditions, $operator = DatabaseSQLBuilder::EQUAL, $junction = DatabaseSQLBuilder::CONDITIONAL_AND  ) {
		if( $this->usePlaceholders ) {
			$conditions = clone $conditions;
			$conditions->fill('?');
		}
		return new String(" WHERE ".$conditions->join($junction, $operator));
	}
	
	public function join( Hash $tableNames ) {
		$sql = '';
		foreach( $tablesNames as $tableName=>$options ) {
			$sql .= " ".$options->get('type', DatabaseSQLBuilder::INNER)."JOIN ".$tableName." ON ".$options->left;
		}
	}
	
	public function order( VArray $columns, $direction = DatabaseSQLBuilder::ASC ) {
		return new String(" ORDER BY ".$columns->join(',')." $direction");
	}
	
	public function top( Integer $n ) {
		return new String(" LIMIT $n");
	}
	
	public function dropTable( String $tableName, $dependencies = DatabaseSQLBuilder::RESTRICT, Hash $options ) {
		$sql = "DROP ". t($options['isTemporary'], 'TEMPORARY') ."TABLE ". t($options['checkExists'], 'IF EXISTS') ."`$tableName` $dependencies\n";
		return new String($sql);
	}
	
	public function createTable( String $tableName, VArray $columns, DatabasePrimaryKey $primaryKey, VArray $uniqueKeys, VArray $foreignKeys, Hash $options ) {
		$sql = "CREATE ". t($options['isTemporary'], 'TEMPORARY') ."TABLE ". t($options['checkExists'], 'IF NOT EXISTS') ."`$tableName` (\n";
		
		$definitions = array();
		
		foreach( $columns as $column ) {
			$definitions[] = " `$column->name` $column->dataType"
					.t($column->isNotNull, ' NOT NULL')
					.t($column->default, ' DEFAULT '.$column->default)
					.( (!$column->isNotNull && !$column->default) ? ' DEFAULT NULL' : null )
					.t($column->isAutoIncrement, ' AUTO_INCREMENT')
					.t($column->isUnique, ' UNIQUE KEY')
					.t($column->isPrimaryKey, ' PRIMARY KEY')
					.t($column->comment, ' COMMENT \''.$column->comment.'\'');
		}
		
		if( $primaryKey ) {
			$definitions[] = " CONSTRAINT ". ($primaryKey->symbol ? $primaryKey->symbol : 'PK_'.$tableName)
					." PRIMARY KEY ". t($primaryKey->indexType, $primaryKey->indexType) ." (" .implode(',', $primaryKey->columns). ")";
		}
					
		foreach( $uniqueKeys as $uniqueKey ) {
			$definitions[] = " CONSTRAINT ". ($uniqueKey->symbol ? $uniqueKey->symbol : 'UK_'.$tableName.'_'.implode('_', $uniqueKey->columns)) 
					." UNIQUE ". t($uniqueKey->indexType, $uniqueKey->indexType) ." (" .implode(',', $uniqueKey->columns). ")";
		}
		
		foreach( $foreignKeys as $foreignKey ) {
			$definitions[] = " CONSTRAINT ". ($foreignKey->symbol ? $foreignKey->symbol : 'FK_'.$tableName.'_'.implode('_', $foreignKey->columns))
					." FOREIGN KEY (" .implode(',', $foreignKey->columns). ")"
					." REFERENCES $foreignKey->refTable (" .implode(',', $foreignKey->refColumns). ")"
					.t($foreignKey->match, ' MATCH '.$foreignKey->match)
					.t($foreignKey->onDelete, ' ON DELETE '.$foreignKey->onDelete)
					.t($foreignKey->onUpdate, ' ON UPDATE '.$foreignKey->onUpdate);
		}
		$sql .= implode(",\n", $definitions)."\n) ENGINE=InnoDB\n";
		return new String($sql);
	}
}
?>