<?php
interface DataAccessObject {

	public function load( String $sources, Hash $key, VArray $properties );

	public function create( String $source, Hash $key, Hash $properties );

	public function update( String $source, Hash $key, Hash $properties );

	public function delete( String $source, Hash $key );
}

class DataAccessObjectException extends WebicsException{}
?>