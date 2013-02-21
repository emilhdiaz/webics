<?php
interface DatabasePreparedStatement {
	
	/*
	 * prepare()
	 * 
	 * Generates a prepared statement on the server from the given query
	 * @param (string) $query
	 * @return void
	 * @throws DBStatementResult 
	 */
	public function prepare( $query );
	
	/*
	 * bindParams()
	 * 
	 * Bind input parameters to the prepared statement
	 * @param (array) $bind_params
	 * @return void
	 * @throws AbnormalExecutionException
	 */
	public function bindParams( VArray $bind_params );
	
	/*
	 * execute()
	 * 
	 * Execute the prepared statement and returns a DatabaseResult Object
	 * for SELECT queries and a NullResult Object for all other queries
	 * @param void
	 * @return (DatabaseResult) | (NullResult)
	 * @throws AbnormalExecutionException 
	 */
	public function execute();
	
	/*
	 * hasResult()
	 * 
	 * Checks if the previously executed statement has a result set associated with it
	 * @param void
	 * @return (bool)
	 */
	public function hasResult();
	
	/*
	 * Frees the resources associated with the prepared statement
	 * @param void
	 * @result void
	 * throws AbnormalExecutionException
	 */
	public function free();
	
	/*
	 * Returns the error string from the last operation
	 * @param void
	 * @return (string) 
	 */
	public function error();
}
?>