<?php
#TODO: add regex match function
#TODO: Be aware of hardcoding numerical or string values
enum('E_Quotestyle',
	array(
		ENT_NOQUOTES=>'NO_QUOTES',
		ENT_QUOTES	=>'BOTH_QUOTES',
		ENT_COMPAT	=>'DOUBLE_QUOTES'
	)
);
enum('E_Charset',
	array(
		'ISO-8859-1' =>'ISO88591',
		'ISO-8859-15'=>'ISO885915',
		'UTF-8'		 =>'UTF8',
	)
);
enum('E_Breakstyle',
	array(
		"\n"	=>'NL',
		'<br />'=>'BR'
	)
);
enum('E_Direction',
	array(
		'BOTH',
		'LEFT',
		'RIGHT'
	)
);

class String extends Object {

	/**
	 * @var string
	 * @test
	 * @too 2
	 */
	private $string;
	const nativeType = 'string';

	/************************
	 * 	   Magic Methods    *
	 ************************/

	/**
	 * __construct()
	 *
	 * Magic Method: String class constructor that accepts a native PHP
	 * string, a String object, or a formatted string/String and a Set
	 * of substitute arguments.
	 *
	 * @param  String|string 	$string - The string to be formatted
	 * @param  VArray			$args 	- The arguments to substitute in.
	 * @return String
	 */
	public function __construct( $string, VArray $args = null ) {
		parent::__construct();
		
		$string = static::validate($string);

		/* Assign the string value */
		if( !is_null($args) )
			$this->string = (string) vsprintf($string, $args->arr());
		else
			$this->string = $string;
	}

	/**
	 * __destruct()
	 *
	 * Magic Method: String class destructor that unsets the underlying
	 * native PHP string.
	 *
	 * @param  void
	 * @return void
	 */
	public function __destruct() {
		unset($this->string);
	}

	/**
	 * __toString()
	 *
	 * Magic Method: String class native PHP string representation to be
	 * used in string operations by the PHP translator.
	 *
	 * @param  void
	 * @return string
	 */
	public function __toString() {
		return (string) $this->string;
	}

	/************************
	 * 	   	  Export 		*
	 ************************/

	/**
	 * str()
	 *
	 * String class native PHP string representation to be
	 * used in string operations programmatically.
	 *
	 * @param  void
	 * @return string
	 */
	public function str() {
		return (string) $this->string;
	}

	/**
	 * toString()
	 *
	 * Return reference to this String object.
	 *
	 * @param  void
	 * @return String
	 */
	public function toString() {
		return $this;
	}

	/**
	 * toVArray()
	 *
	 * Return the string as an VArray of characters.
	 *
	 * @param  void
	 * @return VArray
	 */
	public function toVArray() {

		/* Split the string by character into a native array */
		$array = (array) str_split($this->string);

		/* New VArray object */
		$varray = new VArray($array);

		return $this->objectString($varray);
	}

	/**
	 * toInteger()
	 *
	 * Return the string as an Integer (when applicable).
	 *
	 * @param  void
	 * @return Integer
	 */
	public function toInteger() {
		return new Integer((int) $this->string);
	}

	/**
	 * toFloat()
	 *
	 * Return the string as an Float (when applicable).
	 *
	 * @param  void
	 * @return Float
	 */
	public function toFloat() {
		return new Float((float) $this->string);
	}

	/**
	 * toBoolean()
	 *
	 * Return the string as an Boolean (when applicable).
	 *
	 * @param  void
	 * @return Boolean
	 */
	public function toBoolean() {
		return new Boolean($this->string);
	}

	/************************
	 * 	    Encodings 	    *
	 ************************/

	/**
	 * escape()
	 *
	 * Escape any single character or a range of characters.
	 *
	 * @param  String|string 	$charlist - The list of characters to escape
	 * @return String
 	 */
	public function escape( String $charlist ) {
		$this->string = (string) addcslashes($this->string, $charlist->str());
		return $this;
	}

	/**
	 * escapeQuotes()
	 *
	 * Escape quote characters ' " \.
	 *
	 * @param  void
	 * @return String
	 */
	public function escapeQuotes() {
		$this->string = (string) addslashes($this->string);
		return $this;
	}

	/**
	 * escapeMeta()
	 *
	 * Escape meta characters . \ + * ? [ ^ ] ( $ ).
	 *
	 * @param  void
	 * @return String
	 */
	public function escapeMeta() {
		$this->string = (string) quotemeta($this->string);
		return $this;
	}

