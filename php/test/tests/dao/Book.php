<?php
namespace unittests;

class Book extends \DAOEntity {

	/**
	 * @alias isbn
	 */
	protected $isbn13;
	
	/**
	 * @var BigInt
	 * @key
	 */
	protected $isbn;
	
	/**
	 * @var String
	 * @required
	 */
	protected $title;
	
	/**
	 * @alias price
	 */
	protected $msrp;
	
	/**
	 * @var Money
	 * @required
	 */
	protected $price;
	
	/**
	 * @var Timestamp
	 * @default Now
	 * @required
	 */
	protected $publishedOn;
	
	/**
	 * @var unittests\Publisher
	 * @constant
	 * @unique
	 */
	protected $publisher;
	
	/**
	 * @var unittests\Publisher
	 */
	protected $altPublisher;
	
	
	/**
	 * @var unittests\Publication[]
	 * @relationship
	 */
	protected $publications;
	
	/**
	 * @var unittests\Chapter[]
	 * @dependent
	 */
	protected $chapters;
}

?>