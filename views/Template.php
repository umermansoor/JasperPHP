<?php

include('../library/BaseTemplate.php');
// Written by: Umer Mansoor
// Date: August 25, 2012
class Template extends BaseTemplate
{
	function __construct($controller, $action)
	{
		parent::__construct($controller, $action);
	}
	
	public function render()
	{
		// extract the variables into the function's symbol table
		extract($this->_variables);
		
		// Render the header
		include('include/header.php');
		
		// Render the main view file
		if (!include($this->_controller . '/' . $this->_action . '.php'))
		{
			return false;
		}
			
		// Render the footer
		include('include/footer.php');
		
		return true;
	}
}


