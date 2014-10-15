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
class DetailsModelSubaru extends JModel
{
	public function getData()
		{
			$id = jRequest::getInt("id");
			$layout = jRequest::getVar("layout");
			$db = JFactory::getDBO();
			
			$l = $_GET['l'];
			
			$CountryID = '82'; //KZ = 82 / CountryID const
			if (!$l) return '';
			$url = "http://epc.japancars.ru/subaru/?fromchanged=true&l=$l";
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
			curl_setopt($ch, CURLOPT_POST, 100); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields); 

			$result = curl_exec($ch); 
			curl_close($ch);
			
			$arr1 = array('<script','</script>','HM.set','src="/');
			$arr2 = array('<scriptus','</scriptus>','HMset','src="');
		   
			$result = str_replace($arr1,$arr2,$result);
			
			$result = DetailsController::translate($result);
			
			return $result;
		}
}
