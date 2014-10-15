<?php
/**
 * @version		$Id: controller.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Component Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 */
class DetailsController extends JController
	{
		function translate($curl_html)
			{
				$db = JFactory::getDBO();
				$sql1 = "SELECT * FROM `jos_dictionary_of_carparts`";
				$sql2 = "SELECT * FROM `jos_dictionary_of_carparts_phrases`";
				
				$rows = mysql_query($sql1);
				while($row = mysql_fetch_object($rows))
					{
						$dictionary_words[$row->en_name] = $row->ru_name;
					}
					
				$rows = mysql_query($sql2);
				while($row = mysql_fetch_object($rows))
					{
						$dictionary_phrase[$row->en_name] = $row->ru_name;
					}
					
				$en_array = array();
				$ru_array = array();
				
				$en_array_phrase = array();
				$ru_array_phrase = array();
				
				foreach($dictionary_phrase as $key => $value)
				{
					array_push($en_array_phrase, $key);
					array_push($ru_array_phrase, $value);
				}
				
				foreach($dictionary_words as $key => $value)
				{
					array_push($en_array, $key);
					array_push($ru_array, $value);
				}
				
				//$curl_html = mb_strtolower($curl_html,'UTF8');
				$curl_html = str_ireplace($en_array_phrase, $ru_array_phrase, $curl_html);
				$curl_html = str_ireplace($en_array, $ru_array, $curl_html);
				return $curl_html;
			}	
	}