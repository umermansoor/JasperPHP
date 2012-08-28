<?php

/**
 * The controller is invoked on an action (e.g. login). The action is passed as
 * a HTTP GET parameter with id = 'a'. We must extract the action before creating
 * the controller.
 */
$action = $_GET["a"]; // Extract the action

$members = new $controllerName($modelName, $action); //Create the controller
$members->main(); //Call the main function