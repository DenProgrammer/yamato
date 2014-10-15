<?php
/**
* @version		$Id: wrapper.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @subpackage	Wrapper
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

	set_time_limit(0);
	date_default_timezone_set('Asia/Bishkek');

// Подключаем библеотеку контроллера Joomla
	require_once( JPATH_COMPONENT.DS.'controller.php' );
	require_once( JPATH_COMPONENT.DS.'/classes/reports.php' );
	
	$controller = new SincroniseController();

	// Perform the Request task
	$controller->execute( JRequest::getCmd('task') );
	
	$controller->selectLoad();

	// Redirect if set by the controller
	$controller->redirect();
?>