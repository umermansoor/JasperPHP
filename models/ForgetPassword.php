<?php
// Written by Umer Mansoor
// umermk3@gmail.com
// Created: August 25, 2012
include_once ('Database.php');
include_once('Emailer.php');


class ForgetPassword
{

	function ForgetPassword()
	{
		
	}
	
	public function resetPassword($username)
	{
		$database = new Database();
		
		$temporaryPassword = $this->generateRandomPassword(10);
		
		$database->changePassword($temporaryPassword, $username);
		$database->updateRedirectUrl($username, "http://site.com/changepassword.php");
		
		$emailer = new Emailer();
		$emailer->sendEmail("umer@hotmail.com", "tuan@hotmail.com", "jack", "Sparrow");
		/*
		unset($emailer);
		unset($database);
		*/
	}
	
	/* ------------------------------------------------------------------------
	 * Generates a random password. 
	 * Source: somewhere on the web. Ahhh can't remember :(
	 * ------------------------------------------------------------------------
	 */
	private function generateRandomPassword($length = 8)
	{
		// start with a blank password
		$password = "";

		// define possible characters - any character in this string can be
		// picked for use in the password, so if you want to put vowels back in
		// or add special characters such as exclamation marks, this is where
		// you should do it
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

		// we refer to the length of $possible a few times, so let's grab it now
		$maxlength = strlen($possible);

		// check for length overflow and truncate if necessary
		if ($length > $maxlength) 
		{
			$length = $maxlength;
		}

		// set up a counter for how many characters are in the password so far
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length)
		{
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);

			// have we already used this character in $password?
			if (!strstr($password, $char)) 
			{
				// no, so it's OK to add it onto the end of whatever we've already got...
				$password .= $char;
				// ... and increase the counter by one
				$i++;
			}
		} // while

		// done!
		return $password;
	}

}


?>