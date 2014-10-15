<?php
/**
* @version		$Id: index.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

    header ("Content-Type: text/html; charset=utf-8");
// Set flag that this is a parent file
define( '_JEXEC', 1 );

define('JPATH_BASE', dirname(__FILE__) );

define( 'DS', DIRECTORY_SEPARATOR );
function pr($var)
	{
		echo '<div style="text-align:left;"><pre>';
		print_r($var);
		echo '</pre></div>';
	}

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

/**
 * CREATE THE APPLICATION
 *
 * NOTE :
 */
$mainframe =& JFactory::getApplication('site');

/**
 * INITIALISE THE APPLICATION
 *
 * NOTE :
 */
// set the language
$mainframe->initialise();

$art = mysql_real_escape_string(JRequest::getVar("art"));

echo '<table border="1" width="100%">
			<tr>
				<td>Наименование</td>
				<td>Модель</td>
				<td>Цена</td>
			</tr>';
$db = JFactory::getDBO();
$sql = "SELECT * FROM `jos_parce_excel` WHERE `oe` LIKE '%$art%'";
$db->setQuery($sql);
$rows = $db->LoadObjectList();
foreach($rows as $row)
	{
		echo '<tr>
				<td>'.$row->name.'</td>
				<td>'.$row->model.'</td>
				<td>'.$row->price.'</td>
			</tr>';
	}
echo '</table>';
