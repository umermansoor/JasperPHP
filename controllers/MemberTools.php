<?php

/****************************************************************************** 
 * Members Area Controller: All functionality pertaining to Members Area is 
 *    contained in this  controller. Things like getting a member specific link 
 *    and displaying it, etc.
 *
 * Written by: Umer Mansoor <August 26, 2012>
 *****************************************************************************/

$modelName = "MemberTool";
$controllerName = basename(__FILE__, '.php'); 

include('../library/BaseController.php');
include ("../models/$modelName.php");
include ('../views/Template.php');

include('./helper/SessionHandler.php');

class MemberTools extends BaseController
{
	private $_session;
	
	/* ------------------------------------------------------------------------
	 * Constructor
	 * Parameters - $modelClass = Name of the model this controller uses
	 *              $action = Action to be performed
	 * ------------------------------------------------------------------------
	 */
	function __construct($modelClass, $action)
	{
		parent::__construct($modelClass, $action);
		$this->_session = SessionHandler::getInstance();
	}
	
	/* ------------------------------------------------------------------------
	 * Members Action: Shows the Member Area
	 * ------------------------------------------------------------------------
	 */
	protected function members()
	{
		if ($this->_session->isLoggedIn() == false)
		{
			die('Not logged in');
		}
		else
		{
			$this->_viewTemplate = new Template("MemberTools", "membersArea");
			$links = $this->_model->getMemberTools($this->_session->getUserName());
			$this->_viewTemplate->set('title', 'Acme Corp - Members Area');
			$this->_viewTemplate->set('links', $links);
			$this->_viewTemplate->render();	
		}
	}
	
	/* ------------------------------------------------------------------------
	 * Logout Action: Logs a member out
	 * ------------------------------------------------------------------------
	 */
	protected function logout()
	{
		$this->_session->destroy();	
		$this->_viewTemplate = new Template("Users", "logout");
		$this->_viewTemplate->set('title', 'Acme Corp - Leaving Members Area');
		$this->_viewTemplate->render();
	}
	
}

include('../library/ControllerBootstrap.php');
