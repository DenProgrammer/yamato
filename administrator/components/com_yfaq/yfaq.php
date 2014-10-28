<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');

header('Content-type: text/html; charset=utf-8');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller = new YfaqController;

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
