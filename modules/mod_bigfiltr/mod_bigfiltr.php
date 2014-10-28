<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

	$selmarka = JRequest::getVar('cm');
	$selrul = JRequest::getVar('rul');
	$find_text = JRequest::getVar('find_text');
	$selmodel = explode(';',JRequest::getVar('model'));
	$strmodel = $sep = '';
	foreach($selmodel as $m)
		{
			$masmodel[$m] = 1;
			$strmodel .= $sep.$m;
			$sep = ', ';
		}
		
	$db = JFactory::getDBO();
	$sql = 'SELECT DISTINCT `marka` FROM `#__vm_product` WHERE `product_publish` = \'Y\' AND `marka`!=\'NONE\' AND `product_type` = \'automobil\'';
	$db->setQuery($sql);
	$marka = $db->LoadObjectList();$i = 0;
	if ($marka) foreach($marka as &$row)
		{
			if (!$row->marka) continue;
			$models[$i]->cls = 'marka'.$i;
			$models[$i]->title = $row->marka;
			$sql = 'SELECT DISTINCT `model` FROM `#__vm_product` WHERE `product_publish` = \'Y\' AND `marka`=\''.$row->marka.'\' AND `product_type` = \'automobil\'';
			$db->setQuery($sql);
			$models[$i]->data = $db->LoadObjectList();
			$row->i = $i;
			$i++;
		}
		
	$rul = array('Левое'=>'rul_left','Правое'=>'rul_right');
?>
<div class="bigFilterWrap">
	<h3>Марка автомобиля</h3>
	<div class="se_emulation">
		<div class="se_head" onclick="open_optionlist('marka')">
			<div class="se_cinttitle">Не выбрано</div>
			<div class="se_arrow">
				<img style="vertical-align:bottom;" src="images/selectarrow.png"/>
			</div>
		</div>
		<div class="se_optionlist se_optionlistmarka"> 
			<div id="opt_markanul" class="se_option" onclick="setMarkas('markanul')">Не выбрано</div>
		<?php 
			if ($marka) foreach($marka as $r)
				{
					$sel = '';
					if ($selmarka == $r->marka) 
						{
							$changemarka = 'marka'.$r->i;
							$sel = 'class="selected"';
						}
					echo '<div id="opt_marka'.$r->i.'" class="se_option" '.$sel.' onclick="setMarkas(\'marka'.$r->i.'\')">'.$r->marka.'</div>';
				}
		?>
		</div>
	</div>
	<select id="bfr_markalist" onchange="setMarkas(this.value,true)" style="display:none;">
		<option value="">Не выбрано</option>
		<?php 
			if ($marka) foreach($marka as $r)
				{
					$sel = '';
					if ($selmarka == $r->marka) 
						{
							$changemarka = 'marka'.$r->i;
							$sel = 'selected';
						}
					echo '<option '.$sel.' value="marka'.$r->i.'">'.$r->marka.'</option>';
				}
		?>
	</select>
	<h3>Модель</h3>
	
	<div class="f_years">
		<div>Год с:</div>
		<select id="data_in">
			<?php 
				$st = ($_GET['data_in']) ? $_GET['data_in'] : 1990;
			
				for($i = 1990; $i <= date("Y"); $i++)
				{
					$sel = ($st == $i) ? 'selected' : '';
					echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
				}
			?>
		</select>
		<div>Год по:</div>
		<select id="data_out">
			<?php 
				$st = ($_GET['data_out']) ? $_GET['data_out'] : date("Y");
			
				for($i = 1990; $i <= date("Y"); $i++)
				{
					$sel = ($st == $i) ? 'selected' : '';
					echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
				}
			?>
		</select>
	</div>
	
	<div class="se_head" style="width:230px;">
		<div class="se_cinttitlemod" style="width:180px;">Не выбрано</div>
		<div class="se_arrow">
			<img style="vertical-align:bottom;" src="images/selectarrow.png"/>
		</div>
	</div>
	<div style="height:80px;overflow:auto;width:230px;border:solid 1px #d2d2d2;margin-top:-1px;margin-bottom:10px;">
	<?php 
		for($i=0;$i<count($models);$i++)
			{
				echo '<div class="'.$models[$i]->cls.' marks" style="margin-bottom:5px;">';
				foreach($models[$i]->data as $mrow)
					{
						$checked = ($masmodel[$mrow->model]) ? 'checked' : ''; 
						echo '<div><input onclick="selectModel()" '.$checked.' class="chb_models" type="checkbox" value="'.$mrow->model.'"/>'.$mrow->model.'</div>';
					}
				echo '</div>';
			}
	?>
	</div>
	
	<div style="margin-top:5px;">
		<table>
			<tr>
				<td>
					<h3>Положение руля</h3>
					<div class="se_emulation" style="width:150px;">
						<div class="se_head" onclick="open_optionlist('rul')" style="width:150px;">
							<div class="se_cinttitlerul" style="width:110px;">Не выбрано</div>
							<div class="se_arrow">
								<img style="vertical-align:bottom;" src="images/selectarrow.png"/>
							</div>
						</div>
						<div class="se_optionlist se_optionlistrul" style="width:150px;"> 
							<div id="opt_rul_nul" class="se_option" onclick="setRuls('rul_nul')">Не выбрано</div>
						<?php 
							foreach($rul as $k=>$v)
								{
									$sel = '';
									if ($selrul == $v) 
										{
											$changerul = $v;
											$sel = 'class="selected"';
										}
									echo '<div id="opt_'.$v.'" class="se_option" '.$sel.' onclick="setRuls(\''.$v.'\')">'.$k.'</div>';
								}
						?>
						</div>
					</div>
					<select id="bfr_rullist" onchange="setRuls(this.value,true)" style="display:none;">
						<option value="rul_nul">Не выбрано</option>
						<option value="rul_left">Левое</option>
						<option value="rul_right">Правое</option>
					</select>
				</td>
				<td><h3>Ключевые слова</h3>
					<input type="text" id="bfr_find_text" style="width:90px;height:19px;" onchange="setModel()" value="<?php echo $find_text; ?>"/>
				</td>
				<td style="vertical-align:bottom;"><input type="button" id="bfr_find_btn" value="Найти" onclick="setModel()"/></td>
			</tr>
		</table>
	</div>