	/**
	 * escapePreg()
	 *
	 * Escape regular expression characters . \ + * ? [ ^ ] $ ( ) { } = ! < > | :
	 *
	 * @param  void
	 * @return String
	 */
	public function escapePreg() {
		$this->string = (string) preg_quote($this->string, $delimiter);
		return $this;
	}

	/**
	 * stripSlashes()
	 *
	 * Remove backslashes used to escape characters. Recognizes
	 * C-like \n, \r ..., octal and hexadecimal representation.
	 *
	 * @param  void
	 * @return String
	 */
	public function stripSlashes() {
		$this->string = (string) stripcslashes($this->string);
		return $this;
	}

	/**
	 * stripTags()
	 *
	 * Strip HTML and PHP tags from a string
	 * (including content contained within PHP tags).
	 *
	 * @param  void
	 * @return String
	 */
	public function stripTags() {
		$this->string = (string) strip_tags($this->string);
		return $this;
	}

	/**
	 * encodeURL()
	 *
	 * URL-encodes the string. Encodes special character
	 * such as ? = + for use in URL components.
	 *
	 * @param  void
	 * @return String
	 */
	public function encodeURL() {
		$this->string = (string) urlencode($this->string);
		return $this;
	}

	/**
	 * decodeURL()
	 *
	 * URL-decode the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function decodeURL() {
		$this->string = (string) urldecode($this->string);
		return $this;
	}

	/**
	 * encodeHTML()
	 *
	 * Convert all applicable characters to HTML entities.
	 *
	 * @param  E_Quotestyle	$quotestyle - Lets you define what will be done with 'single' and "double" quotes
	 * @param  E_Charset	$charset 	- Define the character set used in conversion
	 * @return String
	 */
	public function encodeHTML( E_Quotestyle $quotestyle, E_Charset $charset ) {
		$this->string = (string) htmlentities($this->string, $quotestyle->value(), $charset->value());
		return $this;
	}

	/**
	 * decodeHTML()
	 *
	 * Convert all HTML entities to their applicable characters.
	 *
	 * @param  E_Quotestyle $quotestyle - Lets you define what will be done with 'single' and "double" quotes
	 * @param  E_Charset	$charset 	- Define the character set used in conversion
	 * @return String
	 */
	public function decodeHTML( E_Quotestyle $quotestyle, E_Charset $charset ) {
		$this->string = html_entity_decode($this->string, $quotestyle->value(), $charset->value());
		return $this;
	}

	/**
	 * encodeUU()
	 *
	 * Uuencode the string with a 6-bit encoding for safe
	 * transfer through systems that are not 8-bit safe.
	 *
	 * @param  void
	 * @return String
	 */
	public function encodeUU() {
		$this->string = (string) convert_uuencode($this->string);
		return $this;
	}

	/**
	 * decodeUU()
	 *
	 * Decode the uuencoded string.
	 *
	 * @param  void
	 * @return String
	 */
	public function decodeUU() {
		$this->string = (string) convert_uudecode($this->string);
		return $this;
	}

	/**
	 * encodeBase64()
	 *
	 * Base64 encode the string with a 7-bit encoding for safe
	 * transfer through systems that are not 8-bit safe.
	 *
	 * @param  void
	 * @return String
	 */
	public function encodeBase64() {
		$this->string = (string) base64_encode($this->string);
		return $this;
	}

	/**
	 * decodeBase64()
	 *
	 * Decode the base64 string.
	 * @param  void
	 * @return String
	 */
	public function decodeBase64() {
		$this->string = (string) base64_decode($this->string);
		return $this;
	}

	/**
	 * encodeQP()
	 *
	 * Quote-printable encode the string for safe transfer
	 * through systems that are not 8-bit safe.
	 * NOTE: This method uses a URL encoding function.
	 *
	 * @param  void
	 * @return String
	 */
	public function encodeQP() {
		$this->string = (string) rawurlencode($this->string);
  		$this->string = (string) str_replace("%","=",$this->string);
  		return $this;
	}

	/**
	 * decodeQP()
	 *
	 * Decode the quote-printable string.
	 *
	 * @param  void
	 * @return String
	 */
	public function decodeQP() {
		$this->string = (string) quoted_printable_decode($this->string);
		return $this;
	}

	/************************
	 * 	    Modifiers 	    *
	 ************************/

