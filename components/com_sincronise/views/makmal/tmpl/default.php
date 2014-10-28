<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

	$i = $j = 0;
	$itemstr = '';
	$links = '';
	$items = $this->data->row->Value[5]->row;
	$edit = true;//($this->data->row->Value[8] == 1) ? false : true;
	
	if ($items) foreach($items as $it)
		{
			if ($j>0) $links .= ',';
			$links .= $it->Value[1].'___'.$it->Value[8];
			$j++;
			$itemstr .= '<tr>
					<td>'.$j.'</td>
					<td>'.$it->Value[9].'</td>
					<td>'.$it->Value[2].'</td>
					<td>'.$it->Value[3].'</td>
					<td>'.$it->Value[4].'</td>
					<td>'.$it->Value[5].'</td>';
			if ($edit)
				{
			$itemstr .= '<td><input name="RabotaLink[\''.$it->Value[1].'___'.$it->Value[8].'\']" type="checkbox" checked /></td>
				</tr>';
				}
			else
				{
					$itemstr .= '<td>Принято</td>
				</tr>';
				}
		}
?>
makmal
<form action="" method="post">
<table width="100%" border="0">
	<tr>
		<td>Номер наряда - <?php echo $this->data->row->Value[1]; ?></td>
		<td>Дата наряда - <?php echo date("d.m.Y H:i",strtotime($this->data->row->Value[2])); ?></td>
	</tr>
</table>
<table width=100%" border="1">
	<tr>
		<td>№</td>
		<td>Автомобиль</td>
		<td>Название услуги</td>
		<td>Кол-во</td>
		<td>Цена</td>
		<td>Сумма</td>
		<td>Утвердить/Отказатся</td>
	</tr>
	<?php echo $itemstr; ?>
	<?php if ($edit) { ?>
	<tr>
		<td colspan="6">&nbsp;</td>
		<td><input type="submit" value="Сохранить" /></td>
	</tr>
	<?php } ?>
</table>

<input type="hidden" name="all_links" value="<?php echo $links; ?>" />
<input type="hidden" name="save_link" value="<?php echo $this->data->row->Value[0]; ?>" />
</form>