<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<a href="index.php?option=com_sincronise">К списку тарифных сеток</a>
<a href="index.php?option=com_sincronise&layout=tlist&pid=<?php echo $this->pid; ?>">К списку тарифов</a>
<form method="post" action="index.php?option=com_sincronise&layout=tlist&pid=<?php echo $this->pid; ?>">
	Цена <input type="text" name="tprice" value="<?php echo $this->data->price; ?>"/><br>
	Значение <input type="text" name="tvalue" value="<?php echo $this->data->value; ?>"/><br>
	Тип наценки 
	<select name="ttype">	
		<option <?php if ($this->data->type=='%') echo 'selected'; ?> value="%">%</option>
		<option <?php if ($this->data->type=='*') echo 'selected'; ?> value="*">фикс*</option>
	</select><br>
	<input type="submit" value="сохранить"/>
	<input type="hidden" name="action" value="save_tdata"/>
	<input type="hidden" name="actionid" value="<?php echo $this->data->id; ?>"/>
	<input type="hidden" name="actionpid" value="<?php echo $this->pid; ?>"/>
</form>