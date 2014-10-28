<?php
/**
 * @version		$Id: content.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include dependencies
jimport('joomla.application.component.controller');

$controller = JController::getInstance('Dict');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
