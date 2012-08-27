<?php
// Written by: Umer Mansoor
// umermk3@gmail.com
// Created: August 25, 2012

define("DB_SERVER", "localhost");
define("DB_USER", 	"members");
define("DB_PASS",   "kilopia454");
define("DB_NAME",   "members");

define("TBL_LOGIN", "users");
define("TBL_SERIALS", "serials");
define("TBL_HARDWARE", "hardware");
define("TBL_LOG", "logs");

class User
{
	var $connection;
	
	function User()
	{
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die (mysql_error());
		mysql_select_db(DB_NAME, $this->connection);
	}

	/* ------------------------------------------------------------------------
	 * Checks the username and password.
	 * Return - true is username and password exist in the database and match. 
	 *   false otherwise
	 * ------------------------------------------------------------------------
	 */
	public function checkCredentials($username, $passwordPlainText)
	{
		$username = $this->escapeMySql($username);	
		$passwordPlainText = $this->escapeMySql($passwordPlainText);
		
		$password = $this->encrypt($passwordPlainText, $username); 	
		
		$sql = "SELECT * FROM " . TBL_LOGIN . " WHERE user_id = '$username' AND password = '$password'";
		//print($sql);
		$result = mysql_query($sql);
		$count = mysql_numrows($result);
		
		mysql_free_result($result);
		
		if (!$result || ($count != 1) )
		{
			return false;	
		}
		
		return true;	
	}
	
	
	
	/* ------------------------------------------------------------------------
	 * Checks if a username already exists in the database or not
	 * ------------------------------------------------------------------------
	 */
	public function usernameExists($username)
	{
		$username = $this->escapeMySql($username);
		$sql = "SELECT user_id FROM " . TBL_LOGIN . " WHERE user_id = '$username'";
		$result = mysql_query($sql);
		 
		if (!$result)
		{
			return false;
		}
		
		$count = mysql_numrows($result);
		
		mysql_free_result($result);
		
		return $count;
	}
	
	
	/* ------------------------------------------------------------------------
	 * Updates the redirection url in the login/users table. This is used to
	 * automatically redirect users to announcements, important messages, etc.
	 * This functionality is also used by 'Forget Password' to automatically 
	 * redirect them to change password page after they reset their password.
	 * ------------------------------------------------------------------------
	 */
	public function updateRedirectUrl($username, $url, $updateAllRows = false)
	{
		// Escape input
		$username = $this->escapeMySql($username);
		$url = $this->escapeMySql($url);
		
		$sql = "UPDATE " . TBL_LOGIN . " SET redirect_url = '$url'";
		if ($updateAllRows == true)
		{
			$sql = $sql . " WHERE user_id = '$username'";
		}
		
		print($sql);
		
		return mysql_query($sql);
	}
	
	/* ------------------------------------------------------------------------
	 * Change password. It is the responsibility of the controller to verify 
	 *   credentials before calling this function. 
	 * ------------------------------------------------------------------------
	 */
	public function changePassword($newPasswordPlainText, $username)
	{
		// Escape the input
		$newPasswordPlainText = $this->escapeMySql($newPasswordPlainText);
		$username = $this->escapeMySql($username);
		
		$newPassword = $this->encrypt($newPasswordPlainText, $username);
		
		$sql = "UPDATE " . TBL_LOGIN . " SET password = '$newPassword' WHERE user_id = '$username'";
		
		return mysql_query($sql);
	}
	
	
	/* ------------------------------------------------------------------------
	 * Register a new account. 
	 * Note: Since user_id is the primary key, if the username is taken, this
	 *   return false. No extra checks are necessary.
	 * ------------------------------------------------------------------------
	 */
	function register($username, $passwordPlainText, $fName, $lName, $phone, $address, $company, $hardwareId)
	{
		// Escape the input
		$username = $this->escapeMySql($username);
		$passwordPlainText = $this->escapeMySql($passwordPlainText);
		$fName = $this->escapeMySql($fName);
		$lName = $this->escapeMySql($lName);
		$phone = $this->escapeMySql($phone);
		$address = $this->escapeMySql($address);
		$company = $this->escapeMySql($company);
		$hardwareId = $this->escapeMySql($hardwareId);
		
		// Encrypt the password
		$password = $this->encrypt($passwordPlainText, $username);
		
		$sql = "INSERT INTO " . TBL_LOGIN . " (user_id, password, fname, lname, phone, address, company, hw_id)"
		 		. " VALUES ('$username', '$password', '$fName', '$lName', '$phone', '$address', '$company', $hardwareId)";
		
		print($sql);
		
		return mysql_query($sql);
	}
	
	/* ------------------------------------------------------------------------
	 * Logs some attempt to the logs table.
	 * Note: Table has an auto updating timestamp (CURRENT_TIMESTAMP) field
	 * ------------------------------------------------------------------------
	 */
	public function logAttempt($username, $message)
	{
		$username = $this->escapeMySql($username);
		$message = $this->escapeMySql($username);
		$sql = "INSERT INTO " . TBL_LOG . " (user_id, message) VALUES ('$username', '$message')";
		return mysql_query($sql);
	}
	
	/* ------------------------------------------------------------------------
	 * Escapes a string for MySQL
	 * ------------------------------------------------------------------------
	 */
	private function escapeMySql($string)
	{
		return mysql_real_escape_string($string);
	}
	
	/* ------------------------------------------------------------------------
	 * For encrypting a string
	 * ------------------------------------------------------------------------
	 */
	private function encrypt($string, $salt)
	{
		return crypt(md5($string), md5($salt));
	}
	
	
} // User


?>
