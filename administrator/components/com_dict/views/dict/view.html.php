<?php
/**
 * @version		$Id: view.html.php 20801 2011-02-21 19:22:18Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit an article.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class DictViewDict extends JView
	{
		public function display($tpl = null)
		{
			if (DictModelDict::Save()) header("Location: index.php?option=com_dict");
			$this->data = DictModelDict::getData();
			
			parent::display($tpl);
		}
	}