<?php
/**
* @version		$Id: mod_mainmenu.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$menutype = $params->get('menutype', 'mainmenu');
$class_sfx = $params->get('class_sfx','');
$Itemid = JRequest::getInt('Itemid');
$user = JFactory::getUser();
$db = JFactory::getDBO();

$sql = 'SELECT `password` FROM `#__users` WHERE `id`='.$user->id;
$db->setQuery($sql);
$password = $db->LoadResult();

if ($user->getParam('closesectionaccess') == 1) {
	$closesection = '<td class="itemballans">
					<a href="index.php?option=com_manager&Itemid=32" >
						Панель управления
					</a>
				</td>';
} else {
	$closesection = '<td class="itemballans">Личный кабинет</td>';
}

$chpass = false;
if ($password == 'd421d97531529fc6519096ae970dfa15:g4nYvNRUQybwhgawelEEVmGApD9qgejs') $chpass = true;

if (($user->id>0) and ($user->gid==19)) 
	{

		$sql = 'SELECT `ballans` FROM `#__users` WHERE `id`='.$user->id;
		$db->setQuery($sql);
		$ballans = (float) $db->LoadResult();

		$sql = 'SELECT * FROM `#__menu` WHERE `published`=1 AND `menutype`=\''.$menutype.'\' ORDER BY `ordering`';
		$db->setQuery($sql);
		$rows = $db->LoadObjectList();

		$menu = $closesection.'<td width="0">
					<div class="chpanel">
						<div class="chclose">X</div>
						<div class="chpass">Пожалуйста поменяйте пароль на страничке настройки</div>
					</div>
				</td>';
		$sep = '<td class="sep">&nbsp;</td>';
		if ($rows) foreach($rows as $row)
			{
				$active = ($Itemid==$row->id) ? 'active' : '';
				$menu .= $sep.'<td class="'.$active.' item'.$row->id.'"><a href="'.$row->link.'&Itemid='.$row->id.'"><span>'.$row->name.'</span></a></td>';
			}
			
		$menu .= $sep.'<td><a onclick="logout()" href="#"><span>Выход</span></a></td>';

		echo '<table class="kabmenu'.$class_sfx.'" width="490" cellpadding="0" cellspacing="0"><tr>'.$menu.'</tr></table>';
	}
else
	{
?>
<table width="490" cellspacing="0" cellpadding="0" class="kabmenu">
	<tr>
		<?php echo $closesection; ?>
		<td class="sep">&nbsp;</td>
		<td class=" item10"><a href="/yamato/index.php?option=com_user&amp;view=user&amp;layout=form&amp;Itemid=10"><span>настройки</span></a></td>
		<td class="sep">&nbsp;</td>
		<td><a href="#" onclick="logout()"><span>Выход</span></a></td>
	</tr>
</table>
<?php } ?>
<style>
.chpanel{
	position:relative;
	display:<?php if ($chpass) echo 'block'; else echo 'none'; ?>;
}
.chpass{
	position: absolute;
	width: 300px;
	height: 70px;
	right: -40px;
	top: 155px;
	border: solid 1px #585858;
	border-radius: 10px;
	background: #ffffff;
	z-index: 10;
	color: red;
	font: normal 15px/32px Arial;
	box-shadow: 0 0 10px rgba(0,0,0,0.8);
}
.chclose{
	position: absolute;
	width: 30px;
	height: 30px;
	right: -55px;
	top: 140px;
	border: solid 1px grey;
	border-radius: 10px;
	background: red;
	z-index: 11;
	color: #ffffff;
	font: bold 20px/29px Arial;
	cursor: pointer;
}
</style>
<script>
	jQuery('document').ready(function($){
		$('.chclose').click(function(){
			$('.chpanel').remove();
		});
	});
</script>