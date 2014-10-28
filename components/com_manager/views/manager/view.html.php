<?php
/**
* @version		$Id: view.html.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @subpackage	Weblinks
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class ManagerViewManager extends JView {

	/**
	 * display
	 */
	function display( $tpl = null) {
		$this->car_id = JRequest::getInt('car_id');
		
		$this->initRequest();
		
		$user = JFactory::getUser();
		$this->usertype = $user->getParam('closesectionlevel');
		
		$model = $this->getModel();
		
		if (in_array($this->usertype, array(2,3))) {			
			$this->car_cagents_list = $model->getCAgentsList();
			
			if ($this->car_id > 0) {
				$this->car_stages = $model->getStagesOfDilevery($this->car_id);
			}
		}
		
		if ($this->car_id > 0) {
			if (isset($_FILES['newimage'])) {
				$model->uploadImage($this->car_id);
				header("Location: index.php?option=com_manager&layout=edit&Itemid=32&car_id=".$this->car_id);
				exit;
			}
			$this->car = $model->getSingleCar($this->car_id);
		} else {
			$this->cars = $model->getCars($_SESSION['filter'], $this->usertype);
			$this->is_lost = $model->checkLost($_SESSION['filter']);
		}
		$this->car_marka_list = $model->getCarMarkaList();
		$this->car_model_list = $model->getCarModelList($_SESSION['filter']->marka);
		
		$this->filter = $_SESSION['filter'];
		$this->limit = $model->limit;
		$this->returnUrl = $this->getReturnUrl();
		
		parent::display($tpl);
	}
	
	public function initRequest() {
		
		$search = JRequest::getVar('search');
		$model = JRequest::getVar('model');
		$marka = JRequest::getVar('marka');
		$year1 = JRequest::getVar('year1');
		$year2 = JRequest::getVar('year2');
		$offset = JRequest::getVar('offset');
		$cagent = JRequest::getVar('cagent');
		$all = JRequest::getVar('all');
		$delivered = JRequest::getVar('delivered');
		$sold = JRequest::getVar('sold');
		$fresh = JRequest::getVar('fresh');
		
		if (isset($search)) {
			$_SESSION['filter']->search = mysql_real_escape_string($search);
		}
		if (isset($model)) {
			$_SESSION['filter']->model = mysql_real_escape_string($model);
		}
		if (isset($marka)) {
			$_SESSION['filter']->marka = mysql_real_escape_string($marka);
		}
		if (isset($year1)) {
			$_SESSION['filter']->year1 = intval($year1);
		}
		if (isset($year2)) {
			$_SESSION['filter']->year2 = intval($year2);
		}
		if (isset($offset)) {
			$_SESSION['filter']->offset = intval($offset);
		}
		if (isset($cagent)) {
			$_SESSION['filter']->cagent = $cagent;
		}
		if (isset($all)) {
			$_SESSION['filter']->status['all'] = $all;
		}
		if (isset($delivered)) {
			$_SESSION['filter']->status['delivered'] = $delivered;
		}
		if (isset($sold)) {
			$_SESSION['filter']->status['sold'] = $sold;
		}
		if (isset($fresh)) {
			$_SESSION['filter']->status['fresh'] = $fresh;
		}
		
		if (!$_SESSION['filter']->offset > 0 ) {
			$_SESSION['filter']->offset = 0;
		}
	}
	
	public function getReturnUrl(){
		$returnurl = '&offset='.$_SESSION['filter']->offset;
		$returnurl .= '&search='.$_SESSION['filter']->search;
		$returnurl .= '&model='.$_SESSION['filter']->model;
		$returnurl .= '&marka='.$_SESSION['filter']->marka;
		$returnurl .= '&cagent='.$_SESSION['filter']->cagent;
		$returnurl .= '&year1='.$_SESSION['filter']->year1;
		$returnurl .= '&year2='.$_SESSION['filter']->year2;
		$returnurl .= '&all='.$_SESSION['filter']->status['all'];
		$returnurl .= '&delivered='.$_SESSION['filter']->status['delivered'];
		$returnurl .= '&sold='.$_SESSION['filter']->status['sold'];
		$returnurl .= '&fresh='.$_SESSION['filter']->status['fresh'];
		
		return $returnurl;
	}
}
?>
