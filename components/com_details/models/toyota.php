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
class DetailsModelToyota extends JModel
{
	public function getData()
		{
			$id = jRequest::getInt("id");
			$layout = jRequest::getVar("layout");
			$db = JFactory::getDBO();
			
			if($_GET['step']>0) $step = $_GET['step']; else	$step = 1;
			if ($_POST['cat']) $cat  = $_POST['cat']; else $cat  = $_GET['cat'];
			if ($_POST['mdl']) $mdl  = $_POST['mdl']; else $mdl  = $_GET['mdl'];
			if ($_POST['cd'])  $cd   = $_POST['cd']; else $cd    = $_GET['cd'];
			if ($_POST['carea']) $ca = $_POST['carea']; else $ca = $_GET['carea'];
			if ($_POST['grp']) $grp  = $_POST['grp']; else $grp  = $_GET['grp'];
			if ($_POST['sec']) $sec  = $_POST['sec']; else $sec  = $_GET['sec'];
			if ($_POST['artikul']) $textPartN = $_POST['artikul']; else $textPartN = $_GET['artikul'];
			
			$CountryID = '82'; //KZ = 82 / CountryID const
		   
			$postfields = ''; 
			
			switch($step)
				{
					case 1: $url = "http://old.japancars.ru/cat/toyota/"; break;
					case 2: $url = 'http://old.japancars.ru/cat/toyota/?carea='.$ca; break;
					case 3: $url = 'http://old.japancars.ru/cat/toyota/index.php?carea='.$ca.'&cat='.$cat; break;
					case 4: $url = 'http://old.japancars.ru/cat/toyota/index.php?cd='.$cd.'&cat='.$cat.'&mdl='.$mdl; break;
					case 5: $url = 'http://old.japancars.ru/cat/toyota/index.php?cd='.$cd.'&cat='.$cat.'&mdl='.$mdl.'&grp='.$grp; break;
					case 6: $url = 'http://old.japancars.ru/cat/toyota/index.php?cd='.$cd.'&cat='.$cat.'&mdl='.$mdl.'&sec='.$sec; break;
					case 7: 
						{
							$postfields = "CountryID=".$CountryID."&txtPartN=".$textPartN; 
							$url = 'http://ra.ae/priceonline.php';
							echo $postfields;
							break;
						}
				}
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
			curl_setopt($ch, CURLOPT_POST, 100); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields); 

			$result = curl_exec($ch); 
			curl_close($ch);
			
			$result = iconv("windows-1251","UTF-8//IGNORE", $result);
			
			$startIndex = strpos($result, '<table'); 
			$endIndex = strpos($result, "</body>", $startIndex);
			$result = substr($result, $startIndex, $endIndex - $startIndex); 
			
			$arr1 = array('<script','</script>','src="','src="/');
			$arr2 = array('<scriptus','</scriptus>','src="http://old.japancars.ru/cat/toyota/','src="');
		   
			$result = str_replace($arr1,$arr2,$result);
			
			$result = DetailsController::translate($result);
			
			return $result;
		}
}
