<?php if(!defined( '_JEXEC' ) ) die( 'Direct Access is not allowed.' ); 
$user = JFactory::getUser();
?>
<link rel="stylesheet" type="text/css" href="components/com_manager/assets/style.css" />
<script type="text/javascript" src="components/com_manager/assets/script.js"></script>
<script>
jQuery(function($){
	$.get('index.php?option=com_sincronise&type=loadCost&tmpl=ajax',{link:'<?php echo $this->car->link; ?>'},function(data){
			$('.costValue').html(parseFloat(data)+' USD');
		})
})
</script>
<div class="car_search_panel" >
	<div class="car_search">
		<img id="reset" src="components/com_manager/assets/reset.png" />
		<input type="text" name="car[search]" id="car_search" value="<?php echo $this->filter->search; ?>" />
		<img id="search_img" src="components/com_manager/assets/search.png" />
	</div>
	<div class="car_filter" style="display: none;" >
		<div class="" >
			<div class="">
				<select name="car[marka]" id="car_marka" >
					<option value=""></option>
					<?php
						foreach($this->car_marka_list as $marka){
							$sel = ($this->filter->marka == $marka->marka) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$marka->marka.'">'.$marka->marka.'</option>';
						}
					?>
				</select>
			</div>
			<div class="">
				<select name="car[model]" id="car_model" >
					<option value="">Модель</option>
					<?php
						foreach($this->car_model_list as $model){
							$sel = ($this->filter->model == $model->model) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$model->model.'">'.$model->model.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="" >
				<select name="car[year1]" id="car_year1" >
					<option value="">Год выпуска от</option>
					<?php
						for($i = 1990; $i <= date("Y"); $i++){
							$sel = ($this->filter->year1 == $i) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select> 
				<select name="car[year2]" id="car_year2" >
					<option value="">Год выпуска до</option>
					<?php
						for($i = 1990; $i <= date("Y"); $i++){
							$sel = ($this->filter->year2 == $i) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
		</div>
		<?php if (in_array($this->usertype, array(2,3))) { ?>
		<div class="">
			<select name="car[cagent]" id="car_cagent" >
				<option value="">Контрагент</option>
				<?php
					foreach($this->car_cagents_list as $cagent){
						$sel = ($this->filter->cagent == $cagent->id) ? 'selected' : '';
						echo '<option '.$sel.' value="'.$cagent->id.'">'.$cagent->name.'</option>';
					}
				?>
			</select>
		</div>
		<?php } ?>
	</div>
</div>
<?php
		$main_image = $this->car->product_full_image;
?>
	<div>
		<a class="activebtn" href="index.php?option=com_manager&Itemid=32<?php echo $this->returnUrl; ?>" >Назад в поиск</a>
		<a class="activebtn" id="reset_main_list" href="#" >В главный список</a>
	</div>
	<div class="car_single">
		<?php if (in_array($this->usertype, array(2,3))) { ?>
		<ul class="adminmenu" >
			<li id="staged_page" class="active">Этапы доставки</li>
			<li id="images_page" class="active" style="display: none;" >Фотографии</li>
		</ul>
		<?php } ?>
		<div class="car_single_info" style="clear: both">
			<div class="" >
				<div style="float: left; text-align: left; width:300px;" >
					<div class="car_single_title " >
						<?php echo $this->car->marka.' '.$this->car->model.' '.$this->car->year; ?>
					</div>
					<div class="car_single_nomer " ><?php echo $this->car->NomerKuzov; ?></div>
					<div class="car_single_title " >Пробег : <?php echo $this->car->Probeg; ?></div>
					<?php if ($user->id > 0) { ?>
						<div class="car_single_title " >Поставщик : <?php echo $this->car->Postavshik; ?></div>
					<?php } ?>
				</div>
				<div style="float: right; text-align: right; width: 300px;" >
					<div class="car_single_price" >
						Цена на сайте : <?php echo round($this->car->price,2).' '.$this->car->currency; ?><br />
						Аукционная цена : <?php echo round($this->car->AukcionnayaCena,2).' '.$this->car->ValutaAukcionnoiCeny; ?><br />
						Цена продажи : <?php echo round($this->car->CenaProdaji,2).' '.$this->car->ValutaCenyProdaji; ?><br />
						<?php if ($this->usertype == 3) {
							echo 'Себестоимость : <span class="costValue">'.$this->car->Sebestoimost.' USD</span>';
						} ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (in_array($this->usertype, array(2,3))) { ?>
		<div class="car_single_staged" >
			<table border="0" class="etapdetail">
				<thead>
					<th>Дата</th>
					<th>Этап</th>
					<th>Средство</th>
				</thead>
				<tbody>
					<tr>
						<td><?php echo date("d.m.Y", strtotime($this->car->DataPokupki)); ?></td>
						<td>Куплен </td>
						<td> дней с момента покупки - <?php echo intval($this->car->DneiSMomentaPokupki); ?></td>
					</tr>
				<?php
					if ($this->car_stages) foreach($this->car_stages as $item) {
						$data = ($item->time > 0) ? date("d.m.Y", $item->time) : $data = ' - ';
						echo '<tr>
							<td>'.$data.'</td>
							<td>'.$item->DeliveryStage.'</td>
							<td>'.$item->DeliveryType.'</td>
						</tr>';
					}
				?>
				</tbody>
			</table>

		</div>
		<?php } ?>
		<div class="car_single_image" >
			<img src="<?php echo $main_image; ?>" />
			<?php 
				if ($this->car->images) {
					foreach($this->car->images as $image) {
						echo '<div id="imagecont_'.$image->file_id.'" class="imagecont">';
						echo '    <div class="deleteimage" data-fileid="'.$image->file_id.'" >X</div>';
						echo '    <img src="'.$image->file_url.'" />';
						echo '</div>';
					}
				}
			?>
			<br />
			<br />
			<fieldset>
				<legend>Добавить фото</legend>
				<form method="post" action="" enctype="multipart/form-data" >
					<input type="file" name="newimage" />
					<input type="submit" name="btnsaveimage" value="Загрузить фото" />
				</form>
			</fieldset>
		</div>
	</div>