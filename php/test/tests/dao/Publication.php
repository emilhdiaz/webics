<?php
namespace unittests;

class Publication extends \DAOEntity {
	
	/**
	 * @var unittests\Author
	 * @key
	 */
	protected $author;
	
	/**
	 * @var unittests\Book
	 * @key
	 */
	protected $book;
}

?>