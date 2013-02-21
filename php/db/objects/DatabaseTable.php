<?php
class DatabaseTable extends Object {
	
	private $db;
	private $loaded;
	private $tableName;
	private $isTemporary;
	private $checkExists;
	private $engine;
	private $autoIncrement;
	private $characterSet;
	private $collate;
	private $comment;
	private $tablespace;
	private $columns;
	private $primaryKey;
	private $uniqueKeys;
	private $foreignKeys;
	private $dependencies;
	
	public function __construct( Database $db, String $tableName ) {
		parent::__construct();
		$this->db = $db;
		$this->tableName = $tableName;
		$this->columns = new VArray();
		$this->uniqueKeys = new VArray();
		$this->foreignKeys = new VArray();
	}
	
	public function addColumn( DatabaseColumn $column ) {
		$this->columns[$column->name] = $column;
		
		if( $this->loaded ) 
			; #TODO: add alter table add column sql
	}
	
	public function alterColumn( DatabaseColumn $column ) {
		$this->columns[$column->name] = $column;
		
		if( $this->loaded )
			; #TODO: add alter table modify column sql
	}
	
	public function renameColumn( $oldColumnName, $newColumnName ) {
		$column = $this->columns[$oldColumnName];
		unset($this->columns[$oldColumnName]);
		$column->name = $newColumnName;
		$this->columns[$column->name] = $column;
		
		if( $this->loaded ) 
			; #TODO: add alter table rename column sql
	}
	
	public function setPrimaryKey( DatabasePrimaryKey $primaryKey ) {
		$this->primaryKey = $primaryKey;
		
		if( $this->loaded )
			; #TODO: add alter table modify column sql or drop/add primary key 
	}
	
	public function addUniqueKey( DatabaseUniqueKey $uniqueKey ) {
		$this->uniqueKeys[] = $uniqueKey;
		
		if( $this->loaded )
			; #TODO: add alter table add unique constraint
	}
	
	public function addForeignKey( DatabaseForeignKey $foreignKey ) {
		$this->foreignKeys[] = $foreignKey;
		
		if( $this->loaded )
			; #TODO: add alter table add foreign key constraint
	}
	
	public function recreate() {
		$this->drop();
		$this->create();
	}
	
	public function create() {
		$createTable = $this->db->newCreateTableStatement();
		$createTable->name($this->tableName);
		$createTable->primaryKey($this->primaryKey);
		$createTable->columns($this->columns);
		$createTable->uniqueKeys($this->uniqueKeys);
		$createTable->foreignKeys($this->foreignKeys);
		println("** Creating table for $this->tableName **\n");
		println($createTable);
		$createTable->execute();
		return $createTable;
	}
	
	public function drop( $force = false ) {
		$dropTable = new DropTableStatement();
		$dropTable->name($this->tableName);
		$dropTable->options(array('checkExists'=>true));
		println($dropTable);
		return $this->db->execute($dropTable);
	}
	
	public function insert( Traversor $data ) {
		$insert = $this->db->newInsertStatement();
		$insert->table($this->tableName);
		$insert->data($data);
		return $insert->execute();
	}
	
	public function select( $cols, $where = null ) {
		
	}
	
	public function update( Hash $data, Hash $conditions ) {
		$update = $this->db->newUpdateStatement();
		$update->table($this->tableName);
		$update->data($data);
		$update->where($conditions);
		return $update->execute();
	}
	
	public function delete( Hash $conditions ) {
		$delete = $this->db->newDeleteStatement();
		$delete->table($this->tableName);
		$delete->where($conditions);
		return $delete->execute();
	}
	
	public function exists( Hash $conditions ) {
		
	}
	
	#TODO perform select * and hook into result set each method
	public function each( Closure $closure ) {
		
	}
	
	final public function first() {
		
	}
	
	final public function last() {
		
	}
	
	final public function all() {
		
	}
}
?>