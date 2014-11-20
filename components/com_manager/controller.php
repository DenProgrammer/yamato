<?php

/**
 * @version		$Id: controller.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Weblinks Component Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class ManagerController extends JController {

    /**
     * access levels array - 1 manager, 2 administrator, 3 super administrator
     * */
    protected $access_user = array(1, 2, 3);

    function display() {
        $user = JFactory::getUser();
        if ((JRequest::getVar('view') != 'print') and (($user->getParam('closesectionaccess') != 1) or (!in_array($user->getParam('closesectionlevel'), $this->access_user)))) {
            header('Location: index.php');
            exit;
        }
        parent::display();
    }

}
