<?php
/**
 * @version		$Id: edit.php 20549 2011-02-04 15:01:51Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

?>
<table width=600 align=left><tr><td align=left width=100%>
<table width=100%><tr>
<td valign=middle align=left><div class="header icon-48-generic">Перевод для парсеров</div></td>
<td valign=middle align=right>
<table class="toolbar">
<tr>
<td class="button">
<a href="index.php?option=com_dict&layout=edit&id=0" class="toolbar">
<span class="icon-32-new" title="Создать">
</span>
Новая запись
</a>
</td></tr></table>
</td>
</tr></table>



<table cellpadding="3" cellspacing="2" border="1" style="border-collapse: collapse;" width="600">
	<tr>
		<td bgcolor="#585858" style="color: white; text-transform: uppercase; font-weight: bold;" width="40">ID</td>
		<td bgcolor="#585858" style="color: white; text-transform: uppercase; font-weight: bold;">Англ.</td>
		<td bgcolor="#585858" style="color: white; text-transform: uppercase; font-weight: bold;">Рус.</td>
		<td bgcolor="#585858" style="color: white; text-transform: uppercase; font-weight: bold;" width="150">&nbsp;</td>
	</tr>
<?php
	if ($this->data) foreach($this->data as $item)
		{
		if (@$bgcolor=='bgcolor="#e5e5e5"') {$bgcolor='bgcolor="#ffffff"';} else {$bgcolor='bgcolor="#e5e5e5"';}
			echo '	<tr>
						<td '.$bgcolor.'>'.$item->id.'</td>
						<td '.$bgcolor.'>'.$item->en_name.'</td>
						<td '.$bgcolor.'>'.$item->ru_name.'</td>
						<td '.$bgcolor.'>
							<a href="index.php?option=com_dict&layout=edit&id='.$item->id.'">Изменить</a>
							&nbsp;
							&nbsp;
							&nbsp;
							<a href="javascript:if (confirm(\'Запись будет удалена\')) document.location=\'index.php?option=com_dict&action=delete&id='.$item->id.'\'">Удалить</a>
						</td>
					</tr>';
		}
?>
</table>
</td></tr></table>