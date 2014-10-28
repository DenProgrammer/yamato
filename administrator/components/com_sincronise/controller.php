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
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Weblinks Component Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class SincroniseController extends JController
{
	var $url = '';
	var $user = '';
	var $pass = '';
	
	public function selectLoad()
		{
			$db = JFactory::getDBO();
			
			$sql = 'SELECT `params` FROM `#__components` WHERE `option`=\'com_sincronise\'';
			$db->setQuery($sql);
			$str = $db->LoadResult();
			$mas = unserialize($str);
			
			$this->url = $mas['server1cip'];
			$this->user = $mas['server1clogin'];
			$this->pass = $mas['server1cpass'];
			
			$type = JRequest::getVar("type");
			
			switch($type)
				{
					case 'loadExcel'://загрузить весь список
						{
							$this->loadExcel();
							
							break;
						}
				}
		}
	//получение наценки к товару
	function getPrice($price)
		{
			$db = JFactory::getDBO();
			$pr = (float) $price;
			if ($pr>0)
				{
					$sql = 'SELECT * FROM `#__car_detail_prices` WHERE `p_id`=9 AND `price`>'.$pr.' ORDER BY `price` LIMIT 1';//echo $sql.'<br>';
					$db->setQuery($sql);
					$rows = $db->LoadObjectList();
					foreach($rows as $row)
						{
							$mas->price = $row->price;
							$mas->type = $row->type;
							$mas->value = $row->value;
						}
					if ($mas->type=='*')
						{
							$pr = $pr + $mas->value;
						}
					if ($mas->type=='%')
						{
							$pr = round(($price*(1 + $mas->value/100)),2);
						}
					$price = $pr;
				}
			return $price;
		}
	public function loadExcel()
		{
			$db = JFactory::getDBO();
			
			$count = 0;
			$d = dir("../images/excel");
			while ($entry = $d->read()) {
				if (($entry == '.') or ($entry == '..')) continue;
				$name = iconv("windows-1251","UTF-8//IGNORE", $entry);
			   
			   $data = file("../images/excel/".$entry);
			   $i = 0;$time = time();
			   foreach($data as $item)
				{
					$i++;
					if ($i<=2) continue;
					
					$item = iconv("windows-1251","UTF-8//IGNORE", $item);
					$arr = explode(';',$item);
					
					$manufacturer = mysql_real_escape_string($arr[0]);
					$art = mysql_real_escape_string($arr[1]);
					$type = mysql_real_escape_string($arr[2]);
					$name = mysql_real_escape_string($arr[3]);
					$model = mysql_real_escape_string($arr[4]);
					$pack = mysql_real_escape_string($arr[5]);
					$oe = mysql_real_escape_string($arr[6]);
					$order = mysql_real_escape_string($arr[7]);
					$price = (float) mysql_real_escape_string($arr[8]);
					$ost = mysql_real_escape_string($arr[9]);
					$prihod = mysql_real_escape_string($arr[10]);
					
					$art = 'excel_'.$oe;
					if ((!$name) or (!$art)) continue;
					
					$price = $this->getPrice($price);
					
					unset($obj);
					$obj->link = '';
					$obj->product_sku = $art;
					$obj->product_s_desc = $type;
					$obj->product_desc = $type;
					$obj->product_thumb_image = '';
					$obj->product_full_image = '';
					$obj->product_in_stock = $ost;
					$obj->product_name = $name;
					$obj->product_price = $price;
					$obj->product_currency = 'EUR';
					$obj->product_category_id = 14;
					$obj->marka = '';
					$obj->model = $model;
					$obj->year = 0;
					
					SincroniseModelConfig::updateProduct($obj);
					$count++;
				}
			}
			$d->close();
			
			echo '<content>
	<status>OK</status>
	<count>'.$count.'</count>
</content>';
		}
}
