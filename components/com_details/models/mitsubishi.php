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
class DetailsModelMitsubishi extends JModel
{
	public function getData()
		{
			$id = jRequest::getInt("id");
			$layout = jRequest::getVar("layout");
			$db = JFactory::getDBO();
			
			if($_GET['step']>0) $_GET['step'] = 1;
			if(!$_GET['route']) $_GET['route'] = 'catalog/mitsubishi';
			$get = '?';$sep = '';
			foreach($_GET as $k=>$v)
				{
					$get .= "$sep$k=$v";
					$sep = '&';
				}
			
			$CountryID = '82'; //KZ = 82 / CountryID const
		   
			$postfields = ''; 
			
			$url = "http://japancars.ru/index.php$get";
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
			curl_setopt($ch, CURLOPT_POST, 100); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields); 

			$result = curl_exec($ch); 
			curl_close($ch);
			
			//$result = iconv("windows-1251","UTF-8//IGNORE", $result);
			
			if ($layout == 'ajax')
				{
				
				}
			else
				{
					$startIndex = strpos($result, '<div id="content"'); 
					$endIndex = strpos($result, '<div id="footer"', $startIndex);
					$result = substr($result, $startIndex, $endIndex - $startIndex); 
					
					$arr1 = array('<script','</script>','src="','src="/');
					$arr2 = array('<scriptus','</scriptus>','src="http://japancars.ru/','src="');
				   
					$result = str_replace($arr1,$arr2,$result);
				}
			$result = DetailsController::translate($result);
			
			return $result;
		}
}
