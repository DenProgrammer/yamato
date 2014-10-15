<?php
/**
 * @version		$Id: categories.php 14401 2010-01-26 14:10:00Z louis $
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
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Weblinks Component Categories Model
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class ManagerModelPrint extends JModel
{
	public function getData($product_id) {
		$db = JFactory::getDBO();
		
		$sql = 'SELECT *, (
					SELECT `product_price` 
					FROM `#__vm_product_price` 
					WHERE `product_id`='.$product_id.' 
					LIMIT 1
					) AS `price` , (
					SELECT `product_currency` 
					FROM `#__vm_product_price` 
					WHERE `product_id`='.$product_id.' 
					LIMIT 1
					) AS `currency` ,(
					SELECT `category_name` 
					FROM `#__vm_category` 
					WHERE `category_id`=(
						SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = '.$product_id.' LIMIT 1)
					) AS `category_name`
				FROM `#__vm_product` 
				WHERE `product_id`='.$product_id.' 
				LIMIT 1';
		$db->setQuery($sql);
		$prod = $db->LoadObject();

		$sql = 'SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = '.$product_id.' LIMIT 1';
		$db->setQuery($sql);
		$prod->category_id = $db->LoadResult();

		$sql = 'SELECT * FROM `#__vm_product_files` WHERE `file_product_id` = '.$product_id;
		$db->setQuery($sql);
		$prod->images = $db->LoadObjectList();
		
		return $prod;
	}
}
?>
