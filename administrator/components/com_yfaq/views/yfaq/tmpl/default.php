<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
?>
<table class="adminlist">
	<thead>
		<tr>
			<th>ID</th>
			<th>Дата</th>
			<th>Имя</th>
			<th>email</th>
			<th width="5%">состояние</th>
			<th>вопрос</th>
			<th>ответ</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php 
	if ($this->data) foreach($this->data as $row){
?>
	<tr>
		<td><?php echo $row->id; ?></td>
		<td><?php echo date("d.m.Y H:i",$row->cdate); ?></td>
		<td><?php echo $row->name; ?></td>
		<td><?php echo $row->email; ?></td>
		<td width="5%" align="center">
			<?php if ($row->publication==1) echo '<img src="images/tick.png"/>';else  echo '<img src="images/publish_x.png"/>'; ?>
		</td>
		<td><?php echo $row->qwest; ?></td>
		<td><?php echo $row->answer; ?></td>
		<td>
			<a href="index.php?option=com_yfaq&id=<?php echo $row->id; ?>">редактировать</a>
			<a href="javascript:if (confirm('Удалить вопрос?')) document.location='index.php?option=com_yfaq&id=<?php echo $row->id; ?>&action=delete';">удалить</a>
		</td>
	</tr>
<?php } ?>
	</tbody>
</table>