	/**
	 * set()
	 *
	 * Generate a formated string from the arguments array passed in.
	 *
	 * @param  String|string 	$string - The string to be formatted
	 * @param  VArray			$args 	- The arguments to substitute in.
	 * @return String
	 */
	public function set( $string, VArray $args = null ) {
		$string = static::validate($string);

		if( !is_null($args) )
			$this->string = (string) vsprintf($string, $args->arr());
		else
			$this->string = (string) $string;

		return $this;
	}

	/**
	 * wrap()
	 *
	 * Wraps the string to a given number of characters.
	 *
	 * @param  XIntegr 		$width 	- The column width
	 * @param  E_Breakstyle $break 	- The breaking character, defaults to '\n'
	 * @param  Boolean 		$cut 	- If true, the word will be cut to match column width
	 * @return String
	 */
	public function wrap( Integer $width, E_Breakstyle $break, Boolean $cut ) {
		$this->string = (string) wordwrap($this->string, $width->int(), $break->value(), $cut->bool() );
		return $this;
	}

	/**
	 * br()
	 *
	 * Inserts HTML line breaks before all newlines in the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function br() {
		$this->string = (string) nl2br($this->string);
		return $this;
	}

	/**
	 * trim()
	 *
	 * Strip whitespace (tab, new line, carriage return, and NUL-byte) from the string.
	 *
	 * @param  E_Direction 	$direction 	- Lets you define which end of the string to trim
	 * @return String
	 */
	public function trim( E_Direction $direction ) {
		switch($direction) {
			case E_Direction::BOTH():
				$this->string = (string) trim($this->string);
				break;
			case E_Direction::RIGHT():
				$this->string = (string) rtrim($this->string);
				break;
			case E_Direction::LEFT():
				$this->string = (string) ltrim($this->string);
				break;
		}
		return $this;
	}

	/**
	 * truncate()
	 *
	 * Truncate the string based on an offset.
	 *
	 * @param  Integer		$offset 	- The offset to cut at
	 * @param  E_Direction 	$direction 	- The side of the cut to keep
	 * @return String
	 */
	public function truncate( Integer $offset, E_Direction $direction ) {
		switch($direction) {
			case E_Direction::LEFT():
				$this->string = (string) $this->substring(new Integer(0), $offset);
				break;
			case E_Direction::RIGHT():
				$this->string = (string) $this->substring($offset, $this->length());
				break;
		}
		return $this;
	}

	public function pop( Integer $size ) {
		$sub = $this->substring($size->negate(), $this->length());
		$this->truncate($size, E_Direction::LEFT());
		return $sub;
	}

	public function shift( Integer $size ) {
		$sub = $this->substring(new Integer(0), $size);
		$this->truncate($size, E_Direction::RIGHT());
		return $sub;
	}

	/**
	 * pad()
	 *
	 * Pad the string to a certain length with another string.
	 * @param  Integer 		$pad_length - Length of pad string or larger
	 * @param  String 		$pad_string - Optional pad string
	 * @param  E_Direction 	$direction 	- Lets you define which end of the string to pad
	 * @return String
	 */
	public function pad( Integer $pad_length, String $pad_string, E_Direction $direction ) {
		switch($direction) {
			case E_Direction::BOTH():
				$this->string = (string) str_pad($this->string, $pad_length->int(), $pad_string->str(), STR_PAD_BOTH);
				break;
			case E_Direction::RIGHT():
				$this->string = (string) str_pad($this->string, $pad_length->int(), $pad_string->str(), STR_PAD_RIGHT);
				break;
			case E_Direction::LEFT():
				$this->string = (string) str_pad($this->string, $pad_length->int(), $pad_string->str(), STR_PAD_LEFT);
				break;
		}
		return $this;
	}

	/**
	 * repeat()
	 *
	 * Repeat the string.
	 *
	 * @param  Integer 	$multiplier - The number of times to repeat the string
	 * @return String
	 */
	public function repeat( Integer $multiplier ) {
		$this->string = (string) str_repeat($this->string, $multiplier->int());
		return $this;
	}

	/**
	 * exchange()
	 *
	 * Exchange all occurrences of the search string with the replacement string.
	 *
	 * @param  String 	$search 	- The string to search for
	 * @param  String 	$replacement- The string to replace with
	 * @param  Boolean	$case 		- If true the replacement will case sensitive
	 * @return String
	 */
	public function exchange( String $search, String $replacement, Boolean $case = NULL ) {
		if( is_null($case) ) $case = new Boolean(false);
		switch($case->bool()) {
			case true:
				$this->string = (string) str_replace($search->str(), $replacement->str(), $this->string, $count);
				break;
			case false:
				$this->string = (string) str_ireplace($search->str(), $replacement->str(), $this->string, $count);
				break;
		}
		return $this;
	}

