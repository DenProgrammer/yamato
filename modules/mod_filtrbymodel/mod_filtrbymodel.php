<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

$category_id = $params->get('category_id', 0);
$url_category_id = $_GET['category_id'];
$product_id = $_GET['product_id'];

if ((!$category_id > 0) or ($category_id != $url_category_id)) return;
if ($product_id > 0) return;

$database 	=& JFactory::getDBO();

$query = "	SELECT DISTINCT marka 
			FROM #__vm_product 
			WHERE `product_id` IN (
					SELECT `product_id` FROM `#__vm_product_category_xref` WHERE `category_id` = '$category_id'
				)";
$database->setQuery($query);
$rows = $database->loadObjectList();

if (!isset($_GET['cm'])){
	$_GET['cm'] = '';
}

$active_model = $_GET['cm'];
$link = 'index.php?';
foreach($_GET as $k=>$v){
	if ($k == 'cm'){
		$link .= '&'.$k.'=%MODELTYPE%';
	} else {
		$link .= '&'.$k.'='.$v;
	}
}

if ($rows){
	$li = '';
	$none_isset = false;
	foreach($rows as $row){
		if ($row->marka !='NONE'){
			$active = ($active_model == $row->marka) ? 'class="active"' : '';
			$li .= '<li '.$active.'><a href="'.str_replace('%MODELTYPE%', $row->marka, $link).'">'.JText::_($row->marka).'</a></li>';
		} else {
			$none_isset = true;
		}
	}
	
	$active = ($active_model == '') ? 'class="active"' : '';
	$li = '<li '.$active.'><a href="'.str_replace('%MODELTYPE%', '', $link).'">Все</a></li>'.$li;
	if ($none_isset) {
		$active = ($active_model == 'NONE') ? 'class="active"' : '';
		$li = $li.'<li '.$active.'><a href="'.str_replace('%MODELTYPE%', 'NONE', $link).'">Разное</a></li>';
	}
	
	echo '<ul class="filtrbymodel">'.$li.'</ul>';
}
?>