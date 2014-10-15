<?php if(!defined( '_JEXEC' ) ) die( 'Direct Access is not allowed.' );

?>
<link rel="stylesheet" type="text/css" href="components/com_manager/assets/style.css" />
<script type="text/javascript" src="components/com_manager/assets/script.js"></script>
<img class="preloader" src="components/com_manager/assets/preloader.gif" />
<div class="car_search_panel" >
	<div class="car_search">
		<img id="reset" src="components/com_manager/assets/reset.png" />
		<input type="text" name="car[search]" id="car_search" value="<?php echo $this->filter->search; ?>" />
		<img id="search_img" src="components/com_manager/assets/search.png" />
	</div>
	<div class="car_filter" >
		<div class="" >
			<div class="colls">
				<select name="car[marka]" id="car_marka" >
					<option value="">Марка</option>
					<?php
						foreach($this->car_marka_list as $marka){
							$sel = ($this->filter->marka == $marka->marka) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$marka->marka.'">'.$marka->marka.'</option>';
						}
					?>
				</select>
			</div>
			<div class="colls">
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
			<div class="colls">
				<select name="car[year1]" id="car_year1" >
					<option value="">Год выпуска от</option>
					<?php
						for($i = 1990; $i <= date("Y"); $i++){
							$sel = ($this->filter->year1 == $i) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select> 
			</div>
			<div class="colls">
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
		</div>
		<?php if (in_array($this->usertype, array(2,3))) { ?>
		<div class="">
				<div class="colls">
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
			<div class="colls">
				<ul class="adminmenu" >
					<li id="cars_page_li" class="active" style="display: none;">Автомобили</li>
					<li id="reports_page_li" class="active">Взаиморасчеты</li>
				</ul>
			</div>
		</div>
		<?php } ?>
		<div style="margin-top:5px;">
			<input type="checkbox" id="filtr_all" <?php if ($_GET['all'] == 'true') echo 'checked'; ?> class="chb filtr_el" /> Все&nbsp;&nbsp;
			<input type="checkbox" id="filtr_delivered" <?php if ($_GET['delivered'] == 'true') echo 'checked'; ?> class="chb filtr_el" /> Дост.&nbsp;&nbsp;
			<input type="checkbox" id="filtr_fresh" <?php if ($_GET['fresh'] == 'true') echo 'checked'; ?> class="chb filtr_el" /> В пути&nbsp;&nbsp;
			<input type="checkbox" id="filtr_sold" <?php if ($_GET['sold'] == 'true') echo 'checked'; ?> class="chb filtr_el" /> Проданные
		</div>
	</div>
</div>
<?php if (in_array($this->usertype, array(2,3))) { ?>
<div class="reports_page" >
	<div class="width28 inline">
		<label>Начало периода</label>
		<input id="date1" type="text" value="<?php echo date("d.m").'.'.(date("Y") - 1); ?>" />
	</div>
	<div class="width28 inline">
		<label>Конец периода</label>
		<input id="date2" type="text" value="<?php echo date("d.m.Y"); ?>" />
	</div>
	<input type="button" value="Отправить" id="report_send" />
	<div class="report_content"></div>
</div>
<?php } ?>
<div class="cars_page" >
	<div class="cars_list" >
	
	</div>
	<div class="add_btn" >
		<input type="button" id="add_btn" value="Показать еще" />
		<input type="hidden" id="limit" value="<?php echo $this->limit; ?>" />
	</div>
</div>