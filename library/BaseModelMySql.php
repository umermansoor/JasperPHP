<?php

include('../config/db.php');

class BaseModelMySql
{
	private $_connection;
	
	function __construct()
	{
		$this->_connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die (mysql_error());
		mysql_select_db(DB_NAME, $this->_connection);
	}
	
	/* ------------------------------------------------------------------------
	 * Escapes a string for MySQL
	 * ------------------------------------------------------------------------
	 */
	protected function escapeMySql($string)
	{
		return mysql_real_escape_string($string);
	}
	
}