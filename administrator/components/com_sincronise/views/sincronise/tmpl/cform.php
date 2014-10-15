<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<a href="index.php?option=com_sincronise">К списку тарифных сеток</a>
<form method="post" action="index.php?option=com_sincronise">
	<input type="text" name="cname" value="<?php echo $this->data->name; ?>"/>
	<input type="submit" value="сохранить"/>
	<input type="hidden" name="action" value="save_cdata"/>
	<input type="hidden" name="actionid" value="<?php echo $this->data->id; ?>"/>
</form>