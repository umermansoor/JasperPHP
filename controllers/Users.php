<?php

/* Users Controller: All functionality pertaining to user accounts such as creation, validation, etc.
 *    is contained in this controller. 
 * Written by: Umer Mansoor <August 25, 2012>
 */
include ('../models/User.php');
include ('../views/Template.php');
include('./helper/SessionHandler.php');
include('../library/BaseController.php');

class Users extends BaseController
{
	private $_session;
	
	function __construct($modelClass, $action)
	{
		parent::__construct($modelClass, $action);
		$this->_session = SessionHandler::getInstance();
	}
	
	
	/* ------------------------------------------------------------------------
	 * Register Action: Performs user registration
	 * ------------------------------------------------------------------------
	 */
	protected function register()
	{
		$username = $_GET['username'];
		$this->_model->register("$username", "tiger", "Umer", "Mansoor", "4034004773", "117 Panbamoutn", "Acme", "00");
	}

	
	/* ------------------------------------------------------------------------
	 * Login Action
	 * ------------------------------------------------------------------------
	 */
	protected function login()
	{
		
		$username = $_GET['username'];
		$password = $_GET['password'];

		$this->_viewTemplate = new Template("Users", "login");
		
		/*
		 * Render the login view if no parameters are passed and return.
		 */
		if ($username == NULL && $password == NULL)
		{
			$this->_viewTemplate->set('title', 'Acme Corp - Login');
		}
		else
		{
			if ($this->_model->checkCredentials($username, $password))
			{
				$this->_session->login($username);
				$this->redirectToController('MemberTools', 'members'); //Login is successfull. call the control panel
				return;
			}
			else
			{
				$this->_viewTemplate->set('title', 'Acme Corp - Incorrect username or password');
				$this->_viewTemplate->set('message', 'Incorrect Username or Password!!!');	
			}
		}
		
		$this->_viewTemplate->render();
	}	
}

/**
 * The controller is invoked on an action (e.g. login). The action is passed as
 * a HTTP GET parameter with id = 'a'. We must extract the action before creating
 * the controller.
 */
$action = $_GET["a"]; // Extract the action

$members = new Users("User", $action); //Create the controller
$members->main(); //Call the main function
