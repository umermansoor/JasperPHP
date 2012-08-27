<?php

define("DEFAULT_EMAIL", "do-not-reply-at-controlpanel.com");

class Emailer
{
	function Emailer()
	{
		
	}
	
	public function sendEmail($from, $to, $subject, $message)
	{
		if ($from == NULL)
		{
			$from = DEFAULT_EMAIL;
		}
		
		print("Sent: $from, To: $to, Subject: $subject, Message: $message");
		
	}
}

?>