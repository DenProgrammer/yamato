<?php // no direct access
	defined('_JEXEC') or die('Restricted access'); 
?>
<a href="index.php?option=com_sincronise">К списку тарифных сеток</a><br>
<?php echo $this->cat->name; ?><br>
<a href="index.php?option=com_sincronise&layout=tform&id=0&pid=<?php echo $this->cat->id; ?>">создать новую</a>
<table>
	<tr>
		<td>ID</td>
		<td>Цена</td>
		<td>Значение</td>
		<td>Тип</td>
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
		<td><?php echo $item->price; ?></td>
		<td><?php echo $item->value; ?></td>
		<td><?php if ($item->type=='*') echo 'фикс.'; else echo $item->type; ?></td>
		<td>
			<a href="index.php?option=com_sincronise&layout=tform&pid=<?php echo $this->cat->id; ?>&id=<?php echo $item->id; ?>">редактировать</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?option=com_sincronise&layout=tdelete&pid=<?php echo $this->cat->id; ?>&id=<?php echo $item->id; ?>">удалить</a>
		</td>
	</tr>
<?php
		}
?>
</table>