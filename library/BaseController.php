<?php



class BaseController
{
	protected $_model;
	protected $_viewTemplate;
	protected $_action;
	
	function __construct($modelClass, $action)
	{
		$this->_model = new $modelClass; 
		$this->_action = $action;
	}
	
	public function main()
	{
		$actionFunctionName = $this->_action;
		$this->$actionFunctionName();
	}
	
	protected function redirectToController($controllerName, $action)
	{
		http_redirect("$controllerName.php?a=$action");
	}
	
	function __autoload($classname)
	{
		include '../models' . $classname . '.php';
	}
	
}


