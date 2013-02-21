<?php
namespace unittests;

class Author extends \DAOEntity {

	/**
	 * @var String
	 * @required
	 */
	protected $firstName;
	
	/**
	 * @var String
	 */
	protected $middleName;

	/**
	 * @var String
	 * @required
	 */
	protected $lastName;
	
	/**
	 * @var Boolean
	 * @default true
	 * @required
	 */
	protected $isAlive;
	
	/**
	 * @var Timestamp
	 * @constant
	 */
	protected $bornOn;
	
	/**
	 * @var SocialSecurityNumber
	 * @restricted (DAOEntityUnitTest)
	 * @constant
	 * @unique
	 */
	protected $ssn;
	
	/**
	 * @var Integer
	 * @restricted (NoOne)
	 */
	protected $ba;
	
	/**
	 * @var unittests\Publication[]
	 * @relationship
	 */
	protected $publications;
	
	public function __toString() {
		return $this->firstName.' '.$this->lastName;
	}
}	
?>