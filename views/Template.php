<?php
// Written by: Umer Mansoor
// Date: August 25, 2012
class Template 
{
	
	protected $_variables = array(); //Container for variables passed by the controller
	protected $_controller;
	protected $_action;
	
	function Template($controller, $action)
	{
		$this->_controller = $controller;
		$this->_action = $action;
		
		// Automatically make controller and action names available to every view
		$this->set('controller', $controller);
		$this->set('action', $action);
	}
	
	
	/* ------------------------------------------------------------------------
	 * Controllers calls this fucntion to set variables it needs to pass to the
	 * views.
	 * ------------------------------------------------------------------------
	 */
	public function set($name, $val)
	{
		$this->_variables[$name] = $val;
	}
	
	/* ------------------------------------------------------------------------
	 * Renders the template
	 * Return - false is the view corresponding to controller and action is not
	 *    found. true otherwise.
	 * ------------------------------------------------------------------------
	 */
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