	/**
	 * translate()
	 *
	 * Translate certain characters.
	 *
	 * @param  Hash 	$replace_pairs - The translation table
	 * @return XString
	 */
	public function translate( Hash $replace_pairs ) {
		$this->string = (string) strtr($this->string, $this->nativeString($replace_pairs)->arr());
		return $this;
	}

	/**
	 * replace()
	 *
	 * Replace a section of the string based on a position with another string.
	 *
	 * @param  String 	$replacement - The replacement string
	 * @param  Integer 	$offset 	 - The start position of the replacement
	 * @param  Integer 	$length 	 - The length of the replacement
	 * @return String
	 */
	public function replace( String $replacement, Integer $offset, Integer $length ) {
		$end = new Integer( $offset->int() + $length->int() );
		if( $end->compare($this->length()) == E_Comparison::GREATER_THAN() )
			$length = $this->length()->subtract($offset);
		$this->string = (string) substr_replace($this->string, $replacement->str(), $offset->int(), $length->int());
		return $this;
	}

	/**
	 * remove()
	 *
	 * Remove part of the string at a given offset.
	 *
	 * @param  Integer 	$offset - The position to start deleting
	 * @param  Integer	$length - The length of string to remove
	 * @return String
	 */
	public function remove( Integer $offset, Integer $length ) {
		$this->replace(new String(''), $offset, $length);
		return $this;
	}

	/**
	 * insert()
	 *
	 * Insert a string into this string at a given offset.
	 *
	 * @param  String 	$string - The string to insert
	 * @param  Integer 	$offset - The position to insert the string in
	 * @return String
	 */
	public function insert( String $string, Integer $offset ) {
		$this->replace($string, $offset, new Integer(0));
		return $this;
	}

	/**
	 * append()
	 *
	 * Append a string to the end of this string.
	 *
	 * @param  String 	$string - The string to insert
	 * @return String
	 */
	public function append( String $string ) {
		$this->string = (string) $this.$string;
		//$this->replace($string, $this->length(), new Integer(0));
		return $this;
	}

	/**
	 * prepend()
	 *
	 * Prepend a string to the beginning of this string.
	 *
	 * @param  String 	$string - The string to insert
	 * @return String
	 */
	public function prepend( String $string ) {
		$this->string = (string) $string.$this;
		//$this->replace($string, new Integer(0), new Integer(0));
		return $this;
	}

	/**
	 * clear()
	 *
	 * Removes all characters from the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function clear() {
		$this->string = null;
		return $this;
	}

	/**
	 * shuffle()
	 *
	 * Randomly shuffles the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function shuffle() {
		$this->string = (string) str_shuffle($this->string);
		return $this;
	}

	/**
	 * reverseBytes()
	 *
	 * Reverse the string by byte.
	 *
	 * @param  void
	 * @return String
	 */
	public function reverseBytes() {
		$this->string = (string) strrev($this->string);
		return $this;
	}

	/**
	 * reverseWords()
	 *
	 * Reverse the string by words.
	 *
	 * @param  void
	 * @return String
	 */
	public function reverseWords() {
		 $this->string = (string) implode(' ', $this->split(new String(' '))->reverse()->arr());
		 return $this;
	}

	/**
	 * lowercase()
	 *
	 * Makes the string lowercase
	 * @param  void
	 * @return String
	 */
	public function lowercase() {
		$this->string = (string) strtolower($this->string);
		return $this;
	}

	/**
	 * uppercase()
	 *
	 * Makes the string uppercase
	 * @param  void
	 * @return String
	 */
	public function uppercase() {
		$this->string = (string) strtoupper($this->string);
		return $this;
	}

	/**
	 * capitalize()
	 *
	 * Make the string's first character uppercase.
	 *
	 * @param  void
	 * @return String
	 */
	public function capitalize() {
		$this->lowercase();
		$this->string = (string) ucfirst($this->string);
		return $this;
	}

	/**
	 * capitalizeAll()
	 *
	 * Uppercase the first character of each word in the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function capitalizeAll() {
		$this->lowercase();
		$this->string = (string) ucwords($this->string);
		return $this;
	}

	/************************
	 * 	    Substrings	 	*
	 ************************/

