<?php

include('../library/BaseModelMySql.php');

class MemberTool extends BaseModelMySql
{	
	function __construct()
	{
		parent::__construct();
	}
	
	function getMemberTools($username)
	{
		$this->escapeMySql($username);
		$rows = array();
		
		$sql = "SELECT * from " . TBL_MEMBERS . " WHERE user_id = '$username'";
		//print($sql);
		
		$result = mysql_query($sql);
		
		while ($row = mysql_fetch_assoc($result))
		{
			$rows[$row['text']] = $row['link'];
		}
		
		return $rows;
	}
	
	
	
}