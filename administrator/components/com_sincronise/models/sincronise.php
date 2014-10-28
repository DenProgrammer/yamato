<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class SincroniseModelSincronise extends JModel
{
	protected $msg; 
	protected $prices;
	
	public function getCData()
	{
		$db = &JFactory::getDBO();
		
		$q = 'SELECT * FROM #__car_detail_categories';
		$db->setQuery($q);
		$ids = $db->loadObjectList();
		return $ids;
	}
	public function getCForm()
	{
		$db = &JFactory::getDBO();
		$id = JRequest::getInt('id');
		
		$q = 'SELECT * FROM #__car_detail_categories WHERE `id`='.$id;
		$db->setQuery($q);
		$ids = $db->loadObject();
		return $ids;
	}
	public function getCDelete()
	{
		$db = &JFactory::getDBO();
		$id = JRequest::getInt('id');
		
		if ($id>0)
			{
				$q = 'DELETE FROM #__car_detail_categories WHERE `id`='.$id;
				$db->setQuery($q);
				$db->query();
			}
	}
	public function getTDelete()
	{
		$db = &JFactory::getDBO();
		$id = JRequest::getInt('id');
		
		if ($id>0)
			{
				$q = 'DELETE FROM #__car_detail_prices WHERE `id`='.$id;
				$db->setQuery($q);
				$db->query();
			}
	}
	public function getTData()
	{
		$db = &JFactory::getDBO();
		$pid = JRequest::getVar('pid');
		
		$q = 'SELECT * FROM #__car_detail_categories WHERE `id`='.$pid;
		$db->setQuery($q);
		$cat = $db->loadObject();
		
		$q = 'SELECT * FROM #__car_detail_prices WHERE `p_id`='.$pid.' ORDER BY `price`';
		$db->setQuery($q);
		$list = $db->loadObjectList();
		$obj->cat = $cat;
		$obj->list = $list;
		return $obj;
	}
	public function getTForm()
	{
		$db = &JFactory::getDBO();
		$pid = JRequest::getVar('pid');
		$id = JRequest::getVar('id');
		
		$q = 'SELECT * FROM #__car_detail_prices WHERE `id`='.$id.' AND `p_id`='.$pid;
		$db->setQuery($q);
		$list = $db->loadObject();
		
		return $list;
	}
	public function getPrices()
	{
		$db = &JFactory::getDBO();
		
		$q = 'SELECT * FROM #__car_detail_prices';
		$db->setQuery($q);
		$ids = $db->loadObjectList();
		return $ids;
	}
	public function save_changes()
	{
		$db = &JFactory::getDBO();
		$action 	= JRequest::getVar('action');
		$ret = false;

		if ($action == 'save_cdata')
			{
				$id 	= JRequest::getInt('actionid');
				$name 	= JRequest::getVar('cname');
				
				if($name)
					{
						$sql = 'SELECT `id` FROM `#__car_detail_categories` WHERE `id`='.$id;
						$db->setQuery($sql);
						$checkid = $db->LoadResult();
						
						if ($checkid>0)
							{
								$sql = "UPDATE `#__car_detail_categories` SET `name`='$name' WHERE `id`=$id";
								$db->setQuery($sql);
								$db->query();
							}
						else
							{
								$sql = "INSERT INTO `#__car_detail_categories` (`name`) VALUES ('$name')";
								$db->setQuery($sql);
								$db->query();
							}
						$ret = true;
					}
			}
		
		return $ret;
	}
	public function save_tchanges()
	{
		$db = &JFactory::getDBO();
		$action 	= JRequest::getVar('action');
		$ret = false;
		echo $action.'<br>';
		if ($action == 'save_tdata')
			{
				$id 	= JRequest::getInt('actionid');
				$pid 	= JRequest::getInt('actionpid');
				$price 	= JRequest::getInt('tprice');
				$type 	= JRequest::getVar('ttype');
				$value 	= (float) JRequest::getVar('tvalue');
				
				$sql = 'SELECT `id` FROM `#__car_detail_prices` WHERE `id`='.$id;
				$db->setQuery($sql);
				$checkid = $db->LoadResult();
				
				if($price>0)
					{
						if ($checkid>0)
							{
								$q = "UPDATE `#__car_detail_prices` SET `p_id`='$pid', `price`='$price', `type`='$type', `value`='$value' WHERE `id`=$id";
								$db->setQuery($q);
								$db->query();
							}
						else
							{
								$q = "INSERT INTO `#__car_detail_prices` (`p_id`,`price`,`type`,`value`) VALUES ('$pid','$price','$type','$value')";
								$db->setQuery($q);
								$db->query();
							}
						$ret = true;
					}
			}
		
		return $ret;
	}
}
?>