	/**
	 * split()
	 *
	 * Split the string into smaller chunks based on a string delimeter
	 * or a perl compatible regular expression.
	 *
	 * @param  String 	$pattern - The string to use as the delimiter
	 * @return VArray
	 */
	public function split( String $pattern ) {

		$reg_delim = new String('/');

		/* Split the string by character into a native array */
		if( ($pattern->begins($reg_delim, new Boolean(false))->bool() === true) &&
			($pattern->ends($reg_delim, new Boolean(false))->bool() === true) )

			$array = (array) preg_split($pattern->str(), $this->string);
		else
			$array = (array) explode($pattern->str(), $this->string);

		/* New VArray object */
		$varray = new VArray();

		/* Import the native array into the VArray */
		$varray->import($array);

		return $this->objectString($varray);
	}

	/**
	 * chunk()
	 *
	 * Split the string into smaller chunks based on a chunk length.
	 *
	 * @param  Integer 	$length	- The size of each chunk
	 * @return VArray
	 */
	public function chunk( Integer $length ) {

		/* Split the string by character into a native array */
		$array = (array) str_split($this->string, $length->int());

		/* New VArray object */
		$varray = new VArray();

		/* Import the native array into the VArray */
		$varray->import($array);

		return $this->objectString($varray);
	}

	/**
	 * words()
	 *
	 * Return the words in the string and their positions.
	 *
	 * @param  String $charlist - A list of additional characters which will be considered as 'word'
	 * @return Hash
	 */
	public function words( String $charlist ) {

		/* Split the string by character into a native array */
		$array = (array) str_word_count($this->str(), 2, $charlist->str());

		/* New VArray object */
		$hash = new Hash($array);

		return $this->objectString($hash);
	}

	/**
	 * token()
	 *
	 * Tokenize a string.
	 *
	 * @param  String 	$token - A list of characters to use as tokens
	 * @param  Boolean 	$reset - Reset the scan
	 * @return String
	 */
	public function token( String $token, Boolean $reset = NULL ) {
		if( is_null($reset) ) $reset = new Boolean(false);
		switch($reset->bool()) {
			case true:
				$str = (string) strtok($this->string, $token->str());
				break;
			case false:
				$str = (string) strtok($token);
				break;
		}
		return $this->objectString($str);
	}

	/**
	 * substring()
	 *
	 * Return part of a string (a substring).
	 *
	 * @param  Integer 	$start 	- The starting position
	 * @param  Integer 	$length	- The number of characters after start to return.
	 * @return String
	 */
	public function substring( Integer $start, Integer $length ) {
		$str = (string) substr($this->string, $start->int(), $length->int());
		return $this->objectString($str);
	}

	/**
	 * after()
	 *
	 * Find and return a substring of this string starting from the last occurance
	 * of a character within this string.
	 *
	 * @param  String 	$char 		- The character to search for
	 * @param  Boolean 	$inclusive 	- Option to include the character in the result
	 * @param  Boolean 	$case 		- Option to search case-sensitive
	 * @return String
	 */
	public function after( String $char, Boolean $inclusive = NULL, Boolean $case = NULL ) {
		if( is_null($inclusive) ) $inclusive = new Boolean(false);
		$start = $this->locate($char, E_Direction::RIGHT(), $case);

		if( $start instanceOf Null )
			$start = $this->length();
		else
			if ($inclusive->bool() == false) $start->add($char->length());

		$length = $this->length()->subtract($start);
		return $this->substring($start, $length);
	}

	/**
	 * before()
	 *
	 * Find and return a substring of this string ending in the first occurance
	 * of a character within this string.
	 *
	 * @param  String 	$char 		- The character to search for
	 * @param  Boolean 	$inclusive 	- Option to include the character in the result
	 * @param  Boolean 	$case 		- Option to search case-sensitive
	 * @return String
	 */
	public function before( String $char, Boolean $inclusive = NULL, Boolean $case = NULL ) {
		if( is_null($inclusive) ) $inclusive = new Boolean(false);
		$end = $this->locate($char, E_Direction::LEFT(), $case);

		if( $end instanceOf Null )
			$end = new Integer(0);
		else
			if ($inclusive->bool() == true) $end->add($char->length());

		return $this->substring(new Integer(0), $end);
	}

	/**
	 * at()
	 *
	 * Return the character at the given index.
	 *
	 * @param  Integer 	$index - The index of the character
	 * @return String
	 */
	public function at( Integer $index ) {
		return $this->substring($index, new Integer(1));
	}

	/************************
	 * 	    Information	 	*
	 ************************/

