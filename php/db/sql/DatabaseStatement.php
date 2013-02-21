<?php
abstract class DatabaseStatement extends Object {
	
	protected $db;
	protected $builder;
	
	public function __construct( Database $db ) {
		parent::__construct();
		$this->db = $db;
		$builder = $db->type().'SQLBuilder';
		$this->builder = new $builder;
	}
	
	public function execute() {
		return $this->db->execute($this);	
	}
	
	public function __toString() {
		return $this->sql()->str();
	}
	
	abstract public function sql();
}