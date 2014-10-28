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
<form method="post" action="index.php?option=com_dict">
	<table>
		<tr><td>Англ.</td><td><input style="width:600px" type="text" name="en_name" value="<?php echo $this->data->en_name; ?>"/></td></tr>
		<tr><td>Рус.</td><td><input style="width:600px" type="text" name="ru_name" value="<?php echo $this->data->ru_name; ?>"/></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" value="Сохранить"/></td></tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->data->id; ?>"/>
	<input type="hidden" name="action" value="save"/>
</form>