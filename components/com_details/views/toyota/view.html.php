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
class DetailsViewToyota extends JView
	{
		public function display($tpl = null)
		{
			$this->Itemid = JRequest::getVar('Itemid');
			$this->carea = JRequest::getVar('carea');
			$this->step = JRequest::getVar('step');
			
			if (!$this->carea) header("Location: index.php?option=com_details&view=toyota&step=2&carea=J&Itemid=".$this->Itemid);
			
			$this->data = $this->get('Data');
			
			parent::display($tpl);
		}
	}