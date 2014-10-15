<?php
/**
 * @version		$Id: article.php 21148 2011-04-14 17:30:08Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * Item Model for an Article.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class DictModelDict extends JModel
{
	public function getData()
		{
			$id = jRequest::getInt("id");
			$layout = jRequest::getVar("layout");
			$db = JFactory::getDBO();
			
			if ($layout == 'edit')
				{
					$sql = 'SELECT * FROM #__dictionary_of_carparts_phrases WHERE id='.$id;
					$db->setQuery($sql);
					$arr = $db->LoadObject();
				}
			else
				{
					$sql = 'SELECT * FROM #__dictionary_of_carparts_phrases';
					$db->setQuery($sql);
					$arr = $db->LoadObjectList();
				}
			
			return $arr;
		}
	public function Save()
		{
			$id = jRequest::getInt("id");
			$action = jRequest::getVar("action");
			$en_name = jRequest::getVar("en_name");
			$ru_name = jRequest::getVar("ru_name");
			$db = JFactory::getDBO();
			
			$ret = false;
			if ($action=='save')
				{
					if ($id>0)
						{
							$sql = "UPDATE #__dictionary_of_carparts_phrases SET en_name='$en_name', ru_name='$ru_name' WHERE id=$id";//echo $sql;exit;
							$db->setQuery($sql);
							$arr = $db->query();
						}
					else
						{
							$sql = "INSERT INTO #__dictionary_of_carparts_phrases (en_name, ru_name) VALUES ('$en_name','$ru_name')";//echo $sql;exit;
							$db->setQuery($sql);
							$arr = $db->query();
						}
					
					$ret = true;
				}
			if ($action=='delete')
				{
					if ($id>0)
						{
							$sql = "DELETE FROM #__dictionary_of_carparts_phrases WHERE id=$id";//echo $sql;exit;
							$db->setQuery($sql);
							$arr = $db->query();
						}
					
					$ret = true;
				}
			
			return $ret;
		}
}
