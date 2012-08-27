<?php
include ('../models/User.php');
include ('../views/Template.php');

// Extract the action
$action = $_GET["a"];

$users = new Users($action);
$users->main();

class Users
{
	private $_model;
	private $_viewTemplate;
	private $_action;
	
	function Users($action)
	{
		$this->_model = new User;
		$this->_action = $action;
	}
	
	public function main()
	{
		if (strcmp($this->_action, 'login') == 0)
		{
			$this->login();
		}
		else if (strcmp($this->_action, 'register') == 0)
		{
			$this->register();
		}
		else if (strcmp($this->_action, 'controlPanel') == 0)
		{
			$this->controlPanel();
		}
			else if (strcmp($this->_action, 'logout') == 0)
			{
				$this->logout();
			}
	}
	
	private function createUserSession($username, $password)
	{
		session_start();
		$_SESSION['username'] = $username;	
	}
	
	private function logout()
	{
		session_start();
		session_unset();
		session_destroy();
	}
	
	private function checkSession()
	{
		session_start();
		
		if (isset($_SESSION['username']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function register()
	{
		// Insert a dummy user
		$username = $_GET['username'];
		$this->_model->register("$username", "tiger", "Umer", "Mansoor", "4039740000", "Somewhere in Calgary", "google", "00");
	}
	
	private function controlPanel()
	{
		if ($this->checkSession() == false)
		{
			$this->login();
		}
		else
		{
			$this->_viewTemplate = new Template("Users", "controlPanel");
			$this->_viewTemplate->set('title', 'Control Panel');
			$this->_viewTemplate->render();	
		}
	}
	
	private function login()
	{
		$username = $_GET['username'];
		$password = $_GET['password'];

		$this->_viewTemplate = new Template("Users", "login");
		
		/*
		 * Render the login view if no parameters are passed and return.
		 */
		if ($username == NULL && $password == NULL)
		{
			$this->_viewTemplate->set('title', 'MVC - Control Panel Login');
		}
		else
		{
			if ($this->_model->checkCredentials($username, $password))
			{
				$this->createUserSession($username, $password);
				$this->controlPanel(); //Login is successfull. call the control panel
				return;
			}
			else
			{
				$this->_viewTemplate->set('title', 'MVC - Incorrect username or password');
				$this->_viewTemplate->set('failed', 'true');	
			}
			
			
		}
		
		$this->_viewTemplate->render();
	}
}
