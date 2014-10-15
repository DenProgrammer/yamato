<?php
/**
 * @version		$Id: controller.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Component Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 */
class AukController extends JController
	{
		function __construct( $config = array() )
			{
				parent::__construct( $config );
				// Register Extra tasks
				$this->registerTask( 'add',			'edit' );
				$this->registerTask( 'apply',		'save' );
				$this->registerTask( 'resethits',	'save' );
				$this->registerTask( 'unpublish',	'publish' );
				
				JToolBarHelper::title( JText::_( 'COM_AUK_MANAGER' ));
				JToolBarHelper::preferences('com_auk', '200');
			}
	}