<?php
namespace unittests;

class Publisher extends \DAOEntity {
	
	/**
	 * @var String
	 * @required
	 */
	protected $name;
	
	/**
	 * @var String
	 * @required
	 */
	protected $city;
	
	/**
	 * @var String
	 * @required
	 */
	protected $state;
}
?>