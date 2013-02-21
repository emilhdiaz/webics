<?php
define("FETCH_OBJ", 1);
define("FETCH_ARRAY", 2);
define("FETCH_VALUES", 3);

interface DatabaseResult {

	/*
	 * numOfRows()
	 * 
	 * Returns the number of rows in the result set
	 * @param void
	 * @return (int) 
	 */
	public function numOfRows();
	
	/*
	 * numOfFields()
	 * 
	 * Returns the number of fields in the result set
	 * @param void
	 * @return (int) 
	 */
	public function numOfFields();
	
	/*
	 * fetchField()
	 * 
	 * Returns the next field from the result set as an object, or NULL if empty.
	 * @param void
	 * @return (Std) | NULL
	 */
	public function fetchField();
	
	/*
	 * fetchFields()
	 * 
	 * Returns an array with all the fields in the result set as objects. Returns an empty
	 * array if no more fields.
	 * @param void
	 * @return <(Std)>
	 */
	public function fetchFields();
	
	/*
	 * fetchRow()
	 * 
	 * Returns the next row from the result set either as an object, an associated array,
	 * just its values as an ordered array, or NULL if empty. Default is to return an object. 
	 * @param const ( FETCH_OBJ | FETCH_ARRAY | FETCH_VALUES )
	 * @return (Std) | <(string)=>(string)> | <(string)> | NULL
	 * @throws AbnormalExecutionException
	 */
	public function fetchRow( $type = FETCH_OBJ );
	
	/*
	 * fetchRows()
	 * 
	 * Returns an array with all the rows in the result set either as objects, associated arrays,
	 * values as ordered arrays. Returns an empty array if no more rows. Default is to return objects. 
	 * @param const ( FETCH_OBJ | FETCH_ARRAY | FETCH_VALUES )
	 * @return <(Std)> | < <(string)=>(string)> > | < <(string)> > 
	 */
	public function fetchRows( $type = FETCH_OBJ );

	/*
	 * fetch()
	 * 
	 * Returns the default value of fetchRow() for single result sets and fetchRows()
	 * for multi result sets. Meant for convinience.
	 * @param void 
	 * @return (Std) | <(Std)> | NULL
	 */
	public function fetch();
	
	/*
	 * reset()
	 * 
	 * Resets the result set pointer back to the first record
	 * @param void
	 * @return void
	 * @throws AbnormalExecutionException
	 */
	public function reset();
	
	/*
	 * Frees the resources associated with the result set
	 * @param void
	 * @return void
	 */
	public function free();
	
	/*
	 * bindResults()
	 * 
	 * Binds the input variables to the result set row values
	 * @param (array) $bind_results
	 * @return void 
	 * @throws AbnormalExecutionException
	 */
	public function bindResults(array $bind_results);
}
?>