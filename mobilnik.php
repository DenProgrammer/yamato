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
header('Content-Type: text/html; charset=utf8');

define('MYPAYMENT', 1);

// Set flag that this is a parent file

function pr($var) {
    echo '<pre>';
    print_r($var);
    echo "</pre>\n";
}

include 'configuration.php';
include 'payments/database.php';
include 'payments/document.php';

//$db    = database::getInstance();
//$users = $db->query('select * from jos_users where id > :user', array(':user' => 1));
//
//pr($users);

$document = new document($HTTP_RAW_POST_DATA);

$headAttr = $document->getAttributes('//HEAD');
$bodyAttr = $document->getAttributes('//BODY');

pr($headAttr);
pr($bodyAttr);