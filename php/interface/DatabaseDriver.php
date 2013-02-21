<?php
interface DatabaseDriver {
	
	public function connect( DatabaseServer $srv );
	
	public function active( $database );
	
	public function execute( DatabaseStatement $statement );
	
	public function prepare( DatabaseStatement $statement, array $bind );
	
	public function hasResult();
	
	public function insertID();
	
	public function transaction();
	
	public function autocommit();
	
	public function commit();
	
	public function rollback();
	
	public function error();	
	
	public function disconnect();	
}
?>