	/**
	 * equals()
	 *
	 * Determines if the strings are equal.
	 *
	 * @param  String) 	$string - The string to compare against
	 * @param  Boolean	$case 	- If set to true the comparison will be case sensitive
	 * @return Boolean
	 */
	public function equals( String $string, Boolean $case = NULL ) {
		$equals = $this->compare($string, $case);
		return ($equals == E_Comparison::EQUAL_TO()) ? new Boolean(true) : new Boolean(false);
	}

	/**
	 * isEmpty()
	 *
	 * Check if the string is empty.
	 *
	 * @param  void
	 * @return Boolean
	 */
	public function isEmpty() {
		return $this->length()->isZero();
	}

	/**
	 * begins()
	 *
	 * Determines if the string begins with the provided string.
	 *
	 * @param  String 	$string - The string to compare against
	 * @param  Boolean	$case 	- If set to true the comparison will be case sensitive
	 * @return Boolean
	 */
	public function begins( String $string, Boolean $case = NULL ) {
		$equals = $this->compareSub($string, new Integer(0), $string->length(), $case);
		return ($equals == E_Comparison::EQUAL_TO()) ? new Boolean(true) : new Boolean(false);
	}

	/**
	 * ends()
	 *
	 * Determines if the string ends with the provided string.
	 *
	 * @param  String 	$string - The string to compare against
	 * @param  Boolean	$case 	- If set to true the comparison will be case sensitive
	 * @return Boolean
	 */
	public function ends( String $string, Boolean $case = NULL ) {
		$equals = $this->compareSub($string, $string->length()->negate(), $string->length(), $case);
		return ($equals == E_Comparison::EQUAL_TO()) ? new Boolean(true) : new Boolean(false);
	}

	/**
	 * contains()
	 *
	 * Determines if the string contains the provided string.
	 *
	 * @param String 	$string	- The string to search for
	 * @param Boolean	$case	- If true the search will be case sensitive
	 */
	public function contains( String $string, Boolean $case = NULL ) {
		return ($this->locate($string, E_Direction::LEFT(), $case) instanceOf Null) ? new Boolean(false) : new Boolean(true);
	}

	/**
	 * length()
	 *
	 * Return the string length.
	 *
	 * @param  void
	 * @return Integer
	 */
	public function length() {
		return new Integer( (int) strlen($this->string) );
	}

	/**
	 * wordcount()
	 *
	 * Count the number of words used in the string.
	 *
	 * @param  String 	$charlist - A list of additional characters which will be considered as 'word'
	 * @return Integer
	 */
	public function wordcount( String $charlist = null) {
		return new Integer( (int) str_word_count($this->string, 0, $charlist) );
	}

	/**
	 * uniquecount()
	 *
	 * Returns the number of unique characters in the string.
	 * This function is case sensitive.
	 *
	 * @param  void
	 * @return Integer
	 */
	public function uniquecount() {
		return new Integer( (int) count(count_chars($this->string, 1)) );
	}

	/**
	 * locate()
	 *
	 * Locate the position of the first or last occurence of
	 * a substring within this string.
	 *
	 * @param  String 		$string 	- The string to search for
	 * @param  E_Direction 	$direction 	- The direction to search, either beginning or end
	 * @param  Boolean 		$case 		- If true the search will be case sensitive
	 * @return Integer
	 */
	public function locate( String $string, E_Direction $direction, Boolean $case = NULL ) {
		if( is_null($case) ) $case = new Boolean(false);
		switch( $direction ) {
			case E_Direction::LEFT():
				if( $case->bool() == true )
					$pos = strpos($this->string, $string->str());
				else
					$pos = stripos($this->string, $string->str());
				break;

			case  E_Direction::RIGHT():
				if( $case->bool() == true )
					$pos = strrpos($this->string, $string->str());
				else
					$pos = strripos($this->string, $string->str());
				break;
		}
		return $pos !== false ? new Integer($pos) : new Null();
	}

	/**
	 * search()
	 *
	 * Find the location of the first or last occurance of any of the strings
	 * provided in the query. Strings should be separated by the | character.
	 *
	 * @param  String 		$query 		- The strings to search for
	 * @param  E_Direction	$direction	- The direction to search, either beginning or end
	 * @param  Boolean 		$case		- If true the search will be case sensitive
	 * @return Integer
	 */
	public function search( String $query, E_Direction $direction, Boolean $case ) {

		$delimeter = new String('|');

		/* Parse the query based on the "|" delimeter */
		$strings = $query->split($delimeter);
		$hash = new Hash();

		/* Locate each search string */
		foreach($strings as $string) {
			$key = $this->locate($string, $direction, $case);
			if( !($key instanceOf Null) )
				$hash->{$key->int()} = $string;
		}

		$keys = $hash->keys();

		/* Determine the first or last occurrance */
		switch($direction) {
			case E_Direction::LEFT():
				$pos = (int) min($keys->arr());
				break;
			case E_Direction::RIGHT():
				$pos = (int) max($keys->arr());
				break;
		}

		return new Integer($pos);
	}