</div>
<script>
	function open_optionlist(id)
		{
			jQuery(".se_optionlist"+id).css("display","block").attr('rel','open');
			return false;
		}


	jQuery("document").ready(function(){
		<?php if ($changemarka) { ?>setMarkas('<?php echo $changemarka ?>',false);<?php } ?>
		<?php if ($changerul) { ?>setRuls('<?php echo $changerul; ?>',false);<?php } ?>
		selectModel();
		jQuery('.se_optionlist').attr('rel','close');
		
		jQuery(document).mouseup(function (e) {
			var container = jQuery(".se_optionlist");
			if (container.has(e.target).length === 0){
				jQuery(".se_optionlist").css('display','none');
			}
		});
	});
	var findurl = '';
	function setMarkas(id,rmv)
		{
			jQuery(".marks").css("display","none");
			jQuery("."+id).css("display","block");
			
			jQuery(".se_cinttitle").html(jQuery("#opt_"+id).html());
			jQuery("#bfr_markalist option[value="+id+"]").attr("selected","selected");
			jQuery(".se_optionlist").css("display","none");
			
			if (rmv) jQuery("input.chb_models").removeAttr("checked");
			jQuery(".se_cinttitlemod").html('Не выбрано');
			return false;
		}
	function selectModel()
		{
			var strmodel = '';
			var sep = '';
			jQuery("input.chb_models:checked").each(function(i,elem){
				strmodel += sep + jQuery(this).attr("value");
				sep = ', ';
			});
			if (strmodel == '') strmodel = 'Не выбрано';
			jQuery(".se_cinttitlemod").html(strmodel);
			return false;
		}
	function setRuls(id,rmv)
		{
			jQuery(".ruls").css("display","none");
			jQuery("."+id).css("display","block");
			
			jQuery(".se_cinttitlerul").html(jQuery("#opt_"+id).html());
			jQuery("#bfr_rullist option[value="+id+"]").attr("selected","selected");
			jQuery(".se_optionlistrul").css("display","none");
			return false;
		}
	function setModel()
		{
			var strmodel = '';
			var sep = '';
			jQuery("input.chb_models:checked").each(function(i,elem){
				strmodel += sep + jQuery(this).attr("value");
				sep = ';';
			});
			var marka = jQuery("#bfr_markalist option:selected").html();
			if (marka == 'Не выбрано') marka = '';
			var rul = jQuery("#bfr_rullist option:selected").val();
			var find_text = jQuery("#bfr_find_text").val();
			var data_in = jQuery("#data_in").val();
			var data_out = jQuery("#data_out").val();
			
			var url = 'index.php?option=com_virtuemart&Itemid=2&cm='+marka+'&model='+strmodel+'&rul='+rul+'&data_in='+data_in+'&data_out='+data_out;
			if (find_text) url += '&find_text='+find_text;
			
			document.location = url;
			return false;
		}
	function clearModel()
		{
			document.location = 'index.php';
		}
</script>