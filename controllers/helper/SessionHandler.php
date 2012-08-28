<?php

/**
 * A helper class for managing sessions. Implements the singleton design pattern.
 * Written by: Umer Mansoor <August 26, 2012>
 */
class SessionHandler
{
	private static $instance;
	
	// Session ID that is assigned by PHP (32 character alpha-numeric)
	public static $sessionID;
	
	/* ------------------------------------------------------------------------
	 * Constructor: Starts the session and stores session ID in member variable
	 * ------------------------------------------------------------------------
	 */
	private function __construct()
	{
		session_start();
		self::$sessionID = session_id();
	}
	
	/* ------------------------------------------------------------------------
	 * Returns the only instance of this class (singleton)
	 * ------------------------------------------------------------------------
	 */
	public static function getInstance()
	{
		if ( !isset(self::$instance) )
		{
			$className = __CLASS__;
			self::$instance = new $className;
			
		}
		
		return self::$instance;
	}
	
	/* ------------------------------------------------------------------------
	 * Get the username of the user who is currently logged in
	 * ------------------------------------------------------------------------
	 */
	public function getUserName()
	{	
		return $_SESSION['username'];
	}
	
	/* ------------------------------------------------------------------------
	 * Log in a user identified by $username
	 * ------------------------------------------------------------------------
	 */
	public function login($username)
	{
		$_SESSION['username'] = $username;
	}
	
	/* ------------------------------------------------------------------------
	 * Checks if the user is logged in or not. This function is available to
	 * other controllers as well.
	 * Return - true if the user is logged in. false otherwise.
	 * ------------------------------------------------------------------------
	 */
	public function isLoggedIn()
	{
		//session_start();
		
		// TODO: Check for isset instead
	 	if(isset($_SESSION['username']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/* ------------------------------------------------------------------------
	 * Destroys the session. Called when the user selects log out.
	 * ------------------------------------------------------------------------
	 */
	public function destroy()
	{
		session_start();
		session_unset();
		session_destroy();
	}
	/* ------------------------------------------------------------------------
	 * Destructor
	 * ------------------------------------------------------------------------
	 */
	public function __destruct()
	{
		session_write_close();
	}

}