	/**
	 * span()
	 *
	 * Find length of initial segment matching or not matching a mask.
	 * This function is case sensitive.
	 *
	 * @param  String 		$mask 		- All of the characters to look for.
	 * @param  E_Direction 	$direction 	- The direction to search, either beginning or end
	 * @param  Boolean 		$match 		- Flag to determine if looking for a match or no match
	 * @return Integer
	 */
	public function span( String $mask, E_Direction $direction, Boolean $match ) {
		switch( $direction ) {
			case E_Direction::LEFT():
				if( $match->bool() == true )
					$length = (int) strspn($this->string, $mask);
				else
					$length = (int) strcspn($this->string, $mask);
				break;

			case E_Direction::RIGHT():
				$str = clone $this;
				if( $match->bool() == true )
					$length = (int) strspn($str->reverseBytes(), $mask);
				else
					$length = (int) strcspn($str->reverseBytes(), $mask);
				break;
		}
		return new Integer($length);
	}

	/**
	 * frequency()
	 *
	 * Count the number of substring occurences.
	 *
	 * @param  String 	$string - The string to search for
	 * @return Integer
	 */
	public function frequency( String $string ) {
		return new Integer( (int) substr_count($this->string, $string) );
	}

	/**
	 * distance()
	 *
	 * Calculate Levenshtein distance between two strings.
	 * The Levenshtein distance is defined as the minimal
	 * number of characters you have to replace, insert or
	 * delete to transform this string into the target string.
	 *
	 * @param  String 	$target - The target string
	 * @return Integer
	 */
	public function distance( String $target ) {
		return new Integer( (int) levenshtein($this->string, $target) );
	}

	/**
	 * similarity()
	 *
	 * Calculate the similarity between two strings.
	 *
	 * @param  String 	$target - The target string
	 * @return Float
	 */
	public function similarity( Float $target) {
		similar_text($this->string, $target, $percent);
		return new Float((float) $percent);
	}

	/**
	 * metaphone()
	 *
	 * Calculate the metaphone key of a string.
	 *
	 * @param  void
	 * @return String
	 */
	public function metaphone() {
		return $this->objectString( (string) metaphone($this->string) );
	}

	/**
	 * soundex()
	 *
	 * Calculate the soundex key of a string.
	 * @param  void
	 * @return String
	 */
	public function soundex() {
		return $this->objectString( (string) soundex($this->string) );
	}

