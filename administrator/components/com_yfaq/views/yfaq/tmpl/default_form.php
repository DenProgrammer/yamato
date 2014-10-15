<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
?>
<form method="post" action="index.php?option=com_yfaq">
	<table>
		<tr>
			<td>Имя</td>
			<td><?php echo $this->data->name; ?></td>
		</tr>
		<tr>
			<td>email</td>
			<td><?php echo $this->data->email; ?></td>
		</tr>
		<tr>
			<td>Вопрос</td>
			<td><?php echo $this->data->qwest; ?></td>
		</tr>
		<tr>
			<td>Состояние</td>
			<td>
				<select name="publication">
					<option <?php if ($this->data->publication == 1) echo 'selected'; ?> value="1">Опубликовано</option>
					<option <?php if ($this->data->publication == 0) echo 'selected'; ?> value="0">Не опубликовано</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Ответ</td>
			<td><textarea style="width:400px;height:100px;" name="answer"><?php echo $this->data->answer; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Сохранить"/>
				<input type="hidden" name="action" value="save"/>
				<input type="hidden" name="objid" value="<?php echo $this->data->id; ?>"/>
			</td>
		</tr>
	</table>
</form>