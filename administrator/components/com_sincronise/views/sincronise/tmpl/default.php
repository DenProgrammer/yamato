<?php // no direct access
	defined('_JEXEC') or die('Restricted access'); 
?>
<a href="index.php?option=com_sincronise&view=config">Конфигурация</a>
<br>
<br>
<a href="index.php?option=com_sincronise&layout=cform&id=0">создать новую</a>
<table>
	<tr>
		<td>ID</td>
		<td>Наименование</td>
		<td>&nbsp;</td>
	</tr>
<?php
	$i=0;
	if ($this->data) foreach($this->data as $item)
		{
			$i++;
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><a href="index.php?option=com_sincronise&layout=tlist&pid=<?php echo $item->id; ?>&id=0"><?php echo $item->name; ?></a></td>
		<td>
			<!--<a href="index.php?option=com_sincronise&layout=cform&id=<?php echo $item->id; ?>">редактировать</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?option=com_sincronise&layout=cdelete&id=<?php echo $item->id; ?>">удалить</a>-->
		</td>
	</tr>
<?php
		}
?>
</table>