	/**
	 * compare()
	 *
	 * Binary safe string comparision.
	 *
	 * @param  String 	$string - The string to compare to
	 * @param  Boolean 	$case 	- If true the comparison will be case sensitive
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compare( String $string, Boolean $case = NULL ) {
		if( is_null($case) ) $case = new Boolean(false);
		switch( $case->bool() ) {
			case true:
				$equals = (int) strcmp($this->string, $string);
				break;
			case false:
				$equals = (int) strcasecmp($this->string, $string);
				break;
		}
		if( $equals < 0 )
			return E_Comparison::LESS_THAN();
		elseif( $equals == 0 )
			return E_Comparison::EQUAL_TO();
		elseif( $equals > 0 )
			return E_Comparison::GREATER_THAN();
		else
			throw new LogicException();
	}

	/**
	 * compareNat()
	 *
	 * String comparison using a "natural order" algorithm.
	 *
	 * @param  String 	$string - The string to compare to
	 * @param  Boolean 	$case 	- If true the comparison will be case sensitive
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compareNat( String $string, Boolean $case = NULL ) {
		if( is_null($case) ) $case = new Boolean(false);
		switch( $case->bool() ) {
			case true:
				$equals = (int) strnatcmp($this->string, $string);
				break;
			case false:
				$equals = (int) strnatcasecmp($this->string, $string);
				break;
		}
		if( $equals < 0 )
			return E_Comparison::LESS_THAN();
		elseif( $equals == 0 )
			return E_Comparison::EQUAL_TO();
		elseif( $equals > 0 )
			return E_Comparison::GREATER_THAN();
		else
			throw new LogicException();
	}

	/**
	 * compareN()
	 *
	 * Binary safe string comparison of the first n characters.
	 *
	 * @param  String 	$string - The string to compare to
	 * @param  Boolean 	$case 	- If true the comparison will be case sensitive
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compareN( String $string, Boolean $case = NULL ) {
		if( is_null($case) ) $case = new Boolean(false);
		switch( $case->bool() ) {
			case true:
				$equals = (int) strncmp($this->string, $string);
				break;
			case false:
				$equals = (int) strncasecmp($this->string, $string);
				break;
		}
		if( $equals < 0 )
			return E_Comparison::LESS_THAN();
		elseif( $equals == 0 )
			return E_Comparison::EQUAL_TO();
		elseif( $equals > 0 )
			return E_Comparison::GREATER_THAN();
		else
			throw new LogicException();
	}

	/**
	 * compareSub()
	 *
	 * Binary safe comparison of this string from an offset, up to length characters
	 * to a substring provided for comparison.
	 *
	 * @param  String 	$string - The string to compare to
	 * @param  Integer 	$offset - The starting position on this string
	 * @param  Integer	$length - The number of characters to compare
	 * @param  Boolean 	$case 	- If true the comparision will be case sensitive
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compareSub( String $string, Integer $offset, Integer $length, Boolean $case = NULL ) {
		if( is_null($case) ) $case = new Boolean(false);
		switch( $case->bool() ) {
			case true:
				$equals = (int) substr_compare($this->string, $string, $offset->int(), $length->int(), false);
				break;
			case false:
				$equals = (int) substr_compare($this->string, $string, $offset->int(), $length->int(), true);
				break;
		}
		if( $equals < 0 )
			return E_Comparison::LESS_THAN();
		elseif( $equals == 0 )
			return E_Comparison::EQUAL_TO();
		elseif( $equals > 0 )
			return E_Comparison::GREATER_THAN();
		else
			throw new LogicException();
	}

	/**
	 * compareSubs()
	 *
	 * Binary safe comparison of 2 the strings from an offset, up to length characters.
	 *
	 * @param  String 	$string - The string to compare to
	 * @param  Integer 	$offset - The starting position on this string
	 * @param  Integer	$length - The number of characters to compare
	 * @param  Boolean 	$case 	- If true the comparision will be case sensitive
	 * @return E_Comparison
	 * @throws LogicException
	 */
	public function compareSubs( String $string, Integer $offset, Integer $length, Boolean $case = NULL ) {
		$string = $string->substring($offset, $length);
		return $this->compareSub($string, $offset, $length, $case);
	}

	/**
	 * md5()
	 *
	 * Calculate the MD5 32-character hexadecimal number hash of the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function md5() {
		return $this->objectString( (string) md5($this->string) );
	}

	/**
	 * sha1()
	 *
	 * Calculate the SHA1 hash of the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function sha1() {
		return $this->objectString( (string) sha1($this->string) );
	}

	/**
	 * crc32()
	 *
	 * Calculates the crc32 checksum polynomial of the string.
	 *
	 * @param  void
	 * @return Integer
	 */
	public function crc32() {
		return new Integer( (int) crc32($this->string) );
	}

	/**
	 * crypt()
	 *
	 * One-way string encryption (hashing) using Unix DES-based encryption algorithm.
	 * @param  void
	 * @return String
	 */
	public function crypt() {
		return $this->objectString( (string) crypt($this->string) );
	}

	/**
	 * rot13()
	 *
	 * Perform the rot13 transform on the string.
	 *
	 * @param  void
	 * @return String
	 */
	public function rot13() {
		return $this->objectString( (string) str_rot13($this->string) );
	}

	private function nativeString($string) {
		if( is_array($string) || ($string instanceOf Iterator) ) {
			$string = clone $string;
			foreach($string as $key => $var) {
				$string->$key = $this->nativeString($var);
			}
			return $string;
		}

		if(is_string($string))
			return $string;
		elseif($string instanceof self)
			return $string->str();
		else
			return null;
	}

	private function objectString($string) {
		if( is_array($string) || ($string instanceOf Iterator) ) {
			$string = clone $string;
			foreach($string as $key => $var) {
				$string->$key = $this->objectString($var);
			}
			return $string;
		}

		if(is_string($string))
			return new self($string);
		elseif($string instanceof self)
			return $string;
		else
			return null;
	}
	
	public static function validate( $string ) {
		/* Check parameters */
		if( is_string($string) )
			$string = $string;
			
		elseif( is_null($string) )
			$string = '';
			
		elseif( $string instanceOf self )
			$string = $string->str();
			
		else
			throw new InvalidTypeException($string, 'String');
			
		return (string) $string;
	}
}
?>