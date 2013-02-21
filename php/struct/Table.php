<?php
class Table extends Object {

	private $column_map;
	private $data;


	/**
	 * Class Constructor
	 *
	 * @final
	 * @param  array $data
	 * @access public
	 */
	final public function __construct(array $data) {
		parent::__construct();
		$this->column_data		= new HashTree();
		$this->column_map		= new Hash();
		$this->data				= new SetTree($data);
	}

	/**
	 * Return a column of data from the table.
	 *
	 * @final
	 * @param  string $column
	 * @return HASH_CLASS
	 * @access public
	 */
    final public function getColumn($column)
    {
		foreach($this->data as $key => $row):

    		$var[$key] = $row[$column];

    	endforeach;
    	return new HashTree($var);
    }

    /**
     * Return a row of data from the table.
     *
     * @final
     * @param  string $row
     * @return HASH_CLASS
     * @access public
	 */
    final public function getRow($row) {
    	$var = $this->var[$row];
    	return new Cloud($var);
    }

    /**
     * Sort the table by a column.
     *
     * @final
     * @param  string $column name
     * @param  string $column type
     * @param  string $column order
     * @access public
	 */
    final public function orderby() {
     	$values = func_get_args();

     	$first = (object) $this->first();

    	foreach($values as $value):

			switch($value):

    			case 'ASC':
    				$param[] = 'SORT_ASC';
    				break;

    			case 'DESC':
    				$param[] = 'SORT_DESC';
    				break;

    			case 'NUM':
    				$param[] = 'SORT_NUMERIC';
    				break;

    			case 'STR':
    				$param[] = 'SORT_STRING';
    				break;

    			case 'NORM':
    				$param[] = 'SORT_REGULAR';
    				break;

    			default:
    				$exist = $first->existKey($value);
    				if($exist):

    					$$value = $this->getColumn($value)->arr();
    					$param[] = $$value;

    				endif;

    		endswitch;

    	endforeach;

    	$param[] = $this->var;

    	call_user_func('array_multisort', $param);
    }
}
?>